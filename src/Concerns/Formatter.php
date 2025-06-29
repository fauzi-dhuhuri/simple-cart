<?php

namespace FauziDhuhuri\SimpleCart\Concerns;

trait Formatter
{
    /**
     * Format the given number
     */
    protected function numberFormat($value, $decimals = null, $decimalPoint = null, $thousandSeparator = null)
    {
        if (is_null($decimals)) {
            $decimals = config('cart.format.decimals', 2);
        }
        
        if (is_null($decimalPoint)) {
            $decimalPoint = config('cart.format.decimal_point', '.');
        }
        
        if (is_null($thousandSeparator)) {
            $thousandSeparator = config('cart.format.thousand_separator', ',');
        }

        return number_format($value, $decimals, $decimalPoint, $thousandSeparator);
    }
}