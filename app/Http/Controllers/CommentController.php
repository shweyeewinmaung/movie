<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use App\Comment;
use App\Admin;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;




class CommentController extends Controller
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
        if (\Gate::allows('issuper') || \Gate::allows('isadmin')) 
       { 
            $commentslists= Comment::get()
          ->groupBy(function($val) {
          return Carbon::parse($val->updated_at)->format('Y-m');
         }); 
          return view('admin.comments.commentslist',compact('commentslists'));
       }abort(404,"Sorry");
    }
    
    public function dateindex($date)
    { 
       if (\Gate::allows('issuper') || \Gate::allows('isadmin')) 
       { 
        $commentslistsall = Comment::where('updated_at','LIKE','%'.$date.'%');
        $commentslists = Comment::where('updated_at','LIKE','%'.$date.'%')
                             ->orderBy('updated_at','desc')->paginate(50);
       $s="";

        return view('admin.comments.commentslistdate',compact('commentslistsall','commentslists','date','s'));
        }abort(404,"Sorry");
     
    }
    public function searchdate(Request $request,$date)
    { 
         if (\Gate::allows('issuper') || \Gate::allows('isadmin')) 
         { 
                $s = $request->search;
                
                $commentslistsall =Comment::where('updated_at', 'LIKE', $date.'%') 
                ->Where('content', 'LIKE', '%'.$s.'%');
 
               $commentslists =Comment::where('updated_at', 'LIKE', $date.'%')               
              ->Where('content', 'LIKE', '%'.$s.'%')
              ->orderBy('updated_at','desc')->paginate(50);
               // dd( $commentslistsall->count());
               return view('admin.comments.commentslistdate',compact('commentslistsall','commentslists','date','s'));
          }abort(404,"Sorry");
    }

    public function dayindex($day)
    { 
        if (\Gate::allows('issuper') || \Gate::allows('isadmin')) 
        { 

            $commentslistsdata = Comment::where('updated_at','LIKE','%'.$day.'%')->get()
                                 ->groupBy(function($val) {
                                 return Carbon::parse($val->updated_at)->format('Y-m-d');
                               }); 
         
          // $commentslistsarray= $commentslistsdata->toArray();
          // $commentslists=$this->paginate($commentslistsarray , 3)->items();
          $commentslists=$commentslistsdata;
          $s=null;

         return view('admin.comments.commentslistday',compact('commentslists','day','s'));
        }abort(404,"Sorry");
    }
    public function searchday(Request $request,$day)
    { 
        if (\Gate::allows('issuper') || \Gate::allows('isadmin')) 
        { 
          $s=$request->day;
          if($s == 1 ||$s == 2 ||$s == 3 ||$s == 4 ||$s == 5 ||$s == 6 ||$s == 7 ||$s == 8 ||$s == 9 )
          {
            $s="0".$s;
          }
          $date=$day.'-'.$s;
          //dd($date);
           $commentslistsdata = Comment::where('updated_at','LIKE','%'.$date.'%')->get()
                                 ->groupBy(function($val) {
                                 return Carbon::parse($val->updated_at)->format('Y-m-d');
                               }); 
            $commentslists=$commentslistsdata;

         return view('admin.comments.commentslistday',compact('commentslists','day','s'));
        }abort(404,"Sorry");
      
    }
    public function paginate($items , $perpage )
    {
        if (\Gate::allows('issuper') || \Gate::allows('isadmin')) 
        {
            $total = count($items);
            $currentpage = \Request::get('page', 1);
            $offset = ($currentpage * $perpage) - $perpage ;
            $itemstoshow = array_slice($items , $offset , $perpage);
            $p = new LengthAwarePaginator($itemstoshow ,$total ,$perpage);
            $p->setPath('http://localhost/agroexpresslink.com/profile');
            return $p;
        }abort(404,"Sorry");
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
    public function store(Request $request)
    {
        //
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
        //
    }
}
