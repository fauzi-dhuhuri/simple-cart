<?php

namespace FauziDhuhuri\SimpleCart\Drivers;

use FauziDhuhuri\SimpleCart\Contracts\CartStorage;
use FauziDhuhuri\SimpleCart\Models\CartStorageModel;

class DatabaseStorage implements CartStorage
{
    public function get(string $identifier, string $instance = 'default')
    {
        $cart = CartStorageModel::where([
            'identifier' => $identifier,
            'instance' => $instance
        ])->first();
        
        return $cart ? json_decode($cart->content, true) : [];
    }
    
    public function store(string $identifier, string $instance, array $content)
    {
        CartStorageModel::updateOrCreate(
            ['identifier' => $identifier, 'instance' => $instance],
            ['content' => json_encode($content)]
        );
    }
    
    public function forget(string $identifier, string $instance)
    {
        CartStorageModel::where([
            'identifier' => $identifier,
            'instance' => $instance
        ])->delete();
    }
}