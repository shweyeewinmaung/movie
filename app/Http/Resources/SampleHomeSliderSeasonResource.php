<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SampleHomeSliderSeasonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
         // 'id' => $this->id,
          'season_number' => $this->season_number,
          'season_name'=>'Season '.$this->season_number
      ];
    }
}
