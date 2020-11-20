<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','provider_id','provider'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function typeuser()
    {
        return $this->hasMany('App\Typeuser','user_id');
    }
    // public function categories()
    // {
    //     return $this->belongsTo('App\Category','category_id');
    // }
    // public function subcategories()
    // {
    //     return $this->hasMany('App\SubCategory','id');
    // }
}
