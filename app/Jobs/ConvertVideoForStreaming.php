<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Video;
use FFMpeg;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
//use Streaming\Representation;

class ConvertVideoForStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $video;
    /**
     * Create a new job instance.
     *
     * @return void
     */
   public function __construct(Video $video)
    {
        $this->video = $video;
    }
 
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
      
        //$format = new FFMpeg\Format\Video\X264('libmp3lame', 'libx264');
        // $lowBitrate = ($format)->setKiloBitrate(250);
        // $midBitrate = ($format)->setKiloBitrate(500);
        //$highBitrate = ($format)->setKiloBitrate(1000);

        $lowBitrate  = (new \FFMpeg\Format\Video\X264 ('aac'))->setKiloBitrate(250)->setVideoCodec('libx264');
        $midBitrate  = (new \FFMpeg\Format\Video\X264 ('aac'))->setKiloBitrate(500)->setVideoCodec('libx264');
        $highBitrate = (new \FFMpeg\Format\Video\X264 ('aac'))->setKiloBitrate(1000)->setVideoCodec('libx264');

      
        //$converted_name = uniqid().'-'.$this->video->original_name.'.m3u8';
        $converted_namegetclean = $this->getCleanFileName($this->video->original_name);
        $converted_name = uniqid().'-'.$converted_namegetclean.".m3u8";
        
        FFMpeg::fromDisk($this->video->disk)
         ->open($this->video->path)         
         ->exportForHLS()
         ->setSegmentLength(10)
          ->addFormat($lowBitrate, function($media) {
           $media->addLegacyFilter(function ($filters) {
               $filters->resize(new \FFMpeg\Coordinate\Dimension(426,240));
            });
        })
        ->addFormat($midBitrate, function($media) {
           $media->addLegacyFilter(function ($filters) {
               $filters->resize(new \FFMpeg\Coordinate\Dimension(640,360));
            });
        })
        ->addFormat($highBitrate, function($media) {
           $media->addLegacyFilter(function ($filters) {
               $filters->resize(new \FFMpeg\Coordinate\Dimension(1280, 720));
            });
        })
        ->save($converted_name);

    //     FFMpeg::fromDisk($this->video->disk)
    //      ->open($this->video->path)         
    //      ->exportForHLS()
    //      ->setSegmentLength(10) // optional
    //      ->setKeyFrameInterval(48) // optional
    //     //  ->addFormat($lowBitrate, function($media) {
    //     //     $media->addFilter('scale=426x240');
    //     // })
    //     // ->addFormat($midBitrate, function($media1) {
    //     //    // $media1->scale(640,360);
    //     //      $media1->addFilter('scale=640x360');
    //     //  // $media1->addFilter(new \FFMpeg\Coordinate\Dimension(640, 480));
    //     // })       
    //       ->addFormat($highBitrate, function ($media) {
    //     $media->addFilter(function ($filters, $in, $out) {
    //         $filters->custom($in, 'scale=1280:720', $out); // $in, $parameters, $out
    //     });
    // })
        
         //->addFormat($lowBitrate)
       //->addFormat($midBitrate)
        //->addFormat($highBitrate)
        // ->save($converted_name);
      
        // update the database so we know the convertion is done!
        $this->video->update([
            'converted_for_streaming_at' => Carbon::now(),
            'processed' => true,
            'stream_path' => $converted_name
        ]);
    //     return redirect()->back()->with(['status'=>'Your video will be available shortly after we process it ' ]);
    }
 
    private function getCleanFileName($filename){
        return preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
        //return preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename) . '.m3u8';
    }
   
}
