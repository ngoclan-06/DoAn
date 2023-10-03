<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order';

    protected $fillable = [
        'status',
        'total',
        'payment_id',
        'user_id',
        'fullname',
        'address',
        'phone',
        'email'
    ];

    protected $dates = [
        'date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function payment()
    {
        return $this->belongsTo(payment::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function order_detail()
    {
        return $this->hasMany(order_detail::class);
    }
}
