<?php

namespace FauziDhuhuri\SimpleCart\Drivers;

use FauziDhuhuri\SimpleCart\Contracts\CartStorage;
use Illuminate\Support\Facades\Session;

class SessionStorage implements CartStorage
{
    public function get(string $identifier, string $instance = 'default')
    {
        return Session::get("cart.{$instance}.{$identifier}", []);
    }
    
    public function store(string $identifier, string $instance, array $content)
    {
        Session::put("cart.{$instance}.{$identifier}", $content);
    }
    
    public function forget(string $identifier, string $instance)
    {
        Session::forget("cart.{$instance}.{$identifier}");
    }
}