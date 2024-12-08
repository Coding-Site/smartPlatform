<?php

namespace App\Http\Controllers\Cart;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Cart\CartResource;
use App\Models\Book\Book;
use App\Models\Cart\Cart;
use App\Models\Course\Course;
use App\Repositories\Cart\CartRepository;
use Exception;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartRepo;

    public function __construct(CartRepository $cartRepo)
    {
        $this->cartRepo = $cartRepo;
    }

    public function addCourseToCart(Request $request, $courseId)
    {
        try {
            $cart = $this->getCartForUserOrGuest($request);
            $course = Course::find($courseId);
            $price = $this->cartRepo->getCoursePrice($request, $course);
            $cartItem = $this->cartRepo->addCourseToCart($cart, $courseId, $price);

            return ApiResponse::sendResponse(200, 'Course added to cart', $cartItem);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to add course to cart: ' . $e->getMessage());
        }
    }

    public function addBookToCart(Request $request, $bookId)
    {
        try {
            $cart = $this->getCartForUserOrGuest($request);
            $quantity = $request->input('quantity', 1);
            $cartItem = $this->cartRepo->addBookToCart($cart, $bookId, $quantity);

            return ApiResponse::sendResponse(200, 'Book added to cart', $cartItem);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to add book to cart: ' . $e->getMessage());
        }
    }

    public function addPackageToCart(Request $request, $packageId){
        try {
            $cart = $this->getCartForUserOrGuest($request);
            $cartItem = $this->cartRepo->addPackageToCart($cart, $packageId);
            return ApiResponse::sendResponse(200, 'Package added to cart', $cartItem);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to add Package to cart: ' . $e->getMessage());
        }
    }

    public function increaseBookQuantity(Request $request, $bookId)
    {
        try {
            $cart = $this->getCartForUserOrGuest($request);
            $cartItem = $this->cartRepo->updateBookQuantity($cart, $bookId, 1);

            return ApiResponse::sendResponse(200, 'Book quantity increased', $cartItem);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to increase book quantity: ' . $e->getMessage());
        }
    }

    public function decreaseBookQuantity(Request $request, $bookId)
    {
        try {
            $cart = $this->getCartForUserOrGuest($request);
            $cartItem = $this->cartRepo->updateBookQuantity($cart, $bookId, -1);

            return ApiResponse::sendResponse(200, 'Book quantity decreased', $cartItem);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to decrease book quantity: ' . $e->getMessage());
        }
    }

    public function removeBookFromCart(Request $request, $bookId)
    {
        try {
            $cart = $this->getCartForUserOrGuest($request);
            $this->cartRepo->removeItemFromCart($cart, 'book', $bookId);

            return ApiResponse::sendResponse(200, 'Book removed from cart');
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to remove book from cart: ' . $e->getMessage());
        }
    }

    public function removeCourseFromCart(Request $request, $courseId)
    {
        try {
            $cart = $this->getCartForUserOrGuest($request);
            $this->cartRepo->removeItemFromCart($cart, 'course', $courseId);

            return ApiResponse::sendResponse(200, 'Course removed from cart');
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to remove course from cart: ' . $e->getMessage());
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

