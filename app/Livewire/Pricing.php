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
    }

    public function render()
    {
        return view('livewire.pricing');
    }
}
