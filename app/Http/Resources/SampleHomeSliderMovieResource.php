<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Movie;
use App\Advertising;
use App\Avator;
use Carbon\Carbon;

class SampleHomeSliderMovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      $movie=Movie::with(['subtitles','movienames'])->where('moviename_id',$this->id)->orderBy('id', 'asc')->groupBy('season_number')->get();

      $aalist= Movie::with(['subtitles'])->where('moviename_id',$this->id)->get();
      
      $date = Carbon::now();
      $todaydate= $date->toDateString();
      $adslist=Advertising::where('from_date', '<=', "{$todaydate}")
              ->where('to_date', '>=', "{$todaydate}")->get(); 


      if($this->episode == '1')
      {
         return[
          'id' => $this->id,
          'name' => $this->name,
          'category_id' => $this->category_id,
          'category_name' => $this->categories->name,
          'subcategory_id' => $this->subcategory_id,
          'subcategory_name' => $this->subcategories->name,
          'outline' => $this->outline,
          'have_episode' => $this->episode,
          'status' => $this->status,
          'movie_file' => asset('/images/movienames/'.$this->movie_file),
          'season_number' => SampleHomeSliderSeasonResource::collection($movie),
           
        ];

      }
      else
      {
        return[
          'id' => $this->id,
          'name' => $this->name,
          'category_id' => $this->category_id,
          'category_name' => $this->categories->name,
          'subcategory_id' => $this->subcategory_id,
          'subcategory_name' => $this->subcategories->name,
          'outline' => $this->outline,
          'have_episode' => $this->episode,
          'status' => $this->status,
           //'adslist' => AdsResource::collection($adslist),
          // 'video_url' => asset('/img/uploads/'),
          // 'subtitle_url' => asset('/images/subtitles/'),  
          'movie_file' => asset('/images/movienames/'.$this->movie_file),
          'movie_list' => SeasonResource::collection($aalist),
           
        ];

      }
       

        // return [
        //     'id' => $this->id,
        // ];
    }
}
