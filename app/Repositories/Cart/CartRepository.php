<?php
namespace App\Repositories\Cart;

use App\Models\Cart\Cart;
use App\Models\Course\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;

class CartRepository
{
    public function getCart(Request $request)
    {
        try {
            if (auth()->check()) {
                $user = auth()->user();
                return $user->cart()->first();
            } else {
                $cartToken = $request->cookie('cart_token');
                return Cart::where('cart_token', $cartToken)->first();
            }
        } catch (Exception $e) {
            throw new Exception('Error fetching the cart: ' . $e->getMessage());
        }
    }

    public function createOrUpdateCartItem($cart, $itemType, $itemId, Request $request)
    {
        try {
            if (!in_array($itemType, ['course', 'note'])) {
                throw new Exception('Invalid item type');
            }

            $item = $this->findItem($itemType, $itemId);
            if (!$item) {
                throw new Exception(ucfirst($itemType) . ' not found');
            }

            $price = $this->getItemPrice($itemType, $item, $request);
            if (!$price) {
                throw new Exception('Price is unavailable for this item');
            }

            $cartItemData = [
                'price'    => $price,
                'quantity' => $itemType === 'course' ? 1 : $request->input('quantity', 1),
            ];

            return $cart->items()->updateOrCreate(
                ['course_id' => $itemId],
                $cartItemData
            );
        } catch (Exception $e) {
            throw new Exception('Error adding/updating item in cart: ' . $e->getMessage());
        }
    }

    private function findItem($itemType, $itemId)
    {
        return $itemType === 'course' ? Course::find($itemId) :  0; ///Book::find($itemId);
    }

    private function getItemPrice($itemType, $item, Request $request)
    {
        if ($itemType === 'course') {
            return $this->getCoursePrice($request, $item);
        }

        return $item->price;
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

    public function createCartForGuest($cartToken)
    {
        try {
            return Cart::firstOrCreate(['cart_token' => $cartToken]);
        } catch (Exception $e) {
            throw new Exception('Error creating cart for guest: ' . $e->getMessage());
        }
    }

    public function createCartForUser($userId)
    {
        try {
            return Cart::create(['user_id' => $userId]);
        } catch (Exception $e) {
            throw new Exception('Error creating cart for user: ' . $e->getMessage());
        }
    }
}
