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


    public function index()
    {
        $orders = auth()->user()->orders()->with('items.course', 'items.book')->get();

        return ApiResponse::sendResponse(200, 'Orders retrieved successfully',  OrderResource::collection($orders));
    }
    public function checkout(Request $request)
    {
        try {
            $order = $this->orderRepo->createOrder($request);
            return ApiResponse::sendResponse(200, 'Order placed successfully', $order);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Order placement failed'. $e->getMessage());
        }
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            return ApiResponse::sendResponse(403, 'Unauthorized access');
        }

        $order->load('items.course', 'items.note');

        return ApiResponse::sendResponse(200, 'Order details retrieved successfully', new OrderResource($order));
    }





}
