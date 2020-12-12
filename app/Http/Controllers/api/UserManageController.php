<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User; 
use App\Typeuser;
use Auth;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\TokenDelete;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Validator;


class UserManageController extends Controller
{
   
    use TokenDelete;
   
    //use AuthenticatesUsers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    //     $validated_data = $request->validate([
    //   'name' =>'required',
    //   'phone' => 'required|unique:users,phone',
    //   'email' => 'email',
    // ]);
    //     return response()->json(['status'=>'fail'],401);
      //   $user = new User();
      // return $user->name = $request->name;


    //     $user = new User();
    // $user->name = $request->name;
    // $user->email = $request->email;
    // $user->password = Hash::make($request->password);
    // $user->phone = $request->phone;
    // $user->city = $request->division;
    // $user->township = $request->township;

    // if ($request->has('countrycode')){
    //   $user->countrycode = $request->countrycode;
    // }

    // if ($request->has('sfu_code')) {
    //   $user->sfu_code = $request->sfu_code;
    // }

    // $user->save();
    // $users = User::findOrFail($user->id);
    // $users['token'] =  $user->createToken('Frontend')->accessToken;
    // $users['status'] = 'success';
    // return response()->json($users,200);


        // $token = $request->token;
        // dd($SocialUser);
    }
     public function userroutelogin(Request $request) 
    { 
        $validated_data = Validator::make($request->all(), [ 
            'email' => 'required',
            'password' => 'required',            
        ]);

        if ($validated_data->fails()) 
        { 
            return response()->json(['status'=>$validated_data->errors()], 401);          
        }
       if(Auth::guard('web')->attempt(['email'=>$request->email,'password'=>$request->password]))
       {
          $user = Auth::user();
          $token = $user->createToken('Android');
     
          $typeuser=Typeuser::where('user_id',$user->id)->first();         
           if($typeuser->status == 'active')
           {
               $user['token'] =  $token->accessToken;
               $user['status'] = 'success';
               $user['type'] = $typeuser;
          
           return response()->json($user,200); 
           }
           else
           {
            return response()->json(['status' => 'User is Not Active']);
           }
       
          // $user['token'] =  $token->accessToken;
          // $user['status'] = 'success';
          // $user['type'] = $typeuser;
          
          // return response()->json($user,200); 
        }
       return response()->json(['status'=>'fail with username and password'],200);
     
    }
    public function userrouteregister(Request $request) 
    { 
        $check = User::where('email',$request->email)->first();
        if(!empty($check))
        {
          return response()->json([ 'status' => 'Fail with duplicate Email'],401);        
        }
        
        $validated_data = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|unique:users,email',
            'password' => 'required',            
        ]);

        if ($validated_data->fails()) 
        { 
            return response()->json(['status'=>$validated_data->errors()], 401);            
        }


        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $last_usercode = User::orderBy('id','DESC')->first();
        $user->user_code = '#'.str_pad($last_usercode->id + 1, 5, "0123", STR_PAD_LEFT);
        $user->save();
       // dd($user);
        $typeuser = new Typeuser;
        $typeuser->user_id = $user->id;
        $typeuser->typeofuser = "free";
        $typeuser->start_date =Carbon::now();
        //$typeuser->end_date =Carbon::now()->timestamp;
        $typeuser->status ='active';
        $typeuser->save();

        $user = $user->fresh();
        $user['token'] =  $user->createToken('Android')->accessToken;
        $user['status'] = 'successful register';
        $user['type'] = $typeuser;
        
        return response()->json($user,200); 
    }

    public function socialroute(Request $request) 
    { 
        $validated_data = Validator::make($request->all(), [ 
            'provider_id' => 'required', 
            'provider' => 'required',
            //'password' => 'required',            
        ]);

        if ($validated_data->fails()) 
        { 
            return response()->json(['status'=>$validated_data->errors()], 401);            
        }
        
       if($request->email == null)
       {
          $check = User::where('provider_id',$request->provider_id)->where('provider',$request->provider)->first();
       }
       else
       {
           
             $check = User::where('email',$request->email)->first();
         
       }
     // dd($check);
        //if($request->email == null){ $email ="";}else{ $email = $request->email;}
 
        if($check == null)
        {
            $user = new User;
            $last_usercode = User::orderBy('id','DESC')->first();
            $user->user_code = '#'.str_pad($last_usercode->id + 1, 5, "0123", STR_PAD_LEFT);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make(123456);
            $user->provider_id = $request->provider_id;
            $user->provider = $request->provider;
            $user->save();

            $typeuser = new Typeuser;
            $typeuser->user_id = $user->id;
            $typeuser->typeofuser = "free";
            
            $typeuser->start_date =Carbon::now();
            //$typeuser->end_date =Carbon::now()->timestamp;
            $typeuser->status = "active";
            $typeuser->save();
            
            $typeuser=Typeuser::where('user_id',$user->id)->first();
            $users = Auth::loginUsingId($user->id);
            $users['token'] =  $user->createToken('Android')->accessToken;
            $users['status'] = 'success with new user';
            $users['type'] = $typeuser;
            return response()->json($users,200);
        }
        else
        {
           $typeuser=Typeuser::where('user_id',$check->id)->first();
           //dd($typeuser->status);
           if($typeuser->status == 'active')
           {
               $users = Auth::loginUsingId($check->id);

               $users['token'] =  $users->createToken('Android')->accessToken;
               $users['status'] = 'success with old user';
               $users['type'] = $typeuser;
               return response()->json($users,200);
           }
           else
           {
            return response()->json(['status' => 'fail']);
           }
          
        }
       // dd($aa);
       // $check = User::where('email',$request->email)->first();
    }
    
    // public function loginwithsocial(Request $request) 
    // {

    //    $check = User::where('email',$request->email)->first();

    //     if(!$check)
    //     {
    //         $user = new User;
    //         $user->name = $request->name;
    //         $user->email = $request->email;
    //         $user->password = bcrypt(123456);
    //         $user->provider_id = "123";
    //         $user->provider = "facebook";
    //         $user->save();

    //         $users = Auth::loginUsingId($user->id);
    //         $users['token'] =  $user->createToken('Android')->accessToken;
    //         $users['status'] = 'success with new user';
    //         return response()->json($users,200);
            
    //     }
    //     else
    //     {
    //        //$users = User::findOrFail($check->id);
    //        $users = Auth::loginUsingId($check->id);
    //        $users['token'] =  $users->createToken('Android')->accessToken;
    //        $users['status'] = 'success with old user';
    //        return response()->json($users,200);
    //     }
       
    // }
    

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
