<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    //role
    public const ROLE_CUSTOMER = 0;
    public const ROLE_EMPLOYEE = 1;
    public const ROLE_ADMIN_ROOT = 2;

    public static $roles = [
        self::ROLE_CUSTOMER => 'Khách hàng',
        self::ROLE_EMPLOYEE => 'Nhân viên',
        self::ROLE_ADMIN_ROOT => 'Quản lý',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email_address',
        'phone',
        'image',
        'password',
        'address',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // Định nghĩa quan hệ một-nhiều với MessageKh
    public function messageKhs()
    {
        return $this->hasMany(MessageKh::class);
    }
}
