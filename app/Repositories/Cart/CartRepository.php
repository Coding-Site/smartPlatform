<?php
namespace App\Repositories\Cart;

use App\Helpers\ApiResponse;
use App\Models\Book\Book;
use App\Models\Cart\Cart;
use App\Models\Course\Course;
use App\Models\Package\Package;
use App\Models\Subscription\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Auth;

class CartRepository
{
    public function getCart(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user();
            return $user->cart()->first();
        } else {
            $cartToken = $request->cookie('cart_token');
            return Cart::where('cart_token', $cartToken)->first();
        }
    }

    public function createCartForGuest($cartToken)
    {
        return Cart::firstOrCreate(['cart_token' => $cartToken]);
    }

    public function createCartForUser($userId)
    {
        return Cart::create(['user_id' => $userId]);
    }

    public function addCourseToCart($cart, $courseId, $price)
    {
        $course = Course::find($courseId);

        if(auth()->check()){
            $existingSubscription = Subscription::where('user_id', Auth::user()->id)
                ->where('course_id', $courseId)
                ->where('is_active', true)
                ->first();

            if($existingSubscription) throw new Exception('Already Subscribed');
        }

        if (!$course) {
            throw new Exception('Course not found');
        }

        $cartItem = $cart->items()->updateOrCreate(
            ['course_id' => $courseId],
            ['price' => $price, 'quantity' => 1]
        );

        return $cartItem;
    }

    public function addBookToCart($cart, $bookId, $quantity)
    {
        $book = Book::find($bookId);
        if (!$book) {
            throw new Exception('Book not found');
        }

        $cartItem = $cart->items()->updateOrCreate(
            ['book_id' => $bookId],
            ['price' => $book->price, 'quantity' => $quantity]
        );

        return $cartItem;
    }

    public function addPackageToCart($cart,$packageId){
        $package = Package::find($packageId);

        if (!$package) {
            throw new Exception('Package not found');
        }

        $cartItem = $cart->items()->updateOrCreate(
            ['package_id' => $packageId],
            ['price' => $package->price, 'quantity' => 1]
        );

        return $cartItem;

    }

    public function updateBookQuantity($cart, $bookId, $quantity)
    {
        $cartItem = $cart->items()->where('book_id', $bookId)->first();
        if (!$cartItem) {
            throw new Exception('Book not found in cart');
        }

        $book = Book::find($bookId);
        if (!$book) {
            throw new Exception('Book not found');
        }

        if ($book->quantity < $cartItem->quantity + $quantity) {
            throw new Exception('Insufficient stock for this book');
        }

        $cartItem->quantity += $quantity;
        $cartItem->save();

        return $cartItem;
    }

    public function removeItemFromCart($cart, $itemType, $itemId)
    {
        $cartItem = $cart->items()->where("{$itemType}_id", $itemId)->first();
        if (!$cartItem) {
            throw new Exception(ucwords($itemType) . ' not found in cart');
        }

        $cartItem->delete();
    }

    public function getCoursePrice(Request $request, $course)
    {
        $priceType = $request->input('subscription_type', 'per_term');
        if ($priceType === 'per_term' && $course->term_price !== null) {
            return $course->term_price;
        }
        if ($priceType === 'per_month' && $course->monthly_price !== null) {
            return $course->monthly_price;
        }

        throw new Exception('Price is unavailable for the selected option');
    }
}

