<?php

namespace FauziDhuhuri\SimpleCart\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed add(array $item)
 * @method static mixed update(string $id, array $data)
 * @method static mixed remove($id)
 * @method static array content()
 * @method static void clear()
 * @method static int getCount()
 * 
 * @see \FauziDhuhuri\Cart\Cart
 */
class Cart extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cart';
    }
}