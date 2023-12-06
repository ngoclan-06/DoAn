<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageKh extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'message_kh';
    public const STATUS_NO = 0;
    public const STATUS_YES = 1;

    public static $status = [
        self::STATUS_NO => 'Inactive',
        self::STATUS_YES => 'Active',
    ];
    public $fillable = [
        'name',
        'message',
        'image',
        'status',
        'read_at',
        'user_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'read_at',
        'deleted_at'
    ];

    // Định nghĩa quan hệ nhiều-một với Message
    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    // Định nghĩa quan hệ nhiều-một với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
