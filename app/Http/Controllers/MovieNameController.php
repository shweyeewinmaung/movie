<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use App\MovieName;
use App\Comment;
use App\Http\Requests\MovieNameFormRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class MovieNameController extends Controller
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
        $categories=Category::all();
        $movienamelistsall = MovieName::all();
        $movienamelists = MovieName::orderBy('id', 'desc')->paginate(30); 
        $s="";
        return view('admin.movienames.movienamelist',compact('categories','movienamelistsall','movienamelists','s'));
    }
    public function searchmoviename(Request $request)
    {
         // if (\Gate::allows('isadmin')) 
         //   { 
                $s = $request->search;
                $categories = Category::all();
              
             $movienamelistsall =MovieName::where('name', 'LIKE', "%{$s}%")
              ->orWhere('status', 'LIKE', "%{$s}%")
                ->orWhereHas('categories', function($q) use ($s){
                    return $q->where('name','like','%'. $s . '%');
               })->orWhereHas('subcategories', function($q) use ($s){
                    return $q->where('name','like','%'. $s . '%');
               }); 
             
 
               $movienamelists =MovieName::where('name', 'LIKE', "%{$s}%")
                ->orWhere('status', 'LIKE', "%{$s}%")
                ->orWhereHas('categories', function($q) use ($s){
                    return $q->where('name','like','%'. $s . '%');
               })->orWhereHas('subcategories', function($q) use ($s){
                    return $q->where('name','like','%'. $s . '%');
               }) ->orderBy('id','desc')
                ->paginate(30); 
             
               return view('admin.movienames.movienamelist',compact('categories','movienamelistsall','movienamelists','s'));
                // }abort(404,"Sorry");
    }

    
    public function getsubcategory($id) 
    {         
       $sub_categories = DB::table("sub_categories")->where("category_id",$id)->pluck("name","id");
       return json_encode($sub_categories);
    }

    public function imageupload(Request $request)
    {
        if($request->hasFile('upload')) {
            //get filename with extension
            $filenamewithextension = $request->file('upload')->getClientOriginalName();
      
            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
      
            //get file extension
            $extension = $request->file('upload')->getClientOriginalExtension();
      
            //filename to store
            $filenametostore = $filename.'_'.time().'.'.$extension;
      
            //Upload File
            $request->file('upload')->storeAs('public/uploads', $filenametostore);
 
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/uploads/'.$filenametostore);
            $msg = 'Image successfully uploaded';
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
             
            // Render HTML output
            @header('Content-type: text/html; charset=utf-8');
            echo $re;
        }
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
    public function store(MovieNameFormRequest $request)
    {
        if($request->episode == 'on'){$episode='1';}else{$episode='0';};
        // if($request->season == 'on'){$season='1';}else{$season='0';};
        $prefix_for_movie=uniqid().'-';
       // dd($prefix_for_movie);
        if($request->hasFile('movie_file'))
        {  
             
           $movie_file=$request->file('movie_file');
           $movie_filename=uniqid().'-'.$movie_file->getClientOriginalName();
           $movie_file->move(public_path().'/images/movienames/',$movie_filename);       
        }
       
      $movienames_table=MovieName::create([
            'name' => $request->get('name'),
            'prefix_for_movie' => $prefix_for_movie,  
            'subcategory_id' => $request->get('subcategory_id'),
            'category_id' => $request->get('category_id'),
            'outline' => $request->get('outline'),
            'movie_file' => $movie_filename,
            'episode' => $episode,
            // 'season' => $season,          
        ]);
       Comment::create([
            'content' => Auth::user()->name ." Add new Movie Name ".$movienames_table->name,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$movienames_table->id ,
            'commendable_type' => "movie_names"        
        ]);  
        
        return redirect('admin/MovieNameList')->with("status","Successfully Saved Movie Name");
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
        if($request->episode == 'on'){$episode='1';}else{$episode='0';};
        // if($request->season == 'on'){$season='1';}else{$season='0';};
        $moviename=MovieName::whereId($id)->firstOrFail();
        $moviename->name=$request->get('name');
        $moviename->category_id=$request->get('category_id');
        $moviename->subcategory_id=$request->get('subcategory_id');
        $moviename->episode=$episode;
        $moviename->status=$request->get('status');
        $moviename->outline=$request->get('outlineedit');
        $moviename->updated_at=Carbon::now()->timestamp;

        if($request->hasFile('movie_file'))
         {
           $movie_file=$request->file('movie_file');
           $movie_filename=uniqid().'-'.$movie_file->getClientOriginalName();
           $movie_file->move(public_path().'/images/movienames/',$movie_filename);       
           $moviename->movie_file=$movie_filename;    
        }
        Comment::create([
            'content' => Auth::user()->name ." updated Movie Name  ".$moviename->name ,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "movie_names"
        
        ]);
        $moviename->update();
 
        return redirect()->back()->with(['status'=>$moviename->name.' Has Been Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $moviename=MovieName::whereId($id)->firstOrFail();
       
        $filename = public_path().'/images/movienames/'.$moviename->movie_file;
        if(file_exists($filename)) 
        { 
            unlink($filename);
            $moviename->delete();
        }
        else
        {
           $moviename->delete();
        }

        
         Comment::create([
            'content' => Auth::user()->name ." deleted Movie Name ".$moviename->name,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "movie_names"        
        ]);
        
        return redirect()->back()->with(['status'=>$moviename->name.' Has Been Deleted']);
    }
}
