<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Admin;
use App\Contact;
use App\Comment;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
        $contact = Contact::whereId(1)->firstOrFail();

        return view('admin.contacts.index',compact('contact'));
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
         $contacts=Contact::create([
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
          
        ]);
        
          Comment::create([
            'content' => " Save New Contact ",
            'user_id' => Auth::user()->id,
            'commendable_id' =>$contacts->id ,
            'commendable_type' => "contacts"        
        ]);
      return redirect()->back()->with(['status'=> ' Save New Contact']);
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
       $contact = Contact::whereId($id)->firstOrFail();
       $contact->phone=$request->get('phone');
       $contact->email=$request->get('email');
       $contact->updated_at=Carbon::now()->timestamp;
       $contact->update();

        Comment::create([
            'content' => Auth::user()->name ." updated Contact ",
            'user_id' => Auth::user()->id,
            'commendable_id' =>$id ,
            'commendable_type' => "contacts"        
        ]);
         
         return redirect()->back()->with(['status'=> Auth::user()->name.' Has Been Updated Contact']);
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
