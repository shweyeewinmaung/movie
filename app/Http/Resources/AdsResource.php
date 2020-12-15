<?php

namespace App\Http\Resources;
use App\Avator;

use Illuminate\Http\Resources\Json\JsonResource;

class AdsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $avator_file=Avator::find(1)->media()->where('id',$this->advertisingfile_id)->firstOrFail(); 
        //$avator = Avator::find(1)->media()->where('id', $avator_id)->firstOrFail();
        return [
            'id' =>$this->id,
            'company_name' =>$this->company_name,
            'from_date' =>$this->from_date,
            'to_date' =>$this->to_date,
            'display_time' =>$this->display_time,
            'display_type' =>$this->display_type,
            'advertising_file' => asset('/img/ads/'.$avator_file['file_name']),
        ];
    }
}
