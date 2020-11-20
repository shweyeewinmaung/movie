<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdminRegisterFormRequest;
use App\Admin;
use App\User;
use App\Typeuser;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Category;
use App\SubCategory;
use DB;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function logout()
    {
        Comment::create([
            'content' => Auth::user()->name ." Logout from Admin Dashboard",
            'user_id' => Auth::user()->id,
            'commendable_id' =>Auth::user()->id ,
            'commendable_type' => "admins"        
        ]);
         Auth::guard('admin')->logout();
        //return redirect('/');
        return redirect('admin/login');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories=Category::orderBy('name','asc')->get();
        $users=User::all();
        $activeusers= DB::table('users')
                  ->join('typeusers','typeusers.user_id','=','users.id')
                  ->where('typeusers.status','=','active');
        $inactiveusers= DB::table('users')
                  ->join('typeusers','typeusers.user_id','=','users.id')
                  ->where('typeusers.status','=','inactive');

        $freeusers= DB::table('users')
                  ->join('typeusers','typeusers.user_id','=','users.id')
                  ->where('typeusers.typeofuser','=','free');
        $preusers= DB::table('users')
                  ->join('typeusers','typeusers.user_id','=','users.id')
                  ->where('typeusers.typeofuser','=','premier');
        $today=date('Y-m-d');
        //dd($today);
        $todayusers = User::where('created_at', 'LIKE', "%{$today}%");

        return view('admin',compact('categories','users','activeusers','inactiveusers','freeusers','preusers','todayusers'));
    }
    public function register()
    {
        return view('admin.adminuser.adminregister');
    }
    public function store(AdminRegisterFormRequest $request)    
    {
        $admin_table=Admin::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'job_title' => $request->get('job_title'),
            'city' => $request->get('city'),
            'township' => $request->get('township'),
            'address' => $request->get('address'),
        ]);
        
          Comment::create([
            'content' => Auth::user()->name ." register new admin ",
            'user_id' => Auth::user()->id,
            'commendable_id' =>$admin_table->id ,
            'commendable_type' => "admins"        
        ]);
        return redirect('admin/adminlist')->with("status","Successfully Saved Admin");       
    }
    // public function adminhistory(Request $request,$id)    
    // {
    //     if (\Gate::allows('isadmin')) 
    //     { 
    //         //$user=Admin::whereId($id)->firstOrFail();
    //         $admin=Admin::find($id);
    //         $commentsall= $admin->ments();
    //         $comments= $admin->ments()->orderBy('created_at', 'desc')->paginate(2);
           
    //         return view('admin.adminhistory',compact('admin','comments','commentsall'));
    //     }abort(404,"Sorry");
    // }
    public function adminlist()    
    {
      if (\Gate::allows('issuper') || \Gate::allows('isadmin')) 
       { 
         
        $adminlistsall = Admin::all();
        $adminlists = Admin::orderBy('id', 'asc')->paginate(30); 
        $s="";
       
        
        return view('admin.adminuser.adminuserlist',compact('adminlists','adminlistsall','s'));
      }abort(404,"Sorry");
    }

 
  public function searchpost(Request $request)
  {
       if (\Gate::allows('issuper') || \Gate::allows('isadmin')) 
       { 
            $s = $request->search;

            $adminlistsall=Admin::where('name', 'LIKE', "%{$s}%")
            ->orWhere('email', 'LIKE', "%{$s}%")
            ->orWhere('job_title', 'LIKE', "%{$s}%")
            ->orWhere('city', 'LIKE', "%{$s}%");         
            
             $adminlists = Admin::where('name', 'LIKE', "%{$s}%")
            ->orWhere('email', 'LIKE', "%{$s}%")
            ->orWhere('job_title', 'LIKE', "%{$s}%")
            ->orWhere('city', 'LIKE', "%{$s}%")
            ->orderBy('id','asc')
            ->paginate(30);            
            
            return view('admin.adminuser.adminuserlist',compact('adminlists','adminlistsall','s'));
        }abort(404,"Sorry");
  }
  public function update($id,Request $request)
    {        
        $admin=Admin::whereId($id)->firstOrFail();
        if($admin->job_title == 'super_admin')
        {
            return redirect()->back()->with(['error'=>$admin->name.' cannot update']);
        }
        else
        {
            if($request->get('password') == "")
         {
             $password= $admin->password;
         }
         else
         {           
            $password=bcrypt($request->get('password'));
         }
        
         $admin->name=$request->get('name');
         $admin->email=$request->get('email');
         $admin->password=$password;
         $admin->job_title=$request->get('job_title');
         $admin->city=$request->get('city');
         $admin->township=$request->get('township');
         $admin->address=$request->get('address');
         $admin->updated_at=Carbon::now()->timestamp;
         $admin->update();

        Comment::create([
            'content' => Auth::user()->name ." updated admin ".$admin->name ."(".$admin->email.')',
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "admins"        
        ]);
         
         return redirect()->back()->with(['status'=>$admin->name.' Has Been Updated']);
        }
    }
     public function destory($id)
    {     
        $admin=Admin::whereId($id)->firstOrFail();   
        if($admin->job_title == 'super_admin')
        {
            return redirect()->back()->with(['error'=>$admin->name.' cannot delete']);
        }
        else
        {            
            $admin->delete();
            Comment::create([
            'content' => Auth::user()->name ." deleted admin ".$admin->name ."(".$admin->email.')',
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "admins"
            ]);
            return redirect()->back()->with(['status'=>$admin->name.' Has Been Deleted']);
        }        
    }
}
