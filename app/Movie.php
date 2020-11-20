<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
	protected $fillable = [
        'episode_name','moviename_id','season_number','video_file' 
    ];
      
    public function subtitles()
    {
        return $this->hasMany('App\Subtitle','movie_id');
    }
}
