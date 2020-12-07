<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
	protected $dates = [
        'converted_for_streaming_at',
    ];
 
    //protected $guarded = [];

	protected $fillable = [
        'episode_name','moviename_id','season_number','video_file','disk','stream_path','processed','converted_for_streaming_at' 
    ];
      
    public function subtitles()
    {
        return $this->hasMany('App\Subtitle','movie_id');
    }
     public function movienames()
    {
        return $this->belongsTo('App\MovieName','moviename_id');
    }
}
