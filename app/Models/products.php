<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class products extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';
    public const STATUS_NO = 0;
    public const STATUS_YES = 1;

    public static $status = [
        self::STATUS_NO => 'Inactive',
        self::STATUS_YES => 'Active',
    ];
    protected $fillable = [
        'name',
        'image',
        'price',
        'quantity',
        'status',
        'description',
        'sub_categories_id',
        'date_of_manufacture',
        'expiry',
        'hot',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function sub_categories()
    {
        return $this->belongsTo(sub_categories::class);
    }
    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }
    public function cart()
    {
        return $this->belongsTo(cart::class);
    }
}
