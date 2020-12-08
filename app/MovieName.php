<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovieName extends Model
{
	protected $fillable = [
        'subcategory_id','category_id','name','prefix_for_movie','movie_file','outline','episode','show_in_slider','status'
    ];
    
    public function subcategories()
    {
        return $this->belongsTo('App\SubCategory','subcategory_id');
    }
     public function categories()
    {
        return $this->belongsTo('App\Category','category_id');
    }
    public function cat()
    {
        return $this->hasMany('App\Category','category_id');
    }
    
}
