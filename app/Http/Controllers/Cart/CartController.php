<?php

namespace App\Http\Controllers\Cart;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Cart\Cart;
use App\Models\Course\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addToCart(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);

        if (auth()->check()) {
            $user = auth()->user();
            $cart = $user->cart ?? Cart::create(['user_id' => $user->id]);
        } else {
            $cartToken = $request->cookie('cart_token');
            $cart = Cart::firstOrCreate(['cart_token' => $cartToken]);
        }

        $cartItem = $cart->items()->updateOrCreate(
            ['course_id' => $courseId],
            ['quantity' => DB::raw('quantity + 1')]
        );
        return ApiResponse::sendResponse(200,'Course added to cart',$cartItem);
    }



    public function viewCart(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user();
            $cart = $user->cart()->with('items.course')->first();

            if (!$cart || $cart->items->isEmpty()) {
                return ApiResponse::sendResponse(200,'Cart is empty');
            }
                return ApiResponse::sendResponse(200,'Cart retrieved successfully',$cart);
        } else {

            $cartToken = $request->cookie('cart_token');

            if (!$cartToken) {
                return ApiResponse::sendResponse(200,'Cart is empty');
            }
            $cart = Cart::where('cart_token', $cartToken)
                ->with('items.course')
                ->first();

            if (!$cart || $cart->items->isEmpty()) {
                return ApiResponse::sendResponse(200,'Cart is empty');
            }

            return ApiResponse::sendResponse(200,'Cart retrieved successfully',$cart);
        }
    }



}
