<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubtitleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
             'id' => $this->id,
             'subtitle_name' => $this->subtitle_name,
             'subtitle_file' => asset('/images/subtitles/'.$this->subtitle_file),
              
        ];

    }
}
