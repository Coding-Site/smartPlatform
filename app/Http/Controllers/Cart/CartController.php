<?php

namespace App\Http\Controllers\Cart;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Cart\CartResource;
use App\Models\Cart\Cart;
use App\Models\Course\Course;
use App\Repositories\Cart\CartRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    protected $cartRepo;

    public function __construct(CartRepository $cartRepo)
    {
        $this->cartRepo = $cartRepo;
    }

    public function addToCart(Request $request, $itemType, $itemId)
    {
        try {
            if (!in_array($itemType, ['course', 'note'])) {
                return ApiResponse::sendResponse(400, 'Invalid item type');
            }

            $cart = $this->getCartForUserOrGuest($request);
            $cartItem = $this->cartRepo->createOrUpdateCartItem($cart, $itemType, $itemId, $request);

            return ApiResponse::sendResponse(200, ucfirst($itemType) . ' added to cart', $cartItem);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to add item to cart: ' . $e->getMessage());
        }
    }

    public function viewCart(Request $request)
    {
        try {
            $cart = $this->cartRepo->getCart($request);
            // dd($cart);
            if (!$cart || $cart->items->isEmpty()) {
                return ApiResponse::sendResponse(200, 'Cart is empty');
            }

            return ApiResponse::sendResponse(200, 'Cart retrieved successfully', new CartResource($cart));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to retrieve cart: ' . $e->getMessage());
        }
    }

    private function getCartForUserOrGuest(Request $request)
    {
        try {
            if (auth()->check()) {
                $user = auth()->user();
                return $user->cart ?? $this->cartRepo->createCartForUser($user->id);
            } else {
                $cartToken = $request->cookie('cart_token');
                return $this->cartRepo->createCartForGuest($cartToken);
            }
        } catch (Exception $e) {
            throw new Exception('Error fetching or creating cart: ' . $e->getMessage());
        }
    }



}
