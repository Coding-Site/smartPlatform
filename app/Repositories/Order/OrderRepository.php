<?php
namespace App\Repositories\Order;

use App\Models\Book\Book;
use App\Models\Cart\Cart;
use App\Models\Course\Course;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use App\Models\Package\Package;
use App\Models\Subscription\Subscription;
use App\Models\Teacher\TeacherProfit;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderRepository
{
    public function getCart(Request $request)
    {
        try {
            if (auth()->check()) {
                $user = auth()->user();
                return $user->cart()->first();
            } else {
                $cartToken = $request->cookie('cart_token');
                return Cart::where('cart_token', $cartToken)->first();
            }
        } catch (Exception $e) {
            throw new Exception('Error fetching the cart: ' . $e->getMessage());
        }
    }

    public function createOrder(Request $request, $data)
    {
        DB::beginTransaction();

        try {
            $cart = $this->getCart($request);
            if (!$cart || $cart->items->isEmpty()) {
                throw new Exception('Cart is empty');
            }

            $totalPrice = 0;

            $order = Order::create([
                'user_id'      => $cart->user_id,
                'order_number' => strtoupper(uniqid('ORD-')),
                'total_price'  => 0,
                'status'       => 'pending',
            ]);

            $orderItemsData = $cart->items->map(function ($item) use (&$totalPrice, $order) {
                $price = $item->price * $item->quantity;
                Log::info("step 1 ");
                if ($item->course_id) {
                    $course = $item->course;
                    Log::info("course  ");

                    $teacher = $course->teachers->first();
                    $teacherProfitRate = $teacher->video_profit_rate;
                    $profit = ($teacherProfitRate / 100) * $price;

                    DB::table('walet_transactions')->insert([
                        'walet_id'   => $teacher->walet->id,
                        'book_id'    => null,
                        'course_id'  => $item->course_id,
                        'profit'     => $profit,
                        'quantity'   => $item->quantity,
                        'order_id'   => $order->id,
                    ]);

                    DB::table('walets')->updateOrInsert(
                        ['teacher_id' => $teacher->id],
                        ['final_profit' => DB::raw("COALESCE(final_profit, 0) + {$profit}")]
                    );
                }

                if ($item->book_id) {
                    Log::info("book  ");

                    $book = $item->book;
                    $teacherProfitRate = $book->teacher->book_profit;
                    $profit = $teacherProfitRate  *  $item->quantity;
                    DB::table('walet_transactions')->insert([
                        'walet_id'   => $book->teacher->walet->id,
                        'book_id'    => $book->id,
                        'course_id'  => null,
                        'profit'     => $profit,
                        'quantity'   => $item->quantity,
                        'order_id'   => $order->id,
                    ]);

                    DB::table('walets')->updateOrInsert(
                        ['teacher_id' => $book->teacher->id],
                        ['final_profit' => DB::raw("COALESCE(final_profit, 0) + {$profit}")]
                    );
                }

                if ($item->package_id) {
                    $package = Package::find($item->package_id);
                    if ($package) {
                        foreach ($package->courses as $course) {
                            Log::info("package course  ");

                            $teacher = $course->teachers->first();
                            $teacherProfitRate = $teacher->video_profit_rate;
                            $courseProfit = ($teacherProfitRate / 100) * $course->monthly_price * $item->quantity;

                            DB::table('walet_transactions')->insert([
                                'walet_id'   => $teacher->walet->id,
                                'book_id'    => null,
                                'course_id'  => $course->id,
                                'profit'     => $courseProfit,
                                'quantity'   => $item->quantity,
                                'order_id'   => $order->id,
                            ]);

                            DB::table('walets')->updateOrInsert(
                                ['teacher_id' => $teacher->id],
                                ['final_profit' => DB::raw("COALESCE(final_profit, 0) + {$courseProfit}")]
                            );
                        }
                        foreach ($package->books as $book) {
                            Log::info("package book  ");

                            $teacherProfitRate = $book->teacher->book_profit;
                            $profit = $teacherProfitRate  *  $item->quantity;

                            DB::table('walet_transactions')->insert([
                                'walet_id'   => $book->teacher->walet->id,
                                'book_id'    => $book->id,
                                'course_id'  => null,
                                'profit'     => $profit,
                                'quantity'   => $item->quantity,
                                'order_id'   => $order->id,
                            ]);

                            DB::table('walets')->updateOrInsert(
                                ['teacher_id' => $book->teacher->id],
                                ['final_profit' => DB::raw("COALESCE(final_profit, 0) + {$profit}")]
                            );
                        }
                    }
                }

                $totalPrice += $price;

                return [
                    'order_id'   => $order->id,
                    'course_id'  => $item->course_id,
                    'book_id'    => $item->book_id,
                    'package_id' => $item->package_id,
                    'quantity'   => $item->quantity,
                    'price'      => $price,
                ];
            })->toArray();

            OrderItem::insert($orderItemsData);
            $order->update(['total_price' => $totalPrice]);

            $cart->items()->delete();

            DB::commit();
            return $order;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function createGuestOrder($data){
        DB::beginTransaction();
        try {
            $validated = $data;

            $totalPrice = 0;

            $books = Book::whereIn('id', array_column($validated['books'], 'id'))->get();
            $bookQuantities = collect($validated['books'])->keyBy('id');

            foreach ($books as $book) {
                $quantity = $bookQuantities[$book->id]['quantity'];
                $totalPrice += $book->price * $quantity;
            }

            $order = Order::create([
                'order_number' => strtoupper(uniqid('ORD-')),
                'status'       => 'pending',
                'total_price'  => $totalPrice,
            ]);
            // dd($order);
            foreach ($books as $book) {
                $quantity = $bookQuantities[$book->id]['quantity'];
                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $book->id,
                    'quantity' => $quantity,
                    'price' => $book->price,
                ]);
            }

            DB::commit();
            return $order;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public function createSubscriptionCourse($courseId, $userId,$type)
    {
        $course = Course::findOrFail($courseId);

        $subscriptionType = $type;
        $startDate = now();
        $endDate = $subscriptionType === 'per_month'
            ? $startDate->copy()->addMonth()
            : $course->term_end_date;

        Subscription::create([
            'user_id'           => $userId,
            'course_id'         => $courseId,
            'subscription_type' => $subscriptionType,
            'start_date'        => $startDate,
            'end_date'          => $endDate,
            'is_active'         => true,
        ]);
    }

    public function createSubscriptionPackage($packageId, $userId)
    {
        $package = Package::findOrFail($packageId);
        $startDate = now();
        $endDate = $package->expiry_day;

        Subscription::create([
            'user_id'           => $userId,
            'package_id'        => $packageId,
            'subscription_type' => 'per_semester',
            'start_date'        => $startDate,
            'end_date'          => $endDate,
            'is_active'         => true,
        ]);
    }

    public function getBooksFromPackage($packageId)
    {
        return DB::table('book_package')
            ->where('package_id', $packageId)
            ->get(['book_id', 'quantity'])
            ->mapWithKeys(function ($item) {
                return [$item->book_id => $item->quantity];
            })
            ->toArray();
    }

    public function createOrderBooks(array $data, array $booksWithQuantities)
    {
        $orderBook = DB::table('order_books')->insertGetId([
            'phone'       => $data['phone'],
            'address'     => $data['address'],
            'city_id'     => $data['city_id'],
            'user_id'     => $data['user_id'] ?? null,
            'name'        => Auth::user()->name ?? $data['name'],
            'status'      => 'new',
        ]);

        $orderBookDetails = collect($booksWithQuantities)->map(function ($quantity, $bookId) use ($orderBook) {
            return [
                'order_book_id' => $orderBook,
                'book_id'       => $bookId,
                'quantity'      => $quantity,
            ];
        })->toArray();

        DB::table('order_book_details')->insert($orderBookDetails);
    }

    public function getCityDeliveryPrice(int $cityId): float
    {
        return DB::table('cities')
            ->where('id', $cityId)
            ->value('deliver_price') ?? 0;
    }

    public function processPackageBooks(array $data, array $packageBooks)
    {
        $orderBook = DB::table('order_books')->insertGetId([
            'phone'       => $data['phone'],
            'address'     => $data['address'],
            'city_id'     => $data['city_id'],
            'user_id'     => $data['user_id'] ?? null,
            'name'        => Auth::user()->name ?? $data['name'],
            'status'      => 'new',
            // 'total_price' => $totalPrice,
        ]);

        $orderBookDetails = collect($packageBooks)->map(function ($quantity, $bookId) use ($orderBook) {
            return [
                'order_book_id' => $orderBook,
                'book_id'       => $bookId,
                'quantity'      => $quantity,
            ];
        })->toArray();

        DB::table('order_book_details')->insert($orderBookDetails);
    }

}
