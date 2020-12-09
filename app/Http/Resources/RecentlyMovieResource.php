<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
      //return ['id' =>$this->id, ];
        // if($this->processed == '1')
        //  {
            return [
               //'id' => $this->id,
               'moviename_id' => $this->moviename_id,
               'moviename' => $this->movienames->name,
              // 'moviename' => $this->movienames->name,
               'moviename_file' => asset('/images/movienames/'.$this->movienames->movie_file),
               // 'outline' => $this->movienames->outline,
               // 'have_episode' => $this->movienames->episode,
               // 'status' => $this->movienames->status,
               'category_id' => $this->movienames->category_id,
               'category_name' => $this->movienames->categories->name,
               'subcategory_id' => $this->movienames->subcategory_id,
               'subcategory_name' => $this->movienames->subcategories->name,
               
               // 'subtitles' => $this->subtitles,SubtitleResource
               // 'subtitles' => SubtitleResource::collection($this->subtitles),
               // 'episode_name' => $this->episode_name,
               // 'season_number' => $this->season_number,
               // 'video_file' => asset('/img/uploads/'.$this->stream_path),
               // 'upload_date' => $this->converted_for_streaming_at,
               'created_at' => $this->created_at,
               'updated_at' => $this->updated_at,
           ];
        //  }
    }
}
