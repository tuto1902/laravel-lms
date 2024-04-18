<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;

class CheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $sessionId = $request->get('session_id');
        $user = $request->user();
 
        if ($sessionId !== null) {
            $session = Cashier::stripe()->checkout->sessions->retrieve($sessionId);
        
            if ($session->payment_status === 'paid') {
                $user->is_lifetime_member = true;
                $user->save();
                $user->subscription(config('stripe.product'))->cancelNow();
            }
        }

        return redirect()->route('courses');
    }
}
