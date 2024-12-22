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

            $orderItemsData = $cart->items->map(function ($item) use ($cart, &$totalPrice, $order, $data) {
                $profit = 0;
                $price = 0;

                if ($item->course_id) {
                    $totalPrice += $item->price * $item->quantity;
                    $teacherProfitRate = $item->course->teacher->teacher_profit_rate;
                    $profit = ($teacherProfitRate / 100) * $item->price * $item->quantity;

                    $this->createTeacherProfit(
                        $item->course->teacher_id,
                        null,
                        $item->course_id,
                        $profit,
                        $item->quantity,
                        $order->id
                    );
                }

                if ($item->book_id) {
                    $totalPrice += $item->price * $item->quantity;
                    $book = $item->book;
                    $cost = ($book->paper_price * $book->paper_count) + $book->covering_price;
                    $teacherProfitRate = $book->teacher->teacher_profit_rate;
                    $profit = ($teacherProfitRate / 100) * ($book->price - $cost) * $item->quantity;

                    $this->createTeacherProfit(
                        $book->teacher_id,
                        $book->id,
                        null,
                        $profit,
                        $item->quantity,
                        $order->id
                    );
                }

                if ($item->package_id) {
                    $package = Package::find($item->package_id);
                    if ($package) {
                        $courseItems = $package->courses;
                        $bookItems = $package->books;

                        $totalPrice += $package->price * $item->quantity;

                        foreach ($courseItems as $course) {
                            $price += $course->monthly_price;

                            $teacherProfitRate = $course->teacher->teacher_profit_rate;
                            $profit = ($teacherProfitRate / 100) * $course->monthly_price * $item->quantity;

                            $this->createTeacherProfit(
                                $course->teacher_id,
                                null,
                                $course->id,
                                $profit,
                                $item->quantity,
                                $order->id
                            );
                        }

                        foreach ($bookItems as $book) {
                            $cost = ($book->paper_price * $book->paper_count) + $book->covering_price;
                            $teacherProfitRate = $book->teacher->teacher_profit_rate;
                            $profit = ($teacherProfitRate / 100) * ($book->price - $cost) * $item->quantity;

                            $this->createTeacherProfit(
                                $book->teacher_id,
                                $book->id,
                                null,
                                $profit,
                                $item->quantity,
                                $order->id
                            );
                        }
                    }
                }

                return [
                    'order_id'   => $order->id,
                    'course_id'  => $item->course_id,
                    'book_id'    => $item->book_id,
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

    private function createTeacherProfit($teacherId, $bookId, $courseId, $profit, $quantity, $orderId)
    {
        TeacherProfit::create([
            'teacher_id' => $teacherId,
            'book_id'    => $bookId,
            'course_id'  => $courseId,
            'profit'     => $profit ,
            'quantity'   => $quantity,
            'order_id'   => $orderId
        ]);
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
            'user_id'     => $data['user_id'],
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
            'user_id'     => $data['user_id'],
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
