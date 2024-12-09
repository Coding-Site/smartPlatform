<?php
namespace App\Repositories\Order;

use App\Models\Cart\Cart;
use App\Models\Course\Course;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use App\Models\Package\Package;
use App\Models\Subscription\Subscription;
use Illuminate\Http\Request;
use Exception;
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

    public function createOrder(Request $request)
    {
        DB::beginTransaction();

        try {
            $cart = $this->getCart($request);
            if (!$cart || $cart->items->isEmpty()) {
                throw new Exception('Cart is empty');
            }

            $totalPrice = $cart->items->sum(function ($item) {
                return $item->price * $item->quantity;
            });

            $order = Order::create([
                'user_id'      => $cart->user_id,
                'order_number' => strtoupper(uniqid('ORD-')),
                'total_price'  => $totalPrice,
                'status'       => 'pending',
            ]);

            $orderItemsData = $cart->items->map(function ($item) use ($order) {
                return [
                    'order_id'  => $order->id,
                    'course_id' => $item->course_id,
                    'book_id'   => $item->book_id,
                    'package_id'=> $item->package_id,
                    'quantity'  => $item->quantity,
                    'price'     => $item->price,
                ];
            })->toArray();

            OrderItem::insert($orderItemsData);

            $cart->items()->delete();
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
        return DB::table('packages')
            ->where('package_id', $packageId)
            ->pluck('book_id')
            ->toArray();
    }

}
