<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use App\Comment;
use App\Http\Requests\SubCategoryFormRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class SubCategoryController extends Controller
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
        $categories = Category::all();
        $subcategorylistsall = SubCategory::all();
        $subcategorylists = SubCategory::orderBy('id', 'desc')->paginate(30); 
        $s="";
        return view('admin.subcategories.subcategorylist',compact('categories','subcategorylistsall','subcategorylists','s'));
    }
    public function searchsubcategory(Request $request)
    {
         // if (\Gate::allows('isadmin')) 
         //   { 
                $s = $request->search;
                $categories = Category::all();
              
                 $subcategorylistsall =SubCategory::where('name', 'LIKE', "%{$s}%")
                ->orWhereHas('categories', function($q) use ($s){
                    return $q->where('name','like','%'. $s . '%');
               });
 
               $subcategorylists =SubCategory::where('name', 'LIKE', "%{$s}%")
                ->orWhereHas('categories', function($q) use ($s){
                    return $q->where('name','like','%'. $s . '%');
               })->orderBy('id','desc')
                ->paginate(30); 
             
               return view('admin.subcategories.subcategorylist',compact('categories','subcategorylistsall','subcategorylists','s'));
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
    public function store(SubCategoryFormRequest $request)
    {
         $subcategories_table=SubCategory::create([
            'name' => $request->get('name'), 
            'category_id' => $request->get('category_id'),          
        ]);
        
        Comment::create([
            'content' => Auth::user()->name ." Add new subcategory ",
            'user_id' => Auth::user()->id,
            'commendable_id' =>$subcategories_table->id ,
            'commendable_type' => "sub_categories"        
        ]);  
        
        return redirect('admin/SubCategoryList')->with("status","Successfully Saved Sub Category");
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
    public function update(SubCategoryFormRequest $request, $id)
    {
        $subcategory=SubCategory::whereId($id)->firstOrFail();
        $subcategory->name=$request->get('name');
        $subcategory->category_id=$request->get('category_id');
        $subcategory->updated_at=Carbon::now()->timestamp;
        $subcategory->update();

        Comment::create([
            'content' => Auth::user()->name ." updated SubCategory ".$subcategory->name,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "sub_categories"
        
        ]);
        
        return redirect()->back()->with(['status'=>$subcategory->name.' Has Been Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subcategory=SubCategory::whereId($id)->firstOrFail();   
        $subcategory->delete();

         Comment::create([
            'content' => Auth::user()->name ." deleted SubCategory ".$subcategory->name,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "sub_categories"        
        ]);
        
        return redirect()->back()->with(['status'=>$subcategory->name.' Has Been Deleted']);
    }
}
