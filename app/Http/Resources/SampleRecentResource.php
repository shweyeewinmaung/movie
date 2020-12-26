<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SampleRecentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
         if($this->processed == '1')
         {
            return [
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
             ];
         }
    }
}
