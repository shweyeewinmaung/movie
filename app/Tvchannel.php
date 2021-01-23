<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tvchannel extends Model
{
	protected $fillable = [
        'name','tvcategory_id','channel_image','channel_api'
    ];
    
    public function tvcategories()
    {
        return $this->belongsTo('App\TvCategory','tvcategory_id');
    }
}
