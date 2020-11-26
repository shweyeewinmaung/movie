<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;
use App\Jobs\ConvertVideoForStreaming;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Job;

class VideoController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
        $videos = Video::orderBy('created_at', 'DESC')->get();

        return view('admin.videos.video')->with('videos', $videos);
    }

    public function uploader(){
        return view('admin.videos.uploader');
    }
     public function store(Request $request)
     {

     	$uploadFile = $request->video;        
        $path = uniqid().'.'.$uploadFile->getClientOriginalExtension();
        $uploadFile->storeAs('/', $path, 'uploads');
        
        $video = Video::create([
            'disk'          => 'uploads',
            'original_name' => $request->video->getClientOriginalName(),
            'path'          => $path,
            'title'         => $request->title,
        ]);
ConvertVideoForStreaming::dispatch($video);
//         $job=(new SendEmalJob($podcast))=>delay(Carbon::now()->addSeconds(10));

// dispathc($job)

    //$job=(new ConvertVideoForStreaming($video))->delay(Carbon::now()->addSeconds(5));
    //$job=new ConvertVideoForStreaming($video);
    //ConvertVideoForStreaming::dispatch($video)->onQueue('movieupload');

//dispatch($job);
      //Artisan::call('queue:work',  ConvertVideoForStreaming::dispatch($video));
       // Queue::push(ConvertVideoForStreaming::dispatch($video));
        //Job::dispatch()->onQueue(ConvertVideoForStreaming::dispatch($video));
        //ConvertVideoForStreaming::dispatch($video);
        //Queue::push(new InvoiceEmail($order));
        
        
        return redirect()->back()->with(['status'=>'Your video will be available shortly after we process it ' ]);
 
    }
}
