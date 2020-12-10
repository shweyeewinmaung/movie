<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use App\MovieName;
use App\Movie;
use App\Subtitle;
use App\Comment;
use App\Http\Requests\MovieFormRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use App\Jobs\ConvertMovieforStreaming;
use App\Jobs\MovieJobConverting;

class MovieController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories=Category::all();
        $moviesearchlistsall = MovieName::all();
        $moviesearchlists = null; 
        $categorydata = null;
        $subcategorydata = null;
        $searchmovie = null;
        
       return view('admin.movies.movielistsearch',compact('categories','moviesearchlistsall','moviesearchlists','categorydata','subcategorydata','searchmovie')); 
    }
    public function getsubcategory($id) 
    {         
       $sub_categories = DB::table("sub_categories")->where("category_id",$id)->pluck("name","id");
       return json_encode($sub_categories);
    }
    public function moviesearchlist(Request $request) 
    {
       $categories=Category::all();
       $category_id = $request->category_id;
       $subcategory_id = $request->subcategory_id;
       $searchmovie = null;
       $categorydata=Category::whereId($category_id)->first();
       $subcategorydata=SubCategory::whereId($subcategory_id)->first();
      
       if($category_id == null)
       {
           $moviesearchlistsall =MovieName::all();
           // DB::table('movie_names')
           //                      ->join('categories','categories.id','=','movie_names.category_id');
           $moviesearchlists = MovieName::orderBy('movie_names.name','asc')
                                ->paginate(30);
           // DB::table('movie_names')
           //                       ->join('categories','categories.id','=','movie_names.category_id')->select('movie_names.name','movie_names.category_id','movie_names.subcategory_id')
      }
       else
       {
            if( $subcategory_id == null)
           {
                $moviesearchlistsall = MovieName::WhereHas('categories', function($q) use ($category_id){
                        return $q->where('id','=', $category_id);
                   });
                $moviesearchlists = MovieName::WhereHas('categories', function($q) use ($category_id){
                        return $q->where('id','=', $category_id);
                   })->orderBy('name','asc')
                    ->paginate(30);
                     //$moviesearchlists->appends(['search' => $q]);
           }
           else
           {
            $moviesearchlistsall = MovieName::WhereHas('categories', function($q) use ($category_id){
                        return $q->where('id','=', $category_id);
                   })->WhereHas('subcategories', function($q) use ($subcategory_id){
                        return $q->where('id','=', $subcategory_id);
                   });
            $moviesearchlists = MovieName::WhereHas('categories', function($q) use ($category_id){
                        return $q->where('id','=', $category_id);
                   })->WhereHas('subcategories', function($q) use ($subcategory_id){
                        return $q->where('id','=', $subcategory_id);
                   })->orderBy('name','asc')
                    ->paginate(30);
                   // $moviesearchlists->appends(['search' => $q]);
           }

       }
       
      return view('admin.movies.movielistsearch',compact('categories','moviesearchlistsall','moviesearchlists','categorydata','subcategorydata','searchmovie'));     
       
    }
    public function moviesearchmovielist(Request $request,$category_id,$subcategory_id)
    {
        // $category_id = $request->category_id;
        // $subcategory_id = $request->subcategory_id;
        $categories=Category::all();      
        $categorydata=Category::whereId($category_id)->first();
        $subcategorydata=SubCategory::whereId($subcategory_id)->first();
        $searchmovie = $request->searchmovie;
        //dd($category_id);
         if($category_id == 0 )
         {
            
             if($subcategory_id == 0)
             {

                 $moviesearchlistsall = MovieName::where('name', 'LIKE', "%{$searchmovie}%")
                                       ->orWhere('status', 'LIKE', "%{$searchmovie}%");
                              //->join('categories','categories.id','=','categories.id')
                             // ->where('movie_names.name','LIKE','%{$searchmovie}%');
                 $moviesearchlists = MovieName::where('name', 'LIKE', "%{$searchmovie}%")
                                ->orWhere('status', 'LIKE', "%{$searchmovie}%")
                                //->join('movie_names','movie_names.category_id','=','categories.id')
                             //->where('movie_names.name','LIKE','%{$searchmovie}%')->get();
                                ->orderBy('movie_names.name','asc')
                                ->paginate(30);
             }

         }
         else
         {
            if($subcategory_id == 0 )
            {
              if($searchmovie == null)
              {
                  $moviesearchlistsall = MovieName::where('name', 'LIKE', "%{$searchmovie}%")
                 //->orWhere('status', 'LIKE', "%{$searchmovie}%")
                 //->where('category_id','=', $category_id)
                   ->WhereHas('categories', function($q) use ($category_id){
                        return $q->where('id','=', $category_id);
                   });
                $moviesearchlists = MovieName::where('name', 'LIKE', "%{$searchmovie}%")
               // ->orWhere('status', 'LIKE', "%{$searchmovie}%")
               // ->where('category_id','=', $category_id)
                   ->WhereHas('categories', function($q) use ($category_id){
                        return $q->where('id','=', $category_id);
                   })->orderBy('name','asc')
                    ->paginate(30);
              }
              else
              {
                
                $moviesearchlistsall = MovieName::where('name', 'LIKE', "%{$searchmovie}%")
                 ->orWhere('status', 'LIKE', "%{$searchmovie}%")
                 //->where('category_id','=', $category_id)
                   ->WhereHas('categories', function($q) use ($category_id){
                        return $q->where('id','=', $category_id);
                   });
                $moviesearchlists = MovieName::where('name', 'LIKE', "%{$searchmovie}%")
                ->orWhere('status', 'LIKE', "%{$searchmovie}%")
               // ->where('category_id','=', $category_id)
                   ->WhereHas('categories', function($q) use ($category_id){
                        return $q->where('id','=', $category_id);
                   })->orderBy('name','asc')
                    ->paginate(30);
              }
               
             }
             else
             {
                if($searchmovie == null)
                {
                  $moviesearchlistsall = MovieName::where('name', 'LIKE', "%{$searchmovie}%")
                //->orWhere('status', 'LIKE', "%{$searchmovie}%")
                   ->WhereHas('categories', function($q) use ($category_id){
                        return $q->where('id','=', $category_id);
                   })->WhereHas('subcategories', function($q) use ($subcategory_id){
                        return $q->where('id','=', $subcategory_id);
                   });
                $moviesearchlists = MovieName::where('name', 'LIKE', "%{$searchmovie}%")
                //->orWhere('status', 'LIKE', "%{$searchmovie}%")
                   ->WhereHas('categories', function($q) use ($category_id){
                        return $q->where('id','=', $category_id);
                   })->WhereHas('subcategories', function($q) use ($subcategory_id){
                        return $q->where('id','=', $subcategory_id);
                   })->orderBy('name','asc')
                    ->paginate(30);
                }
                else
                {
                  $moviesearchlistsall = MovieName::where('name', 'LIKE', "%{$searchmovie}%")
                  ->orWhere('status', 'LIKE', "%{$searchmovie}%")
                   ->WhereHas('categories', function($q) use ($category_id){
                        return $q->where('id','=', $category_id);
                   })->WhereHas('subcategories', function($q) use ($subcategory_id){
                        return $q->where('id','=', $subcategory_id);
                   });
                $moviesearchlists = MovieName::where('name', 'LIKE', "%{$searchmovie}%")
                ->orWhere('status', 'LIKE', "%{$searchmovie}%")
                   ->WhereHas('categories', function($q) use ($category_id){
                        return $q->where('id','=', $category_id);
                   })->WhereHas('subcategories', function($q) use ($subcategory_id){
                        return $q->where('id','=', $subcategory_id);
                   })->orderBy('name','asc')
                    ->paginate(30);

                }
                
             }
         }
           
         return view('admin.movies.movielistsearch',compact('categories','moviesearchlistsall','moviesearchlists','categorydata','subcategorydata','searchmovie'));   
    }
    public function movieepisodelist(Request $request,$moviename_id)
    {
        $moviedata=MovieName::whereId($moviename_id)->first();
        $movieslistall=Movie::where('moviename_id',$moviedata['id']);         
        $movieslists = Movie::where('moviename_id',$moviedata['id'])->orderBy('season_number', 'asc')->paginate(30); 

        return view('admin.movies.movieepisodelist',compact('moviedata','movieslistall','movieslists'));
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
    public function store(MovieFormRequest $request)
    { 
       if($request->hasFile('video_file'))
        { 
           $video_file=$request->file('video_file');           
           $video_filename=$video_file->getClientOriginalName();
          // $video_file->move(public_path().'/images/movies/',$video_file);
           $video_file->storeAs('/', $video_filename, 'uploads');
           

           if($request->hasfile('encodednames'))
           {
              foreach($request->file('encodednames') as $file)
              { 
                $name =$file->getClientOriginalName();
                $file->storeAs('/', $name, 'uploads');                 
              }
              $encoded_name= preg_replace('/\\.[^.\\s]{3,4}$/', '', $video_filename) . '.m3u8';

              $movie=Movie::create([
                'episode_name' =>  $request->get('episode_name'), 
                'moviename_id' => $request->get('moviename_id'),
                'season_number' => $request->get('season_number'),
                'video_file' => $video_filename,
                'disk' => 'uploads',
                'converted_for_streaming_at' => Carbon::now(),
                'processed' => true,
                'stream_path' => $encoded_name
               ]);
            }
            else
            {
               return redirect()->back()->with(['errorstatus'=> ' This Movie Must be Add Encoded File']);
            }
         }      
         else
         {
           $movie=Movie::create([
            'episode_name' =>  $request->get('episode_name'), 
            'moviename_id' => $request->get('moviename_id'),
            'season_number' => $request->get('season_number'),
            //'processed' => '2',                  
          ]);
         }
        if($request->get('status'))
        {
          $moviename=MovieName::whereId($request->get('moviename_id'))->first();
          $moviename->status=$request->get('status');
          $moviename->updated_at=Carbon::now()->timestamp;
          $moviename->update();
        }
       // $movies_table=Movie::create([
       //      'episode_name' =>  $request->get('episode_name'), 
       //      'moviename_id' => $request->get('moviename_id'),
       //      'season_number' => $request->get('season_number'),
       //      'video_file' => $video_filename,                  
       //  ]);
      // $validatedData = $request->validate([
      //           'subtitles.subtitle_file' => 'required|mimes:jpeg'
      //            ]); 
        if($request->subtitle_name != null)
        {
         
          foreach($request->subtitle_name as $item=>$v)
          {
            if($request->hasFile('subtitle_file'))
            {  
                 $subtitle_file=$request->file('subtitle_file');
                 $subtitle_filename=uniqid().'-'.$subtitle_file[$item]->getClientOriginalName();
                 $subtitle_file[$item]->move(public_path().'/images/subtitles/',$subtitle_filename);  
                 $data2=array(
                 'movie_id'=> $movie->id,
                 'subtitle_name'=> $request->subtitle_name[$item],
                 'subtitle_file'=>$subtitle_filename
                 ); 
                  DB::table('subtitles') -> insert($data2);      
            }              
          }           
        }
         Comment::create([
            'content' => Auth::user()->name ." created Movie for Episode - ".$movie->episode_name."( Season - ".$movie->season_number.")",
            'user_id' => Auth::user()->id,
            'commendable_id' =>$movie->id ,
            'commendable_type' => "movies"        
        ]);
        return redirect()->back()->with(['status'=> 'Successfully Saved Movie Upload']);      
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
    public function update(Request $request,$moviename_id,$id)
    {
       $movie=Movie::whereId($id)->firstOrFail();

        if($request->hasFile('video_file'))
        { 
           $video_file=$request->file('video_file');           
           $video_filename=$video_file->getClientOriginalName();
          // $video_file->move(public_path().'/images/movies/',$video_file);
           $video_file->storeAs('/', $video_filename, 'uploads');
           

           if($request->hasfile('encodednames'))
           {
             //MovieJobConverting::dispatch($movie,$);
              foreach($request->file('encodednames') as $file)
              { 
                $name =$file->getClientOriginalName();
                $file->storeAs('/', $name, 'uploads');                 
              }
              $encoded_name= preg_replace('/\\.[^.\\s]{3,4}$/', '', $video_filename) . '.m3u8';
              
              $movie->episode_name=$request->get('episode_name');
              $movie->season_number=$request->get('season_number');
              $movie->video_file=$video_filename;
              $movie->converted_for_streaming_at=Carbon::now();
              $movie->processed=true;
              $movie->stream_path=$encoded_name;
             
              $movie->updated_at=Carbon::now()->timestamp;
              $movie->update();           
            }
            else
            {   
              return redirect()->back()->with(['errorstatus'=> ' This Movie Must be Added Encoded File']);
            }

        // if($request->hasFile('video_file'))
        // {  
        //    $video_file=$request->file('video_file');
        //    $video_filename=uniqid().'-'.$video_file->getClientOriginalName();
        //    $video_file->storeAs('/', $video_filename, 'uploads');
 
        //    $movie->episode_name=$request->get('episode_name');
        //    $movie->season_number=$request->get('season_number');
        //    $movie->video_file=$video_filename;
          
        //    $movie->updated_at=Carbon::now()->timestamp;
        //    $movie->update();
        //    ConvertMovieforStreaming::dispatch($movie);            
        }
        else
        { 
           $movie->episode_name=$request->get('episode_name');
           $movie->season_number=$request->get('season_number');
           $movie->updated_at=Carbon::now()->timestamp;
           $movie->update();
        }
       
        if($request->get('status'))
        {
          $moviename=MovieName::whereId($request->get('moviename_id'))->first();
          $moviename->status=$request->get('status');
          $moviename->updated_at=Carbon::now()->timestamp;
          $moviename->update();
        }       

       

        $subtitles=Subtitle::where('movie_id',$id)->get();
        foreach($subtitles as $subtitle)
        {
          DB::table('subtitles')->where('id', $subtitle->id)->delete();
        }
        
       
        if($request->subtitle_namedb != null)
        {         
          foreach($request->subtitle_namedb as $item=>$v)
          {
                
            if($request->input('subtitle_filedb'))
            { 
                 $subtitle_file=$request->input('subtitle_filedb');
                 $subtitle_filename= $subtitle_file[$item];
                  $data3=array(
                 'movie_id'=> $movie->id,
                 'subtitle_name'=> $request->subtitle_namedb[$item],
                 'subtitle_file'=>$subtitle_filename
                 ); 
                  DB::table('subtitles') -> insert($data3);    
            }             
                           
          }           
        }

         if($request->subtitle_name != null)
        {         
          foreach($request->subtitle_name as $item=>$v)
          {
                
            if($request->hasFile('subtitle_file'))
            { 
                 $subtitle_file=$request->file('subtitle_file');
                 $subtitle_filename=uniqid().'-'.$subtitle_file[$item]->getClientOriginalName();
                 $subtitle_file[$item]->move(public_path().'/images/subtitles/',$subtitle_filename);
                  $data2=array(
                 'movie_id'=> $movie->id,
                 'subtitle_name'=> $request->subtitle_name[$item],
                 'subtitle_file'=>$subtitle_filename
                 ); 
                  DB::table('subtitles') -> insert($data2);       
            }             
                           
          }           
        }

         Comment::create([
            'content' => Auth::user()->name ." created Movie for Episode - ".$movie->episode_name."( Season - ".$movie->season_number.")",
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "movies"        
        ]);
         return redirect()->back()->with(['status'=>$movie->episode_name.' Has Been Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($moviename_id,$id)
    {
        $movie=Movie::where('moviename_id',$moviename_id)->where('id',$id)->firstOrFail();

        $movie->delete();
        $subtitles=Subtitle::where('movie_id',$id)->get();
        foreach($subtitles as $subtitle)
        {
          DB::table('subtitles')->where('id', $subtitle->id)->delete();
        }
        
        Comment::create([
            'content' => Auth::user()->name ." deleted Movie For Episode - ".$movie->episode_name,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "movies"        
        ]);
        
        return redirect()->back()->with(['status'=>'Episode - '.$movie->episode_name.' Has Been Deleted']);
    }
    public function statusupdate(Request $request,$moviename_id)
    {
      $moviename=MovieName::whereId($moviename_id)->first();
      $moviename->status=$request->get('status');
      $moviename->updated_at=Carbon::now()->timestamp;
      $moviename->update();

      Comment::create([
            'content' => Auth::user()->name ." Updated Movie ".$moviename->name."for Status  ".$moviename->status,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$moviename_id ,
            'commendable_type' => "movies"        
        ]);
      
      return redirect()->back()->with(['status'=>$moviename->name .' Has Been Updated for Status'.$moviename->status ]);
    }

    public function moviesinglelist(Request $request,$moviename_id)
    {
        $moviedata=MovieName::whereId($moviename_id)->first();
        $movieslistall=Movie::where('moviename_id',$moviedata['id']);         
        $movieslists = Movie::where('moviename_id',$moviedata['id'])->orderBy('episode_name', 'asc')->paginate(30); 

        return view('admin.movies.moviesinglelist',compact('moviedata','movieslistall','movieslists'));
    }

     public function singlemoviestore(MovieFormRequest $request)
    { 
      if($request->hasFile('video_file'))
        { 
           $video_file=$request->file('video_file');           
           $video_filename=$video_file->getClientOriginalName();
          // $video_file->move(public_path().'/images/movies/',$video_file);
           $video_file->storeAs('/', $video_filename, 'uploads');
           

           if($request->hasfile('encodednames'))
           {
              foreach($request->file('encodednames') as $file)
              { 
                $name =$file->getClientOriginalName();
                $file->storeAs('/', $name, 'uploads');                 
              }
              $encoded_name= preg_replace('/\\.[^.\\s]{3,4}$/', '', $video_filename) . '.m3u8';

              $movie=Movie::create([
                'episode_name' =>  $request->get('episode_name'), 
                'moviename_id' => $request->get('moviename_id'),
                'season_number' => '1',
                'video_file' => $video_filename,
                'disk' => 'uploads',
                'converted_for_streaming_at' => Carbon::now(),
                'processed' => true,
                'stream_path' => $encoded_name
               ]);
            }
            else
            {
               return redirect()->back()->with(['errorstatus'=> ' This Movie Must be Add Encoded File']);
            }
         }      
      // if($request->hasFile('video_file'))
      //   { 
      //      $video_file=$request->file('video_file');
      //      $video_filename=uniqid().'-'.$video_file->getClientOriginalName();
      //      //$video_file->move(public_path().'/images/movies/',$video_filename); 
      //      $video_file->storeAs('/', $video_filename, 'uploads');

      //      $movie=Movie::create([
      //       'episode_name' =>  $request->get('episode_name'), 
      //       'moviename_id' => $request->get('moviename_id'),
      //       'season_number' => $request->get('season_number'),
      //       'video_file' => $video_filename,
      //       'disk' => 'uploads',
      //      ]); 
      //      ConvertMovieforStreaming::dispatch($movie);     
      //   }
        else
        {
           $movie=Movie::create([
            'episode_name' =>  $request->get('episode_name'), 
            'moviename_id' => $request->get('moviename_id'),
           // 'season_number' => $request->get('season_number'),
            //'processed' => '2',                  
          ]);
        }
       // if($request->hasFile('video_file'))
       //  { 
       //     $video_file=$request->file('video_file');
       //     $video_filename=uniqid().'-'.$video_file->getClientOriginalName();
       //     $video_file->move(public_path().'/images/movies/',$video_filename);       
       //  }
        if($request->get('status'))
        {
          $moviename=MovieName::whereId($request->get('moviename_id'))->first();
          $moviename->status=$request->get('status');
          $moviename->updated_at=Carbon::now()->timestamp;
          $moviename->update();
        }
       // $movies_table=Movie::create([
       //      'episode_name' =>  $request->get('episode_name'), 
       //      'moviename_id' => $request->get('moviename_id'),
            
       //      'video_file' => $video_filename,                  
       //  ]);
      // $validatedData = $request->validate([
      //           'subtitles.subtitle_file' => 'required|mimes:jpeg'
      //            ]); 
        if($request->subtitle_name != 0 )
        {
         
          foreach($request->subtitle_name as $item=>$v)
          {
               //$this->validate($request,[]); 
                
            if($request->hasFile('subtitle_file'))
            { 
                 $subtitle_file=$request->file('subtitle_file');
                 $subtitle_filename=uniqid().'-'.$subtitle_file[$item]->getClientOriginalName();
                 $subtitle_file[$item]->move(public_path().'/images/subtitles/',$subtitle_filename);   
                 $data2=array(
                 'movie_id'=> $movie->id,
                 'subtitle_name'=> $request->subtitle_name[$item],
                 'subtitle_file'=>$subtitle_filename
                 ); 
                 // dd($data2);
                  DB::table('subtitles') -> insert($data2);      
            }
                
                          
          }           
        }
         Comment::create([
            'content' => Auth::user()->name ." created Movie ".$movie->episode_name,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$movie->id ,
            'commendable_type' => "movies"        
        ]);
        return redirect()->back()->with(['status'=> 'Successfully Saved Movie Upload']);      
    }

    public function updatemoviesingle(Request $request,$moviename_id,$id)
    {
       $movie=Movie::whereId($id)->firstOrFail();

        if($request->hasFile('video_file'))
        { 
           $video_file=$request->file('video_file');           
           $video_filename=$video_file->getClientOriginalName();
          // $video_file->move(public_path().'/images/movies/',$video_file);
           $video_file->storeAs('/', $video_filename, 'uploads');
           

           if($request->hasfile('encodednames'))
           {
             //MovieJobConverting::dispatch($movie,$);
              foreach($request->file('encodednames') as $file)
              { 
                $name =$file->getClientOriginalName();
                $file->storeAs('/', $name, 'uploads');                 
              }
              $encoded_name= preg_replace('/\\.[^.\\s]{3,4}$/', '', $video_filename) . '.m3u8';
              
              $movie->episode_name=$request->get('episode_name');
             // $movie->season_number=$request->get('season_number');
              $movie->video_file=$video_filename;
              $movie->converted_for_streaming_at=Carbon::now();
              $movie->processed=true;
              $movie->stream_path=$encoded_name;
             
              $movie->updated_at=Carbon::now()->timestamp;
              $movie->update();           
            }
            else
            {   
              return redirect()->back()->with(['errorstatus'=> ' This Movie Must be Added Encoded File']);
            }

        // if($request->hasFile('video_file'))
        // {  
        //    $video_file=$request->file('video_file');
        //    $video_filename=uniqid().'-'.$video_file->getClientOriginalName();
        //    $video_file->storeAs('/', $video_filename, 'uploads');
 
        //    $movie->episode_name=$request->get('episode_name');
        //    $movie->season_number=$request->get('season_number');
        //    $movie->video_file=$video_filename;
          
        //    $movie->updated_at=Carbon::now()->timestamp;
        //    $movie->update();
        //    ConvertMovieforStreaming::dispatch($movie);            
        }

        // if($request->hasFile('video_file'))
        // {  
        //    $video_file=$request->file('video_file');
        //    $video_filename=uniqid().'-'.$video_file->getClientOriginalName();
        //    $video_file->storeAs('/', $video_filename, 'uploads');
 
        //    $movie->episode_name=$request->get('episode_name');
        //    $movie->season_number=$request->get('season_number');
        //    $movie->video_file=$video_filename;
          
        //    $movie->updated_at=Carbon::now()->timestamp;
        //    $movie->update();
        //    ConvertMovieforStreaming::dispatch($movie);            
        // }
        else
        { 
           $movie->episode_name=$request->get('episode_name');
           //$movie->season_number=$request->get('season_number');
           $movie->updated_at=Carbon::now()->timestamp;
           $movie->update();
        }

        if($request->get('status'))
        {
          $moviename=MovieName::whereId($request->get('moviename_id'))->first();
          $moviename->status=$request->get('status');
          $moviename->updated_at=Carbon::now()->timestamp;
          $moviename->update();
        }

        $movie->episode_name=$request->get('episode_name');
        //$movie->season_number=$request->get('season_number');
        $movie->updated_at=Carbon::now()->timestamp;
        $movie->update();
        $subtitles=Subtitle::where('movie_id',$id)->get();
        foreach($subtitles as $subtitle)
        {
          DB::table('subtitles')->where('id', $subtitle->id)->delete();
        }
        
       //dd($request->subtitle_namedb);
        if($request->subtitle_namedb != null)
        {         
          foreach($request->subtitle_namedb as $item=>$v)
          {
                
            if($request->input('subtitle_filedb'))
            { 
                 $subtitle_file=$request->input('subtitle_filedb');
                 $subtitle_filename= $subtitle_file[$item];
                 $data3=array(
             'movie_id'=> $movie->id,
             'subtitle_name'=> $request->subtitle_namedb[$item],
             'subtitle_file'=>$subtitle_filename
             ); 
              DB::table('subtitles') -> insert($data3);        
            }             
                        
          }           
        }

         if($request->subtitle_name != 0)
        {         
          foreach($request->subtitle_name as $item=>$v)
          {
                
            if($request->hasFile('subtitle_file'))
            { 
                 $subtitle_file=$request->file('subtitle_file');
                 $subtitle_filename=uniqid().'-'.$subtitle_file[$item]->getClientOriginalName();
                 $subtitle_file[$item]->move(public_path().'/images/subtitles/',$subtitle_filename); 
                 $data2=array(
             'movie_id'=> $movie->id,
             'subtitle_name'=> $request->subtitle_name[$item],
             'subtitle_file'=>$subtitle_filename
             ); 
              DB::table('subtitles') -> insert($data2);       
            }             
                           
          }           
        }

         Comment::create([
            'content' => Auth::user()->name ." created Movie for ".$movie->episode_name,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "movies"        
        ]);
         return redirect()->back()->with(['status'=>$movie->episode_name.' Has Been Updated']);
    }

    public function destroymoviesingle($moviename_id,$id)
    {
        $movie=Movie::where('moviename_id',$moviename_id)->where('id',$id)->firstOrFail();   
        $movie->delete();
        $subtitles=Subtitle::where('movie_id',$id)->get();
        foreach($subtitles as $subtitle)
        {
          DB::table('subtitles')->where('id', $subtitle->id)->delete();
        }
        
        Comment::create([
            'content' => Auth::user()->name ." deleted Movie For Episode - ".$movie->episode_name,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "movies"        
        ]);
        
        return redirect()->back()->with(['status'=>$movie->episode_name.' Has Been Deleted']);
    }

}
