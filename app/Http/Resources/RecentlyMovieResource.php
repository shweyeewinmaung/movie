<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Movie;
use App\Advertising;
use App\Avator;
use Carbon\Carbon;

class RecentlyMovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
     $aalist= Movie::with(['subtitles'])->where('moviename_id',$this->moviename_id)->get();

        $date = Carbon::now();
        $todaydate= $date->toDateString();
        $adslist=Advertising::where('from_date', '<=', "{$todaydate}")
              ->where('to_date', '>=', "{$todaydate}")->get(); 
     // $aalist= Movie::with(['subtitles'])->where('moviename_id',$this->id)->get();
     //   $series_list=$aalist->groupBy('season_number')->toArray();
        if($this->processed == '1')
         {
            return [
               //'id' => $this->id,
               'id' => $this->moviename_id,
               'name' => $this->movienames->name,
               'category_id' => $this->movienames->category_id,
               'category_name' => $this->movienames->categories->name,
               'subcategory_id' => $this->movienames->subcategory_id,
               'subcategory_name' => $this->movienames->subcategories->name,
               'outline' => $this->movienames->outline,
               'have_episode' => $this->movienames->episode,
               'status' => $this->movienames->status,
               'movie_file' => asset('/images/movienames/'.$this->movienames->movie_file),
              // 'adslist' => AdsResource::collection($adslist),
               // 'video_url' => asset('/img/uploads/'),
               // 'subtitle_url' => asset('/images/subtitles/'),   
              //'series_list' => $series_list,
              'series_list' => SeasonResource::collection($aalist),
               
           ];
         }
    }
}
