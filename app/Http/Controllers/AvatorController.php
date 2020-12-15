<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Avator;
use App\Advertising;
use App\Admin;
use App\Comment;
use Validator;


class AvatorController extends Controller
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
   public function index()
    {
       //$avators=Avator::find(1)->getMedia('avator');
       $avators = Avator::find(1)->media()->where('collection_name', 'avator')->orderBy('id','desc')->paginate(40);
       return view('admin.medias.medialist',compact('avators'));

    } 
    public function indexedit($id)
    {
        $advertising =Advertising::whereId($id)->firstOrFail();
        $avators = Avator::find(1)->media()->where('collection_name', 'avator')->orderBy('id','desc')->paginate(40);
         return view('admin.medias.medialistforedit',compact('id','avators','advertising'));
     
    }

    public function store(Request $request)    
    {
        $validated_data = Validator::make($request->all(), [ 
            'avator' => 'required',
                      
        ]);

        if ($validated_data->fails()) 
        { 
            return redirect()->back()->with(['errorstatus'=>'File Field is required'], 401);          
        }

        $avator=Avator::whereId(1)->first();        
        $avator->addMedia($request->file('avator'))->toMediaCollection('avator');

        Comment::create([
            'content' => Auth::user()->name ." deleted Media Library File Name ".$avator->file_name,
            'user_id' => Auth::user()->id,
            'commendable_id' =>1 ,
            'commendable_type' => "media"        
        ]);
        return redirect()->back()->with("status","Successfully Saved Media Library File");
        
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
        // $avator=Media::whereId($id)->firstOrFail();
         //$avators = Avator::find(1)->media()->where('collection_name', 'avator')->paginate(4);
        $avator = Avator::find(1)->media()->where('id', $id)->firstOrFail();
        $avator->delete();
       
         Comment::create([
            'content' => Auth::user()->name ." deleted Media Library File  ".$avator->file_name,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "media"        
        ]);
        
       return redirect()->back()->with(['status'=>$avator->file_name.' Has Been Deleted']);
    }
}
