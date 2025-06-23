<?php

use Tests\TestCase;
use FauziDhuhuri\SimpleCart\Facades\Cart;

it('can add item to cart', function () {
    Cart::add([
        'id' => 1,
        'name' => 'Test Product',
        'price' => 100,
        'quantity' => 2
    ]);

    expect(Cart::content())->toHaveCount(1)
        ->and(Cart::count())->toBe(2)
        ->and(Cart::subtotal())->toBe(200);
});

it('can update item quantity', function () {
    Cart::add(['id' => 1, 'name' => 'Test', 'price' => 100, 'quantity' => 1]);
    
    Cart::update(1, ['quantity' => 3]);
    
    expect(Cart::getItem(1)['quantity'])->toBe(3)
        ->and(Cart::subtotal())->toBe(300);
});

it('can remove item from cart', function () {
    Cart::add(['id' => 1, 'name' => 'Test', 'price' => 100, 'quantity' => 1]);
    
    Cart::remove(1);
    
    expect(Cart::content())->toBeEmpty();
});