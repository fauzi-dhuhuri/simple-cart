<?php

namespace FauziDhuhuri\SimpleCart\Models;

use Illuminate\Database\Eloquent\Model;

class CartStorageModel extends Model
{
    protected $table = 'cart_storage';
    
    protected $fillable = [
        'identifier',
        'instance',
        'content'
    ];
    
    public $timestamps = true;
}