<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TvCategory;
use App\Tvchannel;
use App\Comment;
use App\Http\Requests\TvchannelFormRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class TvchannelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $tvcategories = TvCategory::all();
        $tvchannellistsall = Tvchannel::all();
        $tvchannellists = Tvchannel::orderBy('id', 'desc')->paginate(30); 
        $s="";

        return view('admin.tvchannels.list',compact('tvcategories','tvchannellistsall','tvchannellists','s'));
    }
    public function searchtvchannel(Request $request)
    {
         // if (\Gate::allows('isadmin')) 
         //   { 
                $s = $request->search;
                $tvcategories = TvCategory::all();
              
                $tvchannellistsall =Tvchannel::where('name', 'LIKE', "%{$s}%")
                ->orWhereHas('tvcategories', function($q) use ($s){
                    return $q->where('name','like','%'. $s . '%');
               });
 
               $tvchannellists =Tvchannel::where('name', 'LIKE', "%{$s}%")
                ->orWhereHas('tvcategories', function($q) use ($s){
                    return $q->where('name','like','%'. $s . '%');
               })->orderBy('id','desc')
                ->paginate(30); 
             
               return view('admin.tvchannels.list',compact('tvcategories','tvchannellistsall','tvchannellists','s'));
                // }abort(404,"Sorry");
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
    public function store(TvchannelFormRequest $request)
    {

        if($request->hasFile('channel_image'))
        {               
           $channel_image=$request->file('channel_image');
           $channel_imagename=uniqid().'-'.$channel_image->getClientOriginalName();
           $channel_image->move(public_path().'/images/tvchannels/',$channel_imagename);       
        }

        $tvchannels=Tvchannel::create([
            'name' => $request->get('name'), 
            'tvcategory_id' => $request->get('tvcategory_id'), 
            'channel_image' => $channel_imagename, 
            'channel_api' => $request->get('channel_api'),        
        ]);
        
        Comment::create([
            'content' => Auth::user()->name ." Add new TV Channel ",
            'user_id' => Auth::user()->id,
            'commendable_id' =>$tvchannels->id ,
            'commendable_type' => "tvchannels"        
        ]);  
        
        return redirect('admin/TVChannelList')->with("status","Successfully Saved TV Channel");
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
        $tvchannel=Tvchannel::whereId($id)->firstOrFail();
        $tvchannel->name=$request->get('name');
        $tvchannel->tvcategory_id=$request->get('tvcategory_id');
        $tvchannel->channel_api=$request->get('channel_api');       
        $tvchannel->updated_at=Carbon::now()->timestamp;

        if($request->hasFile('channel_image'))
         {
           $channel_image=$request->file('channel_image');
           $channel_imagename=uniqid().'-'.$channel_image->getClientOriginalName();
           $channel_image->move(public_path().'/images/tvchannels/',$channel_imagename);       
           $tvchannel->channel_image=$channel_imagename;    
        }
        Comment::create([
            'content' => Auth::user()->name ." updated TV Channel for ".$tvchannel->name ,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "tvchannels"
        
        ]);
        $tvchannel->update();
 
        return redirect()->back()->with(['status'=>$tvchannel->name.' Has Been Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tvchannel=Tvchannel::whereId($id)->firstOrFail();
       
        $filename = public_path().'/images/tvchannels/'.$tvchannel->channel_image;
        if(file_exists($filename)) 
        { 
            unlink($filename);
            $tvchannel->delete();
        }
        else
        {
           $tvchannel->delete();
        }
        
         Comment::create([
            'content' => Auth::user()->name ." deleted TV Channel Name ".$tvchannel->name,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "tvchannels"        
        ]);
        
        return redirect()->back()->with(['status'=>$tvchannel->name.' Has Been Deleted']);
    }
}
