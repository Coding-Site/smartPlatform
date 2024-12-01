<?php

namespace App\Listeners;

use App\Models\Cart\Cart;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MergeCartOnLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event)
    {
        Log::info('merge');
        $user = $event->user;
        $cartToken = request()->cookie('cart_token');

        $guestCart = Cart::where('cart_token', $cartToken)->first();

        if ($guestCart) {

            $userCart = $user->cart ?? Cart::create(['user_id' => $user->id]);

            foreach ($guestCart->items as $item) {
                $userCart->items()->updateOrCreate(
                    ['course_id' => $item->course_id],
                    ['quantity' => DB::raw('quantity + ' . $item->quantity)]
                );
            }

            $guestCart->delete();
        }
    }
}
