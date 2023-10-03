<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class blog extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'blog';
    protected $fillable = [
        'name',
        'content',
        'image',
        'status',
        'users_id',
    ];
    protected $dates = [
        'createa_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments(){
        return $this->hasMany(comments::class)->whereNull('parent_id')->where('status','active')->with('user')->orderBy('id','DESC');
    }
    public function allComments(){
        return $this->hasMany(comments::class)->where('status','active');
    }
}
