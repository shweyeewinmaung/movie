<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Movie;
use FFMpeg;
use Carbon\Carbon;

class ConvertMovieforStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $movie;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Movie $movie)
    {
        $this->movie = $movie;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $lowBitrate  = (new \FFMpeg\Format\Video\X264 ('aac'))->setKiloBitrate(250)->setVideoCodec('libx264');
        $midBitrate  = (new \FFMpeg\Format\Video\X264 ('aac'))->setKiloBitrate(500)->setVideoCodec('libx264');
        $highBitrate = (new \FFMpeg\Format\Video\X264 ('aac'))->setKiloBitrate(1000)->setVideoCodec('libx264');

      
        //$converted_name = uniqid().'-'.$this->video->original_name.'.m3u8';
        //$converted_namegetclean = $this->getCleanFileName($this->movie->video_file);
        //$converted_name = uniqid().'-'.$converted_namegetclean.".m3u8";
        $converted_name = $this->getCleanFileName($this->movie->video_file).".m3u8";

        $moviefromdb=FFMpeg::fromDisk($this->movie->disk)
         ->open($this->movie->video_file) 
        ->getVideoStream()
        ->getDimensions();

        if($moviefromdb->getWidth() >= '1000')
        {
            FFMpeg::fromDisk($this->movie->disk)
             ->open($this->movie->video_file)         
             ->exportForHLS()
             ->setSegmentLength(10)
           
           
            ->addFormat($highBitrate, function($media) {
               $media->addLegacyFilter(function ($filters) {
                   $filters->resize(new \FFMpeg\Coordinate\Dimension(1080, 720));
                });
            })
            ->save($converted_name);
        }
        elseif($moviefromdb->getWidth() >= '500' && $moviefromdb->getWidth() < '1000')
        {
            FFMpeg::fromDisk($this->movie->disk)
             ->open($this->movie->video_file)         
             ->exportForHLS()
             ->setSegmentLength(10)
            
            ->addFormat($midBitrate, function($media) {
               $media->addLegacyFilter(function ($filters) {
                   $filters->resize(new \FFMpeg\Coordinate\Dimension(640,360));
                });
            })
           
            ->save($converted_name);
        }
        else 
        {
            FFMpeg::fromDisk($this->movie->disk)
             ->open($this->movie->video_file)         
             ->exportForHLS()
             ->setSegmentLength(10)
            
            ->addFormat($lowBitrate, function($media) {
               $media->addLegacyFilter(function ($filters) {
                   $filters->resize(new \FFMpeg\Coordinate\Dimension(426,240));
                });
            })
           
            ->save($converted_name);
        }
        

         $this->movie->update([
            'converted_for_streaming_at' => Carbon::now(),
            'processed' => true,
            'stream_path' => $converted_name
        ]);

    }
     private function getCleanFileName($filename){
        return preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
        //return preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename) . '.m3u8';
    }
}
