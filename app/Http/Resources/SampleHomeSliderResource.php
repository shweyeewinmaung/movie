<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SampleHomeSliderResource extends JsonResource
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
         'name' => $this->name,
         'category_id' => $this->category_id,
         'category_name' => $this->categories->name,
         'subcategory_id' => $this->subcategory_id,
         'subcategory_name' => $this->subcategories->name,
         'outline' => $this->outline,
         'have_episode' => $this->episode,
         'status' => $this->status,
         'movie_file' => asset('/images/movienames/'.$this->movie_file),
      ];
    }
}
