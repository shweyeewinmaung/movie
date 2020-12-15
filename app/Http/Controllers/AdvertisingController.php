<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Avator;
use App\Advertising;
use App\Comment;
use App\Http\Requests\AdvertisingFormRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;


class AdvertisingController extends Controller
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
        $advertisingslistsall = Advertising::all();
        $advertisingslists = Advertising::orderBy('id', 'desc')->paginate(2); 
        $searchdate="";
       return view('admin.advertisings.advertisinglist',compact('advertisingslistsall','advertisingslists','searchdate'));
    }
    public function searchdate(Request $request)
    {
        $searchdate = $request->searchdate;
        if($searchdate == null)
        {
            $advertisingslistsall = Advertising::all();
            $advertisingslists = Advertising::orderBy('id', 'desc')->paginate(2); 
            $searchdate="";
       
        }
        else
        {
             $advertisingslistsall =Advertising::where('from_date', '<=', "{$searchdate}")
              ->where('to_date', '>=', "{$searchdate}"); 
            
             $advertisingslists =Advertising::where('from_date', '<=', "{$searchdate}")
              ->where('to_date', '>=', "{$searchdate}")
              ->orderBy('id','desc')
              ->paginate(30);       
       
        }
        return view('admin.advertisings.advertisinglist',compact('advertisingslistsall','advertisingslists','searchdate'));
       
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $avator=null;
        return view('admin.advertisings.advertisingcreate',compact('avator'));
      
    }
    public function select(Request $request, $id)
    {
         $avator = Avator::find(1)->media()->where('id', $id)->firstOrFail();
        
         return view('admin.advertisings.advertisingcreate',compact('avator'));
    }
    public function selectedit(Request $request, $id,$avator_id)
    {
         $advertising=Advertising::whereId($id)->firstOrFail();

         $avator = Avator::find(1)->media()->where('id', $avator_id)->firstOrFail();
         return view('admin.advertisings.advertisingedit',compact('advertising','avator'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdvertisingFormRequest $request)
    { 
        $advertisings=Advertising::create([
            'company_name' => $request->get('company_name'),
            'from_date' =>$request->get('from_date'),  
            'to_date' => $request->get('to_date'),
            'display_time' => $request->get('display_time'),
            'display_type' => $request->get('display_type'),
            'advertisingfile_id' => $request->get('advertisingfile'),
                
        ]);
       Comment::create([
            'content' => Auth::user()->name ." Add new Advertising ".$advertisings->company_name,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$advertisings->id ,
            'commendable_type' => "advertisings"        
        ]);  
        
        return redirect('admin/AdvertisingAdd')->with("status","Successfully Saved Advertising");
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
         $advertising=Advertising::whereId($id)->firstOrFail();

         $avator = Avator::find(1)->media()->where('id', $advertising->advertisingfile_id)->firstOrFail();
         return view('admin.advertisings.advertisingedit',compact('advertising','avator'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdvertisingFormRequest $request, $id)
    {
         $advertising=Advertising::whereId($id)->firstOrFail();
         $advertising->company_name=$request->get('company_name');
         $advertising->from_date=$request->get('from_date');
         $advertising->to_date=$request->get('to_date');
         $advertising->display_time=$request->get('display_time');
         $advertising->display_type=$request->get('display_type');
         $advertising->advertisingfile_id=$request->get('advertisingfile');
         $advertising->updated_at=Carbon::now()->timestamp;

         Comment::create([
            'content' => Auth::user()->name ." updated Advertising Company Name  ".$advertising->company_name ,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "advertisings"
        
        ]);
        $advertising->update();
 
        return redirect()->back()->with(['status'=>$advertising->company_name.' Has Been Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $advertising=Advertising::whereId($id)->firstOrFail();       
        $advertising->delete();

        Comment::create([
            'content' => Auth::user()->name ." deleted Advertising for Company ".$advertising->company_name,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "advertisings"        
        ]);
        
        return redirect()->back()->with(['status'=>$advertising->company_name.' Has Been Deleted']);
    }
}
