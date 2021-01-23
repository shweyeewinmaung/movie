<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TvCategory;
use App\Comment;
use App\Http\Requests\TvCategoryFormRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TvCategoryController extends Controller
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
        $tvcategorylistsall = TvCategory::all();
        $tvcategorylists = TvCategory::orderBy('id', 'desc')->paginate(30); 
        $s="";
        
        return view('admin.tvcategories.list',compact('tvcategorylistsall','tvcategorylists','s'));
    }
     public function searchtvcategory(Request $request)
    {
         // if (\Gate::allows('isadmin')) 
         //   { 
                $s = $request->search;

                $tvcategorylistsall=TvCategory::where('name', 'LIKE', "%{$s}%");
                $tvcategorylists = TvCategory::where('name', 'LIKE', "%{$s}%")
                ->orderBy('id','desc')
                ->paginate(30);                
                
                return view('admin.tvcategories.list',compact('tvcategorylistsall','tvcategorylists','s'));
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
    public function store(TvCategoryFormRequest $request)
    {
       $tvcategories=TvCategory::create([
            'name' => $request->get('name'),          
        ]);
        Comment::create([
            'content' => Auth::user()->name ." Add new TV category ",
            'user_id' => Auth::user()->id,
            'commendable_id' =>$tvcategories->id ,
            'commendable_type' => "tvcategories"        
        ]);        
        
        return redirect('admin/TVCategoryList')->with("status","Successfully Saved TV Category");
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
    public function update(TvCategoryFormRequest $request, $id)
    {
        $tvcategory=TvCategory::whereId($id)->firstOrFail();
        $tvcategory->name=$request->get('name');
        $tvcategory->updated_at=Carbon::now()->timestamp;
        $tvcategory->update();

        Comment::create([
            'content' => Auth::user()->name ." updated TV Category ".$tvcategory->name,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "tvcategories"        
        ]);
        
        return redirect()->back()->with(['status'=>$tvcategory->name.' Has Been Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
        $tvcategory=TvCategory::whereId($id)->firstOrFail();   
        $tvcategory->delete();

        Comment::create([
            'content' => Auth::user()->name ." deleted TV Category ".$tvcategory->name,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "tvcategories"        
        ]);
        
        return redirect()->back()->with(['status'=>$tvcategory->name.' Has Been Deleted']);
       
    }
}
