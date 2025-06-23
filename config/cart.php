<?php 

return [
    'storage' => [
        'driver' => env('CART_STORAGE_DRIVER', 'database'), // session or database
    ],
    
    'instances' => [
        'default' => 'shopping-cart',
        'wishlist' => 'wishlist',
    ],
];