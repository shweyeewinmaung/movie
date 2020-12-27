<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Carbon\Carbon;
use App\SubCategory;
use App\MovieName;
use App\Movie;
use App\Subtitle;
use App\Avator;
use App\Advertising;
use DB;
use App\Http\Resources\SubCategoryResource;
use App\Http\Resources\MovieNameResource;
use App\Http\Resources\MovieResource;
use App\Http\Resources\SubtitleResource;
use App\Http\Resources\RecentlyMovieResource;
use App\Http\Resources\SamplelinkResource;
use App\Http\Resources\SampleHomeSliderResource;
use App\Http\Resources\SampleHomeSliderMovieResource;
use App\Http\Resources\SampleHomeSliderSeasonResource;
use App\Http\Resources\SampleRecentResource;

use App\Http\Resources\SeasonResource;
use App\Http\Resources\AdsResource;

class APICategoryController extends Controller
{
	public $successStatus = 200;
	public $message = 'Success';
    public $con = true;

    public function allcategories() 
    {
    	$categories=Category::orderBy('name','ASC')->get();     	
    	return response()->json($categories, $this->successStatus); 
    }

    public function subcategories($id) 
    {
    	$sub = SubCategory::with(['categories'])->where('category_id',$id)->orderBy('id','ASC')->get();
    	 
    	$subcategoriescollection= SubCategoryResource::collection($sub);
    	return response()->json($subcategoriescollection, $this->successStatus);
    	// $categories = Category::where('id', $id)->get();

     //      if (count($categories) > 0)
     //      {
     //          $subCat = array();
     //          $players = array();
     //         // $roster['categoryname'] = $categories['name'];
     //          foreach ($categories as $i => $category) 
     //          {
     //            $subchilds = SubCategory::where('category_id', $category->id)->get();
     //            if (count($subchilds) > 0)
     //            {
     //            	//$roster[$category->name] = $players;                	
     //            	foreach ($subchilds as $subchild) 
     //            	{
     //            		//$roster[$subchild->id] = $subchild->name;
     //            		$roster[$category->name][$subchild->id] = $subchild->name;
     //            	}
     //            }
     //            else
     //            {
     //            	$roster[$category->name] = $players;
     //               // $roster[$category->name][$child->name] = $players;
     //            }
     //          }
     //      }
     //     //return response()->json($roster,200); 
     //       return response()->json(['message' =>$this->message,'results'=> $roster], $this->successStatus); 
  
    }
    public function movienamebysub($id) 
    {
       $movienames = MovieName::with(['subcategories'])->where('subcategory_id',$id)->orderBy('name','ASC')->get();
      
        $movienamescollection= MovieNameResource::collection($movienames); 
        return response()->json($movienamescollection, $this->successStatus);
        
    }
    public function moviebyid($id) 
    {
       $movienames = MovieName::with(['subcategories'])->where('id',$id)->get();
       $movienamescollection= MovieResource::collection($movienames); 
       return response()->json($movienamescollection, $this->successStatus);
     
    }
    public function recentlymoviename() 
    {       
        $movies = Movie::with(['subtitles','movienames'])->orderBy('id', 'desc')->groupBy('moviename_id')->take(10)->get();
       // dd($movies->moviename_id);
        $moviescollection= RecentlyMovieResource::collection($movies); 
        return response()->json($moviescollection, $this->successStatus);    
       
    }
    public function homeslider() 
    {
        $movienames=MovieName::with(['subcategories'])->where('show_in_slider','1')->orderBy('id','desc')->get();
        $movienamescollection= MovieResource::collection($movienames)->take(10);
        return response()->json($movienamescollection, $this->successStatus);
    }
    public function moviesbycat($id) 
    {
         $movienames = MovieName::with(['subcategories'])->where('category_id',$id)->get();
         $movienamescollection= MovieResource::collection($movienames); 
         return response()->json($movienamescollection, $this->successStatus);
    }

    public function samplelink() 
    {
        $movies = Movie::with(['subtitles','movienames'])->orderBy('id', 'desc')->groupBy('moviename_id')->take(10)->get();
        
        $moviescollection= SamplelinkResource::collection($movies); 
        return response()->json($moviescollection, $this->successStatus); 
    }
    public function samplehomeslider() 
    {
        $movienames=MovieName::with(['subcategories'])->where('show_in_slider','1')->orderBy('id','desc')->get();
        $movienamescollection= SampleHomeSliderResource::collection($movienames)->take(10);
        return response()->json($movienamescollection, $this->successStatus);
    }
    public function samplehomeslidermovie($id) 
    {
       $moviename=MovieName::with(['subcategories'])->where('id',$id)->orderBy('id','desc')->get();
       $moviecollection= SampleHomeSliderMovieResource::collection($moviename);
        return response()->json($moviecollection, $this->successStatus);
    }
    public function samplehomeslidermovieid($id,$season) 
    {       
        $movie=Movie::with(['subtitles'])->where('moviename_id',$id)->where('season_number',$season)->orderBy('id', 'asc')->get();
        $moviecollection= SeasonResource::collection($movie);
       return response()->json($moviecollection, $this->successStatus);
    }
    public function samplerecent() 
    {
        $movies = Movie::with(['subtitles','movienames'])->orderBy('id', 'desc')->groupBy('moviename_id')->take(10)->get();
         $moviescollection= SampleRecentResource::collection($movies); 
        return response()->json($moviescollection, $this->successStatus);        
    }

    public function samplemoviebycat($id) 
    {
         $movienames = MovieName::with(['subcategories'])->where('category_id',$id)->orderBy('name','asc')->get();
         $movienamescollection= SampleHomeSliderResource::collection($movienames); 
         return response()->json($movienamescollection, $this->successStatus);              
    }
   
}
