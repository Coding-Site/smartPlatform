<?php
namespace App\Repositories\Order;

use App\Models\Cart\Cart;
use App\Models\Course\Course;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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


}