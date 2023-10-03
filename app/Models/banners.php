<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class banners extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'banners';
    // status
    public const STATUS_NO = 0;
    public const STATUS_YES = 1;

    public static $status = [
        self::STATUS_NO => 'Inactive',
        self::STATUS_YES => 'Active',
    ];
    protected $fillable = [
        'title',
        'slug',
        'image',
        'description',
        'status'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
