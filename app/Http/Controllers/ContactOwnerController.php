<?php

namespace App\Http\Controllers;

use App\Models\ContactOwner;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class ContactOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('contact_owner'); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $contactownerfields=$request->post();
        $owner_id= $contactownerfields['owner_id'];
        $userEmail=get_userdata($owner_id)->email;
        $username=get_userdata($owner_id)->name;

        unset($contactownerfields['_token']);
        $data = new ContactOwner;
        $data->user_id = Auth::id(); 
        foreach ($contactownerfields as $key => $contactownerfield) {         
           $data->$key=$contactownerfield; 
       }    
       $data->save();

       $mail_data = [
        'notes' => $contactownerfields['notes'],
        'username' => $username,
        'admin' => Auth::user()->name,
    ]; 
       Mail::send('emails.contact_owner', $mail_data, function($message) use ($userEmail) {
        $message->to($userEmail, 'Rental Project Database')
        ->subject('Rental Project Database - Contact Owner');
        $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')); 
    });

       return redirect()->back()->with('status', 'Contact Owner has been added successfully.'); 
   }

    /**
     * Display the specified resource.
     */
    public function show(ContactOwner $contactOwner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactOwner $contactOwner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactOwner $contactOwner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactOwner $contactOwner)
    {
        //
    }
}
