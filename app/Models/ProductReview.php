<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;
    protected $table = 'product_reviews';
    protected $fillable = [
        'user_id',
        'products_id',
        'rate',
        'review',
        'status'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products(){
        return $this->belongsTo(products::class);
    }

    public function getAllReview(){
        return ProductReview::with('user')->paginate(10);
    }
    public function getAllUserReview(){
        return ProductReview::where('user_id',auth()->user()->id)->with('user')->paginate(10);
    }
}
