<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Carbon\Carbon;
use App\SubCategory;
use DB;
use App\Http\Resources\SubCategoryResource;

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
    	$sub = SubCategory::with(['categories'])->where('category_id',$id)->orderBy('name','ASC')->get();
    	 
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
}
