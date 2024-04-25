<?php

use App\Livewire\Pricing;
use App\Models\User;
use Illuminate\Support\Number;

beforeEach(function() {
    $this->pricing = config('stripe.pricing');
});

it('redirects to the register page when not signed in', function () {
    Livewire::test(Pricing::class)
        ->call('checkout', $this->pricing['monthly'])
        ->assertRedirect('register');
});

it('can create subscriptions', function () {
    $user = User::factory()->create();
    $product = config('stripe.product');

    $user->newSubscription($product, $this->pricing['monthly'])->create('pm_card_visa');

    expect($user->subscribed($product, $this->pricing['monthly']))->toBeTrue();
});
