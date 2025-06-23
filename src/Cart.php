<?php

namespace FauziDhuhuri\SimpleCart;

use FauziDhuhuri\SimpleCart\Contracts\CartStorage;
use Illuminate\Support\Str;
use Illuminate\Support\Number;
use Illuminate\Support\Arr;

class Cart
{
    protected $storage;
    protected $identifier;
    protected $instance = 'default';
    
    public function __construct(CartStorage $storage)
    {
        $this->storage = $storage;
        $this->identifier = auth()->id() ?? Str::random(40);
    }
    
    public function instance(string $instance)
    {
        $this->instance = $instance;
        return $this;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getInstance(): string
    {
        return $this->instance;
    }
    
    public function add(array $item)
    {
        $this->validateItem($item);

        $cart = $this->getCart();
        $item = $this->prepareItem($item);
        $id = Arr::get($item, 'id');
        
        if ($existingItem = Arr::get($cart, $id)) {
            $item['quantity'] += $existingItem['quantity'];
        }
        
        $cart = Arr::add($cart, $id, $this->calculateItemTotals($item));
        $this->saveCart($cart);
    }

    public function update(string $id, array $data)
    {
        $cart = $this->getCart();
        
        if (!Arr::has($cart, $id)) {
            throw new \Exception("Item not found in cart");
        }

        $item = Arr::get($cart, $id);
        
        if (Arr::has($data, 'quantity')) {
            $item['quantity'] = max(1, (int) $data['quantity']);
        }
        
        $cart = Arr::set($cart, $id, $this->calculateItemTotals($item));
        $this->saveCart($cart);
    }
    
    public function remove($id)
    {
        $cart = Arr::except($this->getCart(), [$id]);
        $this->saveCart($cart);
    }
    
    public function content()
    {
        return $this->getCart();
    }

    public function count()
    {
        return array_reduce(
            Arr::pluck($this->getCart(), 'quantity'), 
            fn($carry, $quantity) => $carry + $quantity, 
            0
        );
    }
    
    public function clear()
    {
        $this->storage->forget($this->identifier, $this->instance);
    }

    public function subtotal()
    {
        return array_reduce($this->getCart(), function($carry, $item) {
            return $carry + $item['price'] * $item['quantity'];
        }, 0);
    }
    
    public function total()
    {
        return $this->subtotal();
    }
    
    public function formattedSubtotal()
    {
        return Number::format($this->subtotal(), 2);
    }
    
    public function formattedTotal()
    {
        return Number::format($this->total(), 2);
    }

    public function getItem(string $id)
    {
        $cart = $this->getCart();
        return $cart[$id] ?? null;
    }

    protected function getCart()
    {
        return $this->storage->get($this->identifier, $this->instance);
    }
    
    protected function saveCart(array $content)
    {
        $this->storage->store($this->identifier, $this->instance, $content);
    }

    protected function validateItem(array $item)
    {
        if (!isset($item['id'], $item['price'], $item['quantity'])) {
            throw new \InvalidArgumentException('Cart item must contain id, price and quantity');
        }
        
        if ($item['quantity'] < 1) {
            throw new \InvalidArgumentException('Quantity must be at least 1');
        }
    }

    protected function prepareItem(array $item)
    {
        return array_merge([
            'options' => [],
            'attributes' => [],
        ], $item);
    }
    
    protected function calculateItemTotals(array $item)
    {
        return array_merge($item, [
            'subtotal' => Arr::get($item, 'price', 0) * Arr::get($item, 'quantity', 1),
            'formatted_price' => Number::format(Arr::get($item, 'price', 0), 2),
            'formatted_subtotal' => Number::format(
                Arr::get($item, 'price', 0) * Arr::get($item, 'quantity', 1), 
                2
            )
        ]);
    }
    
    public function mergeGuestCart()
    {
        if (auth()->check() && session()->has('cart')) {
            $guestCart = session()->get('cart');
            $userCart = $this->getCart();
            
            foreach ($guestCart as $instance => $items) {
                foreach ($items as $id => $item) {
                    $this->instance($instance)->add($item);
                }
            }
            
            session()->forget('cart');
        }
    }
}