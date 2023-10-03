<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class categories extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'categories';
    // status
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
        'status'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function subCategories()
    {
        return $this->hasMany(sub_categories::class);
    }
    public function products()
    {
        return $this->hasManyThrough(products::class, sub_categories::class);
    }
}
