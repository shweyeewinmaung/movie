<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use DB;
use App\MovieName;
use App\Movie;

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
        $series_list= Movie::with(['subtitles'])->where('moviename_id',$this->id)->distinct()->get();
           
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
       // 'series_list' =>  Movie::where('moviename_id', $this->id)->get(),
         'series_list' => $series_list,
      
       ];
    

    }
}
