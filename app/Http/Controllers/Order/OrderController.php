<?php

namespace App\Http\Controllers\Order;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\CheckoutRequest;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order\Order;
use App\Repositories\Order\OrderRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $orderRepo;

    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    // public function checkout(CheckoutRequest $request)
    // {
    //     $data = $request->validated();
    //     DB::beginTransaction();

    //     try {
    //         $order = $this->orderRepo->createOrder($request);
    //         $subscriptionType = $request->input('subscription_type');

    //         // $paymentStatus

    //         foreach ($order->items as $orderItem) {
    //             if ($orderItem->course_id) {
    //                 $this->orderRepo->createSubscriptionCourse($orderItem->course_id, $order->user_id,$subscriptionType);
    //             }

    //             if($orderItem->book_id){
    //                 $cityDeliveryPrice = DB::table('cities')
    //                     ->where('id', $data['city_id'])
    //                     ->value('deliver_price') ?? 0;

    //                 $totalPrice = $order->total_price + $cityDeliveryPrice;
    //                 $this->createOrderBooks($data, [$orderItem->book_id => $orderItem->quantity], $totalPrice);
    //             }

    //             if ($orderItem->package_id ) {
    //                 $this->orderRepo->createSubscriptionPackage($orderItem->package_id, $order->user_id);
    //                 $packageBooks= $this->orderRepo->getBooksFromPackage($orderItem->package_id);

    //                 if(!empty($packageBooks)){

    //                     $cityDeliveryPrice = DB::table('cities')
    //                     ->where('id', $data['city_id'])
    //                     ->value('deliver_price') ?? 0;

    //                     $totalPrice = $order->total_price + $cityDeliveryPrice;

    //                     $orderBook = DB::table('order_books')->insertGetId([
    //                         'phone'       => $data['phone'],
    //                         'address'     => $data['address'],
    //                         'city_id'     => $data['city_id'],
    //                         'user_id'     => $data['user_id'],
    //                         'status'      => 'new',
    //                         'total_price' => $totalPrice,
    //                     ]);

    //                     foreach ($packageBooks as $bookId => $quantity) {

    //                         DB::table('order_book_details')->insert([
    //                             'order_book_id' => $orderBook,
    //                             'book_id'       => $bookId,
    //                             'quantity'      => $quantity,
    //                         ]);
    //                     }
    //                 }
    //             }
    //         }
    //         DB::commit();

    //         return ApiResponse::sendResponse(200, 'Order placed and subscription created successfully', $order);
    //     } catch (Exception $e) {
    //         DB::rollBack();

    //         return ApiResponse::sendResponse(500, 'Order placement failed: ' . $e->getMessage());
    //     }
    // }

    // private function createOrderBooks($data, $booksWithQuantities,$totalPrice)
    // {

    //     $orderBook = DB::table('order_books')->insertGetId([
    //         'phone'       => $data['phone'],
    //         'address'     => $data['address'],
    //         'city_id'     => $data['city_id'],
    //         'user_id'     => $data['user_id'],
    //         'status'      => 'new',
    //         'total_price' => $totalPrice,
    //     ]);

    //     foreach ($booksWithQuantities as $bookId => $quantity) {
    //         DB::table('order_book_details')->insert([
    //             'order_book_id' => $orderBook,
    //             'book_id'       => $bookId,
    //             'quantity'      => $quantity,
    //         ]);
    //     }
    // }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            return ApiResponse::sendResponse(403, 'Unauthorized access');
        }

        $order->load('items.course', 'items.note');

        return ApiResponse::sendResponse(200, 'Order details retrieved successfully', new OrderResource($order));
    }


    public function checkout(CheckoutRequest $request)
    {
        $data = $request->validated();
        DB::beginTransaction();

        try {
            $order = $this->orderRepo->createOrder($request);
            $subscriptionType = $data['subscription_type'];
            foreach ($order->items as $orderItem) {
                if ($orderItem->course_id) {
                    $this->orderRepo->createSubscriptionCourse($orderItem->course_id, $order->user_id, $subscriptionType);
                }

                if ($orderItem->book_id) {
                    $cityDeliveryPrice = $this->orderRepo->getCityDeliveryPrice($data['city_id']);
                    $totalPrice = $order->total_price + $cityDeliveryPrice;

                    $this->orderRepo->createOrderBooks($data, [$orderItem->book_id => $orderItem->quantity], $totalPrice);
                }

                if ($orderItem->package_id) {
                    $this->orderRepo->createSubscriptionPackage($orderItem->package_id, $order->user_id);
                    $packageBooks = $this->orderRepo->getBooksFromPackage($orderItem->package_id);

                    if (!empty($packageBooks)) {
                        $cityDeliveryPrice = $this->orderRepo->getCityDeliveryPrice($data['city_id']);
                        $totalPrice = $order->total_price + $cityDeliveryPrice;

                        $this->orderRepo->processPackageBooks($data, $packageBooks, $totalPrice);
                    }
                }
            }

            DB::commit();
            return ApiResponse::sendResponse(200, 'Order placed and subscription created successfully', $order);
        } catch (Exception $e) {
            DB::rollBack();
            return ApiResponse::sendResponse(500, 'Order placement failed: ' . $e->getMessage());
        }
    }


}
