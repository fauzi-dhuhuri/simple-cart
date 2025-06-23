<?php

namespace FauziDhuhuri\SimpleCart;

use Illuminate\Support\ServiceProvider;
use FauziDhuhuri\SimpleCart\Contracts\CartStorage;
use FauziDhuhuri\SimpleCart\Drivers\DatabaseStorage;
use FauziDhuhuri\SimpleCart\Drivers\SessionStorage;

class CartServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/cart.php', 'cart');
        
        $this->app->bind(CartStorage::class, function ($app) {
            return match (config('cart.storage.driver')) {
                'database' => new DatabaseStorage(),
                default    => new SessionStorage(),
            };
        });

        $this->app->singleton(Cart::class, function ($app) {
            return new Cart($app->make(CartStorage::class));
        });

        $this->app->alias(Cart::class, 'cart');
    }
    
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/cart.php' => config_path('cart.php'),
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ]);
    }
}