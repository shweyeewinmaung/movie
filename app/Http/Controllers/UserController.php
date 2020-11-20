<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use App\User;
use App\Typeuser;
use App\Comment;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        $usersall=User::all();
        $userslists = User::orderBy('id', 'desc')->paginate(50); 
        $s="";

        return view('admin.users.userlist',compact('usersall','userslists','s'));
    }
    public function searchuser(Request $request)
    {
       $s = $request->search;
      
       $usersall = User::where('name', 'LIKE', "%{$s}%")
                    ->orWhere('email', 'LIKE', "%{$s}%")
                    ->orWhere('provider', 'LIKE', "%{$s}%")
                    ->orWhere('user_code', 'LIKE', "%{$s}%")
                    ->orWhereHas('typeuser', function($q) use ($s){
                      return $q->where('status','like','%'. $s . '%');  
                     })
                    ->orWhereHas('typeuser', function($q) use ($s){
                      return $q->where('typeofuser','like','%'. $s . '%');  
                     });
        $userslists = User::where('name', 'LIKE', "%{$s}%")
                    ->orWhere('email', 'LIKE', "%{$s}%")
                    ->orWhere('provider', 'LIKE', "%{$s}%")
                    ->orWhere('user_code', 'LIKE', "%{$s}%")
                    ->orWhereHas('typeuser', function($q) use ($s){
                      return $q->where('status','like','%'. $s . '%');  
                     })
                    ->orWhereHas('typeuser', function($q) use ($s){
                      return $q->where('typeofuser','like','%'. $s . '%');  
                     })->orderBy('id','desc')
                     ->paginate(50);    
         
           return view('admin.users.userlist',compact('usersall','userslists','s'));
    }
    public function usertypeupdate(Request $request,$id)
    {
        
        $typeuser=Typeuser::where('user_id',$id)->first();
        $typeuser->typeofuser=$request->typeofuser;
        $typeuser->updated_at=Carbon::now()->timestamp;
        $typeuser->update();
     
      Comment::create([
            'content' => Auth::user()->name ." Updated User for Type ".$typeuser->typeofuser,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "users"        
        ]);
      
      return redirect()->back()->with(['status'=>'Type Has Been Updated ' ]);
    }

    public function userstatusupdate(Request $request,$id)
    {
        
        $typeuser=Typeuser::where('user_id',$id)->first();
        $typeuser->status=$request->status;
        $typeuser->updated_at=Carbon::now()->timestamp;
        $typeuser->update();
     
      Comment::create([
            'content' => Auth::user()->name ." Updated User for Status ".$typeuser->status,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "users"        
        ]);
      
      return redirect()->back()->with(['status'=>'Status Has Been Updated' ]);
    }

     public function changepassword(Request $request,$id)
    {
        $user= User::whereId($id)->first();
        $user->password=Hash::make(123456);
        $user->updated_at=Carbon::now()->timestamp;
        $user->update();
      
      Comment::create([
            'content' => Auth::user()->name ." Changed Default Passwrod for ".$user->name,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "users"        
        ]);
      
      return redirect()->back()->with(['status'=>'Default Has Been Updated' ]);
    }
    public function destroyuser($id)
    {
        $user=User::whereId($id)->firstOrFail();          
        $user->delete();

        $typeuser=Typeuser::where('user_id',$id)->first(); 
        $typeuser->delete();

         Comment::create([
            'content' => Auth::user()->name ." deleted User ".$user->name,
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "users"        
        ]);
        
        return redirect()->back()->with(['status'=>$user->name.' Has Been Deleted']);
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
