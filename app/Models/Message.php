<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public $fillable = [
        'name',
        'message',
        'email',
        'phone',
        'read_at',
        'subject'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'read_at'
    ];
}
