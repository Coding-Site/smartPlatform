<?php

namespace App\Http\Controllers\Order;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\CheckoutRequest;
use App\Http\Requests\Checkout\GuestCheckoutRequest;
use App\Http\Resources\Order\OrderResource;
use App\Models\Book\Book;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;
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

    public function checkout(CheckoutRequest $request)
    {
        $data = $request->validated();
        DB::beginTransaction();

        try {
            $order = $this->orderRepo->createOrder($request, $data);

            $subscriptionType = $data['subscription_type'];
            foreach ($order->items as $orderItem) {
                if ($orderItem->course_id) {
                    $this->orderRepo->createSubscriptionCourse($orderItem->course_id, $order->user_id, $subscriptionType);
                }

                if ($orderItem->book_id) {
                    $this->orderRepo->createOrderBooks($data, [$orderItem->book_id => $orderItem->quantity]);
                }

                if ($orderItem->package_id) {
                    $this->orderRepo->createSubscriptionPackage($orderItem->package_id, $order->user_id);
                    $packageBooks = $this->orderRepo->getBooksFromPackage($orderItem->package_id);
                    if (!empty($packageBooks)) {
                        $this->orderRepo->processPackageBooks($data, $packageBooks);
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

    public function checkoutForGuest(GuestCheckoutRequest $request)
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $order = $this->orderRepo->createGuestOrder($data);

            $booksWithQuantities = [];
            foreach ($order->items as $orderItem) {
                if ($orderItem->book_id) {
                    $booksWithQuantities[$orderItem->book_id] = $orderItem->quantity;
                }
            }

            if (!empty($booksWithQuantities)) {
                $this->orderRepo->createOrderBooks($data, $booksWithQuantities);
            }

            DB::commit();
            return ApiResponse::sendResponse(200, 'Order created successfully', $order);
        } catch (Exception $e) {
            DB::rollBack();
            return ApiResponse::sendResponse(500, 'Order failed: ' . $e->getMessage());
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
