<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use DB;
use App\MovieName;
use App\Movie;
use App\Advertising;
use App\Avator;
use Carbon\Carbon;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {  
        $aalist= Movie::with(['subtitles'])->where('moviename_id',$this->id)->get();
       // $series_list=$aalist->groupBy('season_number')->toArray();
          // dd($series_list[1]);
        $date = Carbon::now();
        $todaydate= $date->toDateString();
        $adslist=Advertising::where('from_date', '<=', "{$todaydate}")
              ->where('to_date', '>=', "{$todaydate}")->get(); 
              
       return [
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
         //'adslist' => AdsResource::collection($adslist),
         // 'video_url' => asset('/img/uploads/'),
         // 'subtitle_url' => asset('/images/subtitles/'),      
        // 'series_list' => $aalist,
        'series_list' => SeasonResource::collection($aalist),
      
       ];
    

    }
}
