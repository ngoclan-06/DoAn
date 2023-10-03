<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'cart_id',
        'price',
        'amount',
        'quantity'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    public function product()
    {
        return $this->belongsTo(products::class);
    }
}
