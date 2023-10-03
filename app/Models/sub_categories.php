<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sub_categories extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUS_NO = 0;
    public const STATUS_YES = 1;

    public static $status = [
        self::STATUS_NO => 'Inactive',
        self::STATUS_YES => 'Active',
    ];
    protected $fillable = [
        'name',
        'slug',
        'image',
        'status',
        'categories_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function categories()
    {
        return $this->belongsTo(categories::class);
    }

    public function products(){
        return $this->hasMany(products::class);
    }
}
