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
        // $aa=DB::table('movies')->where('moviename_id',$this->id)->groupBy('season_number')->get();
        return [

              'id' => $this->id,
        //'details' => Movie::where('moviename_id', $this->id)
       // ->where('exam_type',$this->exam_type)
        //->get(),
        
        ];
        //$aa=DB::table('movies')->where('moviename_id',$this->id)->groupBy('season_number')->get();
        // return [
        //     'id'=>$this['id'],
        //     //'aa'=>$this->episode
        // ];
        // return DB::table('movies')->select('season_number')->where('moviename_id',$this->moviename_id)->where('id',$this->id)->groupBy('season_number')->get();
        // return parent::toArray($request);

       // return [
       //       'id' => $this->id,
             
              
       //  ];
    }
}
