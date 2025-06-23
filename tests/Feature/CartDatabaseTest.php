<?php

use FauziDhuhuri\SimpleCart\Cart;
use FauziDhuhuri\SimpleCart\Drivers\DatabaseStorage;
use FauziDhuhuri\SimpleCart\Models\CartStorageModel;

it('stores cart in database', function () {
    // config()->set('cart.storage.driver', 'database');
    
    $cart = app(Cart::class);
    $cart->add([
        'id' => 1,
        'name' => 'Test Product',
        'price' => 100,
        'quantity' => 2
    ]);

    // Verifikasi data di database
    $this->assertDatabaseHas('cart_storage', [
        'identifier' => $cart->getIdentifier()
    ]);
    
    $storage = CartStorageModel::first();
    $content = json_decode($storage->content, true);
    
    expect($content)->toHaveKey('1')
        ->and($content[1]['quantity'])->toBe(2);
});