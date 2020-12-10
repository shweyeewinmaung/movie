<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\Controller;
use App\MovieName;
use App\Movie;

class SeasonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // $aalists= Movie::with(['subtitles'])->where('id', $this['id'])->groupBy('season_number')->get();
        // $series_lists=$aalists->groupBy('season_number')->toArray();
        return [
            'id' =>$this->id,
            'episode_name'=> $this->episode_name,
            'moviename_id'=> $this->moviename_id,
            'season_number'=>$this->season_number,
            'video_file'=> asset('/img/uploads/'.$this->video_file),
            'disk'=> $this->disk,
            'stream_path'=> asset('/img/uploads/'.$this->stream_path),
            'processed'=> $this->processed,
            'converted_for_streaming_at'=> $this->converted_for_streaming_at,
            'subtitles' =>SubtitleResource::collection($this->subtitles)
        ];
   
    }
}
