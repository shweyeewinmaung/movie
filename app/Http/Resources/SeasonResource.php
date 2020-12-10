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
        $aalists= Movie::with(['subtitles'])->where('id', $this['id'])->groupBy('season_number')->get();
        $series_lists=$aalists->groupBy('season_number')->toArray();
        return [
            'id' =>$aalists
        ];
        // return [
        //                $this['id']
        //             ];
        // $aalists= Movie::with(['subtitles'])->where('moviename_id',$this->id)->get();
       //  $series_lists=$this->groupBy('season_number');
       // $aa=Movie::where()
        // foreach($this as $k=>$t)
        // {
        //      // return [
        //      //           $this->collection
        //      //        ];
        //     // foreach($t as $i)
        //     // {
        //     //     foreach($i as $k=>$kk)
        //     //     {
        //     //         return [
        //     //             $kk['id']
        //     //         ];
        //     //     }
        //     // }
        //      // return [
        //      //       foreach($t as $i)
        //      //       {
        //      //        $i
        //      //       }
        //      //    ];
        //     // foreach($t as $i=>$a)
        //     // {
        //     //     return [
        //     //         'aa'=>$a['id'],
        //     //     ];
        //     // }
        //     //$aalistmovie=Movie::where('id',$t['id'])
        //      // return [
        //      //        'id'=>$t,
        //      //    ];
        //      // foreach($t as $c=>$s)
        //      // {
        //      //    foreach($s as $g=>$i)
        //      //    {
        //      //        return [
        //      //            'id'=>$g,
        //      //        ];
        //      //    }
        //      //    // return [
        //      //    //     'id'=>$s,
        //      //    //     // 'episode_name'=> $s['episode_name'],
        //      //    //     // 'moviename_id'=> $s['moviename_id'],
        //      //    //     // 'season_number'=> $s['season_number'],
        //      //    //     // 'video_file'=> asset('/img/uploads/'.$s['video_file']),
        //      //    //     // 'disk'=> $s['disk'],
        //      //    //     // 'stream_path'=> asset('/img/uploads/'.$s['stream_path']),
        //      //    //     // 'processed'=> $s['processed'],
        //      //    //     // 'converted_for_streaming_at'=> $s['converted_for_streaming_at'],
                   
        //      //    // ];
        //      // }
        // }
       //  return [

       //        'id' => $this->id,
       //  //'details' => Movie::where('moviename_id', $this->id)
       // // ->where('exam_type',$this->exam_type)
       //  //->get(),
        
       //  ];
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
