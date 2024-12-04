<?php

namespace App\Http\Controllers\Order;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderResource;
use Illuminate\Http\Request;

class DashboardOrderController extends Controller
{


    public function index()
    {
        $orders = auth()->user()->orders()->with('items.course', 'items.book')->get();

        return ApiResponse::sendResponse(200, 'Orders retrieved successfully',  OrderResource::collection($orders));
    }
}
