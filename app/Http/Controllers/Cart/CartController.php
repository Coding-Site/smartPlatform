<?php

namespace App\Http\Controllers\Cart;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Cart\CartResource;
use App\Models\Book\Book;
use App\Models\Cart\Cart;
use App\Models\Cart\CartItem;
use App\Models\Course\Course;
use App\Repositories\Cart\CartRepository;
use Dotenv\Exception\ValidationException;
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

    public function addCourseToCart(Request $request, $courseId)
    {
        try {
            $cart = $this->getCartForUserOrGuest($request);

            $course = Course::find($courseId);
            if (!$course) {
                return ApiResponse::sendResponse(404, 'Course not found');
            }

            $price = $this->getCoursePrice($request, $course);
            if (!$price) {
                return ApiResponse::sendResponse(400, 'Price is unavailable for this course');
            }

            $cartItem = $cart->items()->updateOrCreate(
                ['course_id' => $courseId],
                ['price' => $price, 'quantity' => 1]
            );

            return ApiResponse::sendResponse(200, 'Course added to cart', $cartItem);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to add course to cart: ' . $e->getMessage());
        }
    }

    public function addBookToCart(Request $request, $bookId)
    {
        try {
            $cart = $this->getCartForUserOrGuest($request);

            $book = Book::find($bookId);
            if (!$book) {
                return ApiResponse::sendResponse(404, 'Book not found');
            }

            $price = $book->price;
            if (!$price) {
                return ApiResponse::sendResponse(400, 'Price is unavailable for this book');
            }

            $cartItem = $cart->items()->updateOrCreate(
                ['book_id' => $bookId],
                ['price'   => $price, 'quantity' => $request->input('quantity', 1)]
            );

            return ApiResponse::sendResponse(200, 'Book added to cart', $cartItem);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to add book to cart: ' . $e->getMessage());
        }
    }

    public function increaseBookQuantity(Request $request, $bookId)
    {
        try {
            $cart = $this->getCartForUserOrGuest($request);

            $cartItem = $cart->items()->where('book_id', $bookId)->first();
            // dd($cartItem);
            if (!$cartItem) {
                return ApiResponse::sendResponse(404, 'Book not found in cart');
            }

            $book = Book::find($bookId);
            if (!$book) {
                return ApiResponse::sendResponse(404, 'Book not found');
            }

            if ($book->quantity < $cartItem->quantity + 1) {
                return ApiResponse::sendResponse(400, 'Insufficient stock for this book');
            }

            $cartItem->quantity += 1;
            $cartItem->save();

            return ApiResponse::sendResponse(200, 'Book quantity increased', $cartItem);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to increase book quantity: ' . $e->getMessage());
        }
    }

    public function decreaseBookQuantity(Request $request, $bookId)
    {
        try {
            $cart = $this->getCartForUserOrGuest($request);

            $cartItem = $cart->items()->where('book_id', $bookId)->first();
            if (!$cartItem) {
                return ApiResponse::sendResponse(404, 'Book not found in cart');
            }

            if ($cartItem->quantity > 1) {
                $cartItem->quantity -= 1;
                $cartItem->save();

                return ApiResponse::sendResponse(200, 'Book quantity decreased', $cartItem);
            } else {
                $cartItem->delete();
                return ApiResponse::sendResponse(200, 'Book removed from cart');
            }
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to decrease book quantity: ' . $e->getMessage());
        }
    }

    private function getCoursePrice(Request $request, $course)
    {
        try {
            $request->validate([
                'price_type' => ['nullable', 'in:term,monthly'],
            ]);

            $priceType = $request->input('price_type', 'term');
            if ($priceType === 'term' && $course->term_price !== null) {
                return $course->term_price;
            }
            if ($priceType === 'monthly' && $course->monthly_price !== null) {
                return $course->monthly_price;
            }

            throw new Exception('Price is unavailable for the selected term or monthly option');
        } catch (Exception $e) {
            throw new Exception('Error getting course price: ' . $e->getMessage());
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


    public function removeBookFromCart(Request $request, $bookId)
    {
        try {
            $cart = $this->getCartForUserOrGuest($request);
            $cartItem = $cart->items()->where('book_id', $bookId)->first();

            if (!$cartItem) {
                return ApiResponse::sendResponse(404, 'Book not found in cart');
            }

            $cartItem->delete();

            return ApiResponse::sendResponse(200, 'Book removed from cart');
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to remove book from cart: ' . $e->getMessage());
        }
    }

    public function removeCourseFromCart(Request $request, $courseId)
    {
        try {
            $cart = $this->getCartForUserOrGuest($request);

            $cartItem = $cart->items()->where('course_id', $courseId)->first();

            if (!$cartItem) {
                return ApiResponse::sendResponse(404, 'Course not found in cart');
            }

            $cartItem->delete();

            return ApiResponse::sendResponse(200, 'Course removed from cart');
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to remove course from cart: ' . $e->getMessage());
        }
    }



}
