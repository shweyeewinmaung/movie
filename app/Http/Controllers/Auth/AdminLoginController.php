<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Comment;
use App\Admin;
class AdminLoginController extends Controller
{
	public function __contruct()
	{
		$this->middleware('guest:admin',['except'=>['logout']]);
	}
    public function index()
    {
        return view('admin');
    }
    public function showLoginForm()
    {
    	return view('auth.admin_login');
    }
    public function login(Request $request)
    {
    	//validate the form data
    	$this->validate($request,[
    		'email'=>'required|email',
    		'password'=>'required|min:6'
    	]);

    	//Attempt to log the user in
    	if(Auth::guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password],$request->remember))
    	{
            $admin=Admin::where('email',$request->email)->first();
            
    		//if successful.then redirect to their intended location
            Comment::create([
            'content' => $admin->name ." Login to Admin Dashboard",
            'user_id' => $admin->id,
            'commendable_id' =>$admin->id ,
            'commendable_type' => "admins"        
        ]);
    		return redirect()->intended(route('admin.dashboard'));
    	}
    	//if unsuccessful , then redirect back to the login with the form data
    	return redirect()->back()->withInput($request->only('email','remember'));
    }
    // public function logout()
    // {
    //     Auth::guard('admin')->logout();
    //     //return redirect('/');
    //     return redirect('admin/login');
    // }
}
