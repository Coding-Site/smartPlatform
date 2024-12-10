<?php

namespace App\Http\Controllers\Order;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order\Order;
use App\Repositories\Order\OrderRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $orderRepo;

    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            return ApiResponse::sendResponse(403, 'Unauthorized access');
        }

        $order->load('items.course', 'items.note');

        return ApiResponse::sendResponse(200, 'Order details retrieved successfully', new OrderResource($order));
    }

    public function checkout(Request $request)
    {
        DB::beginTransaction();

        try {
            $order = $this->orderRepo->createOrder($request);
            $subscriptionType = $request->input('subscription_type');

            // $paymentStatus


            foreach ($order->items as $orderItem) {
                if ($orderItem->course_id) {
                    $this->orderRepo->createSubscriptionCourse($orderItem->course_id, $order->user_id,$subscriptionType);
                }

                if ($orderItem->package_id) {
                    $this->orderRepo->createSubscriptionPackage($orderItem->package_id, $order->user_id);
                    $packageBooks= $this->orderRepo->getBooksFromPackage($orderItem->package_id);
                    dd($packageBooks);
                    // add to order book table --> mandub
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
