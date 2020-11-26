<?php

namespace App\Http\Controllers;
use FFMpeg;
//use Pbmedia\LaravelFFMpeg\FFMpegFacade as FFMpeg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use App\User;
use App\Typeuser;
use App\Comment;
use Streaming\Representation;
//use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function videoexample()
    {
        return view('admin.videoexample');
    }
     public function videoexamplesave(Request $request)
    {  
         // $format = new FFMpeg\Format\Video\X264('libmp3lame', 'libx264');
         // $lowBitrate = ($format)->setKiloBitrate(250);
         // $midBitrate = ($format)->setKiloBitrate(500);
         // $highBitrate = ($format)->setKiloBitrate(1000);
         //$superBitrate = ($format)->setKiloBitrate(1500);

        $lowBitrate  = (new \FFMpeg\Format\Video\X264 ('aac'))->setKiloBitrate(500)->setVideoCodec('libx264');
        $midBitrate  = (new \FFMpeg\Format\Video\X264 ('aac'))->setKiloBitrate(1000)->setVideoCodec('libx264');
        $highBitrate = (new \FFMpeg\Format\Video\X264 ('aac'))->setKiloBitrate(3000)->setVideoCodec('libx264');
        
       $aa=FFMpeg::fromDisk('uploads')->open('aa.mp4')
    ->getVideoStream()
    ->getDimensions();
   // ->first()
   // ->getDimensions();
    //dd($aa->getWidth());
    if($aa->getWidth() >= '1080' )
    {
        echo $cc='aa';
    }
    else
    {
        echo $cc='bb';
    }
    dd($cc);
        FFMpeg::fromDisk('uploads')
        ->open('aa.mp4')
        ->exportForHLS()
        //->dontSortFormats()
        ->setSegmentLength(10)
        //->toDisk('local')
        // ->addFormat($lowBitrate, function($media) {
        //     $media->addFilter(function ($filters) {
        //         $filters->custom(new \FFMpeg\Coordinate\Dimension(640, 480));
        //     });
        // })
        // ->addFormat($midBitrate, function($media) {
        //     $media->addFilter(function ($filters) {
        //         $filters->custom(new \FFMpeg\Coordinate\Dimension(1280, 960));
        //     });
        // })
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
               $filters->resize(new \FFMpeg\Coordinate\Dimension(2560, 1920));
            });
        })

    // ->exportForHLS()
    // ->setSegmentLength(10) // optional
    // ->setKeyFrameInterval(48) // optional
    // // ->addFormat($lowBitrate)
    // // ->addFormat($midBitrate)
    // // ->addFormat($highBitrate)
    //  ->addFormat($lowBitrate, function($media) {
    //     $media->addFilter('scale=640:480');
    // })
    // ->addFormat($midBitrate, function($media) {
    //     $media->scale(960, 720);
    // })
    // ->addFormat($highBitrate, function ($media) {
    //     $media->addFilter(function ($filters, $in, $out) {
    //         $filters->custom($in, 'scale=1920:1200', $out); // $in, $parameters, $out
    //     });
    // })
    // ->addFormat($superBitrate, function($media) {
    //     $media->addLegacyFilter(function ($filters) {
    //         $filters->resize(new \FFMpeg\Coordinate\Dimension(2560, 1920));
    //     });
    // })
    ->save('adaptive_steve.m3u8');
        return view('admin.videoexample');

    //     $aa= FFMpeg::open('aa.mp4')
    // ->exportForHLS()
    // ->useSegmentFilenameGenerator(function ($name, $format, $key, callable $segments, callable $playlist) {
    //     $segments("{$name}-{$format}-{$key}-%03d.ts");
    //     $playlist("{$name}-{$format}-{$key}.m3u8");
    // });
    // dd($aa);
       
    }
     public function index()
    {
        $usersall=User::all();
        $userslists = User::orderBy('id', 'desc')->paginate(50); 
        $s="";

        return view('admin.users.userlist',compact('usersall','userslists','s'));
    }
    public function searchuser(Request $request)
    {
       $s = $request->search;
      
       $usersall = User::where('name', 'LIKE', "%{$s}%")
                    ->orWhere('email', 'LIKE', "%{$s}%")
                    ->orWhere('provider', 'LIKE', "%{$s}%")
                    ->orWhere('user_code', 'LIKE', "%{$s}%")
                    ->orWhereHas('typeuser', function($q) use ($s){
                      return $q->where('status','like','%'. $s . '%');  
                     })
                    ->orWhereHas('typeuser', function($q) use ($s){
                      return $q->where('typeofuser','like','%'. $s . '%');  
                     });
        $userslists = User::where('name', 'LIKE', "%{$s}%")
                    ->orWhere('email', 'LIKE', "%{$s}%")
                    ->orWhere('provider', 'LIKE', "%{$s}%")
                    ->orWhere('user_code', 'LIKE', "%{$s}%")
                    ->orWhereHas('typeuser', function($q) use ($s){
                      return $q->where('status','like','%'. $s . '%');  
                     })
                    ->orWhereHas('typeuser', function($q) use ($s){
                      return $q->where('typeofuser','like','%'. $s . '%');  
                     })->orderBy('id','desc')
                     ->paginate(50);    
         
           return view('admin.users.userlist',compact('usersall','userslists','s'));
    }
    public function usertypeupdate(Request $request,$id)
    {
        
        $typeuser=Typeuser::where('user_id',$id)->first();
        $typeuser->typeofuser=$request->typeofuser;
        $typeuser->updated_at=Carbon::now()->timestamp;
        $typeuser->update();
     
      Comment::create([
            'content' => Auth::user()->name ." Updated User for Type ".$typeuser->typeofuser,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "users"        
        ]);
      
      return redirect()->back()->with(['status'=>'Type Has Been Updated ' ]);
    }

    public function userstatusupdate(Request $request,$id)
    {
        
        $typeuser=Typeuser::where('user_id',$id)->first();
        $typeuser->status=$request->status;
        $typeuser->updated_at=Carbon::now()->timestamp;
        $typeuser->update();
     
      Comment::create([
            'content' => Auth::user()->name ." Updated User for Status ".$typeuser->status,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "users"        
        ]);
      
      return redirect()->back()->with(['status'=>'Status Has Been Updated' ]);
    }

     public function changepassword(Request $request,$id)
    {
        $user= User::whereId($id)->first();
        $user->password=Hash::make(123456);
        $user->updated_at=Carbon::now()->timestamp;
        $user->update();
      
      Comment::create([
            'content' => Auth::user()->name ." Changed Default Passwrod for ".$user->name,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "users"        
        ]);
      
      return redirect()->back()->with(['status'=>'Default Has Been Updated' ]);
    }
    public function destroyuser($id)
    {
        $user=User::whereId($id)->firstOrFail();          
        $user->delete();

        $typeuser=Typeuser::where('user_id',$id)->first(); 
        $typeuser->delete();

         Comment::create([
            'content' => Auth::user()->name ." deleted User ".$user->name,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "users"        
        ]);
        
        return redirect()->back()->with(['status'=>$user->name.' Has Been Deleted']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
