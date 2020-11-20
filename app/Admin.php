<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Comment;

class Admin extends Authenticatable
{
    use Notifiable;
    protected $guard="admin";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','job_title','city','township','address'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function comments()
    {
        return $this->morphMany('App\Comment','commendable');
    }
    public function ments()
    {
        return $this->hasMany('App\Comment','user_id');
    }
}
