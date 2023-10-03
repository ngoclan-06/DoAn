<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class order_detail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order_detail';
    protected $fillable = [
        'price',
        'quantity',
        'products_id',
        'order_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function products()
    {
        return $this->belongsTo(products::class);
    }
    public function order()
    {
        return $this->belongsTo(order::class);
    }
}
