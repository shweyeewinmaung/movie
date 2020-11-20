<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Typeuser extends Model
{
    protected $fillable = [
        'user_id','typeofuser','start_date','end_date','status'
    ];

    // public function typeuser()
    // {
    //     return $this->belongsTo('App\Typeuser','user_id');
    // }
}
