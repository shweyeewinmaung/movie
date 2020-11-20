<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subtitle extends Model
{
	protected $fillable = [
        'movie_id','subtitle_name','subtitle_file' 
    ];
      
   
}
