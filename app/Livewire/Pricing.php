<?php

namespace App\Livewire;

use Livewire\Component;

class Pricing extends Component
{
    public array $pricing;

    public function mount()
    {
        $this->pricing = config('stripe.pricing');
    }

    public function checkout(string $pricingId)
    {
        if(auth()->guest()) {
            return $this->redirect('register');
        }

        // One off payment
        if ($pricingId == 'lifetime') {
            return auth()->user()->checkout([$this->pricing[$pricingId] => 1], [
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('courses'),
            ]);
        }

        // Recurrent payment
        return auth()->user()
            ->newSubscription(config('stripe.product'), $this->pricing[$pricingId])
            ->checkout([
                'success_url' => route('courses'),
                'cancel_url' => route('courses'),
            ]);
    }

    public function render()
    {
        return view('livewire.pricing');
    }
}
