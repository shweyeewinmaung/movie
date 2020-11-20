<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Comment;
use App\Http\Requests\CategoryFormRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CategoryController extends Controller
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
        $categorylistsall = Category::all();
        $categorylists = Category::orderBy('id', 'desc')->paginate(30); 
        $s="";
        
        return view('admin.categories.categorylist',compact('categorylistsall','categorylists','s'));
    }
    public function searchcategory(Request $request)
    {
         // if (\Gate::allows('isadmin')) 
         //   { 
                $s = $request->search;

                $categorylistsall=Category::where('name', 'LIKE', "%{$s}%");
                $categorylists = Category::where('name', 'LIKE', "%{$s}%")
                ->orderBy('id','desc')
                ->paginate(30);                
                
                return view('admin.categories.categorylist',compact('categorylistsall','categorylists','s'));
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
    public function store(CategoryFormRequest $request)
    {
        $categories_table=Category::create([
            'name' => $request->get('name'),          
        ]);
        Comment::create([
            'content' => Auth::user()->name ." Add new category ",
            'user_id' => Auth::user()->id,
            'commendable_id' =>$categories_table->id ,
            'commendable_type' => "categories"        
        ]);        
        
        return redirect('admin/CategoryList')->with("status","Successfully Saved Category");
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
    public function update(CategoryFormRequest $request, $id)
    {
        $category=Category::whereId($id)->firstOrFail();
        $category->name=$request->get('name');
        $category->updated_at=Carbon::now()->timestamp;
        $category->update();

        Comment::create([
            'content' => Auth::user()->name ." updated Category ".$category->name,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "categories"        
        ]);
        
        return redirect()->back()->with(['status'=>$category->name.' Has Been Updated']);
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category=Category::whereId($id)->firstOrFail();   
        $category->delete();

        Comment::create([
            'content' => Auth::user()->name ." deleted Category ".$category->name,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "categories"        
        ]);
        
        return redirect()->back()->with(['status'=>$category->name.' Has Been Deleted']);
       
    }
}
