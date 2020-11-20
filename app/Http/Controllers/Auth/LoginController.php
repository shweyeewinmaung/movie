<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Laravel\Socialite\Facades\Socialite;
use App\User; 
//use Auth;
//use Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest',['except'=>['logout','userLogout']]);
    }
    public function userLogout()
    {
        Auth::guard('web')->logout();
        return redirect('/home');
       // Auth::guard('admin')->logout();
        //return redirect('/');
        //return redirect('admin/login');
    }


    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider() 
    {

        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback() 
    {
         
        $SocialUser = Socialite::driver('facebook')->user();
        //dd($SocialUser->code);
        $facebook_user_id = $SocialUser->getId(); // unique facebook user id
        $user = User::where('provider_id', $facebook_user_id)->first();

        if (!$user) {
            $user = new User;
            $user->name = $SocialUser->name;
            $user->email = $SocialUser->email;
            $user->password = bcrypt(123456);
            $user->provider_id = $facebook_user_id;
            $user->provider = "facebook";
            $user->save();
        }
        Auth::loginUsingId($user->id);
        //dd($SocialUser);
      return redirect('/home')->with(['status'=>'Successfully login with facebook']); 
    }
    public function redirectToProviderGoogle() 
    {

        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallbackGoogle() 
    {
         
        $SocialUser = Socialite::driver('google')->user();
        //dd($SocialUser);
        $google_user_id = $SocialUser->getId(); // unique facebook user id
        $user = User::where('provider_id', $google_user_id)->first();

        if (!$user) {
            $user = new User;
            $user->name = $SocialUser->name;
            $user->email = $SocialUser->email;
            $user->password = bcrypt(123456);
            $user->provider_id = $google_user_id;
            $user->provider = "google";
            $user->save();
        }
        Auth::loginUsingId($user->id);
      return redirect('/home')->with(['status'=>'Successfully login with google']); 
    }
}
