<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Service;
use App\Models\User;
use App\Models\Unit;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     $users=DB::table('users')->orderBy('id','desc')->paginate(20);  
     return view('users', compact('users')); 
 }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role_type=array('admin'=>'Admin','owner'=>'Owner','cleaner'=>'Cleaner');
        return view('add_user', compact('role_type')); 
    }

    public function ownercreate()
    {
        return view('add_owner_user'); 
    }
    public function cleanercreate()
    {
        return view('add_cleaner_user'); 
    }

    public function ownershow($id)
    {
     $units=DB::table('units')->where('owner_id', $id)->orderBy('id','asc')->paginate(20);  
     $user = User::find($id);
     return view('owner_info', compact('units','user','id')); 

 }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

      if (isset($request->check) && $request->check === "owner") {

          $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'phone' => ['required', 'numeric'], // You might need to adjust the validation rule for phone number
        'hotel_name' => ['required', 'string', 'max:255'],
        'address' => ['required', 'string', 'max:255'],
        'city' => ['required', 'string', 'max:255'],
        'state' => ['required', 'string', 'max:255'],
        'zip' => ['required', 'string', 'max:255'],
        'username' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8'],
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }
    $user = new User();
    $user->role = $request->role;
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->hotel_name = $request->hotel_name;
    $user->address = $request->address;
    $user->city = $request->city;
    $user->state = $request->state;
    $user->zip = $request->zip;
    $user->username = $request->username;
    $user->password = Hash::make($request->password);
    $user->status = $request->status;
    $user->save();
    return redirect()->route('user.userowner')->with('status', 'Owner User Added');
}elseif(isset($request->check) && $request->check === "cleaner") {

  $rules = [
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'phone' => ['required', 'numeric'], // You might need to adjust the validation rule for phone number
        'address' => ['required', 'string', 'max:255'],
        'city' => ['required', 'string', 'max:255'],
        'state' => ['required', 'string', 'max:255'],
        'zip' => ['required', 'string', 'max:255'],
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }
    $user = new User();
    $user->role = $request->role;
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->address = $request->address;
    $user->city = $request->city;
    $user->state = $request->state;
    $user->zip = $request->zip;
    $user->status = $request->status;
    $user->password = Hash::make(uniqid());
    $user->save();
    return redirect()->route('user.usercleaner')->with('status', 'Cleaner Added');
}

$validator = Validator::make($request->all(), [
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    'phone' => ['required', 'numeric'],
    'password' => ['required', 'string', 'min:8', 'confirmed'],
]);

if ($validator->fails()) {
    return redirect('user/create')->withErrors($validator)->withInput();
}

$data = new User;        
$data->name = $request->name;
$data->email = $request->email;
$data->address = $request->address;
$data->phone = $request->phone;
$data->password = Hash::make($request->password);
$data->role = $request->role;
$data->save();
return redirect()->route('user.useradmin')->with('status', 'Admin User Added');

}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
     $user = User::find($id);
     $role_type=array('admin'=>'Admin','owner'=>'Owner','cleaner'=>'Cleaner');           
     return view('edit_user', compact('user','role_type','id'));  
 }

 public function editowneruser(string $id)
 {
     $user = User::find($id);
     return view('edit_owner_user', compact('user','id'));  
 }

 public function editcleaner(string $id)
 {
     $user = User::find($id);
     return view('edit_cleaner_user', compact('user','id'));  
 }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $userfields=$request->post();
        $user = User::find($id);
        
        unset($userfields['password']);
        unset($userfields['_method']);


        $validator = Validator::make($request->all(), [                       
            'email' =>  ['required', 'string', 'email', 'max:255',Rule::unique('users')->ignore($user->id)],
        ]);

        if ($validator->fails()) {
         return redirect('user/'.$id.'/edit/')->withErrors($validator)->withInput();
     }

     if ($request->filled('password')) {
         $validator = Validator::make($request->all(), [                       
            'password' => 'required|min:8',
        ]);

         if ($validator->fails()) {
            return redirect('user/'.$id.'/edit/')->withErrors($validator)->withInput();
        }
        $user->password = Hash::make($request->input('password'));
    }

    foreach ($userfields as $key => $userfield) {
        if ($key != '_token') {
            $user->$key=$userfield;               
        }            
    }        
    $user->update();        
    return redirect()->route('user.useradmin')->with('status', 'User Updated Successfully');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
     $user = User::find($id);
     $user->delete();
     Unit::where('owner_id', $id)->delete();
     Service::where('owner_id', $id)->delete();
       //return redirect()->route('user.index')->with('status','User has been deleted successfully');
     return redirect()->back()->with('status', 'User has been deleted successfully');
 }
    /**
     * Display Admin users.
     */
    public function useradmin()
    {
     $users=DB::table('users')->where('role', 'admin')->orderBy('id','desc')->paginate(20);  
     return view('users_admin', compact('users')); 
 }
    /**
     * Display Owners.
     */
    public function userowner()
    {
     $users=DB::table('users')->where('role', 'owner')->orderBy('hotel_name','asc')->paginate(20);  
     return view('users_owner', compact('users')); 
 }
    /**
     * Display Cleaner.
     */
    public function usercleaner()
    {
     $users=DB::table('users')->where('role', 'cleaner')->orderBy('id','desc')->paginate(20);  
     return view('users_cleaner', compact('users')); 
 }

  /*  public function owner_user_edit(string $id)
    {
       $currentUser = auth()->user();
       $user = User::find($id);

       if (!$currentUser || !$user || $currentUser->id != $user->id) {
        return redirect()->back()->with('error', 'You are not authorized to edit this user.');
    }        
       $user = User::find($id);
       return view('owner/edit_user', compact('user','id'));  
   }*/

   public function user_update(Request $request, string $id)
   {
    $userfields=$request->post();
    unset($userfields['_token']);
    unset($userfields['_method']);
    $user = User::find($id);
    if (isset($userfields['email'])) {
        $validator = Validator::make($request->all(), [                       
            'email' =>  ['required', 'string', 'email', 'max:255',Rule::unique('users')->ignore($user->id)],
        ]);
    }else{
       if ($request->filled('password')) {
         $validator = Validator::make($request->all(), [                       
            'password' => 'required|min:8',
        ]);
     }  

 }               

 if ($validator->fails()) {
    return redirect('home/accountinfo')->withErrors($validator)->withInput();
}

if ($request->filled('password')) { 
    $user->password = Hash::make($request->input('password'));
}

foreach ($userfields as $key => $userfield) {
    if ($key != '_token') {
        $user->$key=$userfield;               
    }            
} 

$user->update();        
return redirect()->back()->with('status', 'User Updated Successfully');

}



public function admin_user_update(Request $request, string $id)
{
    $userfields=$request->post();
    unset($userfields['_token']);
    unset($userfields['_method']);
    $user = User::find($id);
    if (isset($userfields['email'])) {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' =>  ['required', 'string', 'email', 'max:255',Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'numeric'], 
            'hotel_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'zip' => ['required', 'string', 'max:255'],


        ]);
        if ($validator->fails()) {
           return response()->json($validator->errors(), 422);
       }

   }else{
     if ($request->filled('password')) {
       $validator = Validator::make($request->all(), [                       
        'password' => 'required|min:8',
    ]);
   } 
   if ($validator->fails()) {
       return redirect()->back()->withErrors($validator)->withInput();
   } 

}               



if ($request->filled('password')) { 
    $user->password = Hash::make($request->input('password'));
}

foreach ($userfields as $key => $userfield) {
    if ($key != '_token') {
        $user->$key=$userfield;               
    }            
} 

$user->update();        
return redirect()->back()->with('status', 'User Updated Successfully');

}


public function cleaner_user_update(Request $request, string $id)
{
    $userfields=$request->post();
    unset($userfields['_token']);
    unset($userfields['_method']);
    $user = User::find($id);    
    $validator = Validator::make($request->all(), [
        'name' => ['required', 'string', 'max:255'],
        'email' =>  ['required', 'string', 'email', 'max:255',Rule::unique('users')->ignore($user->id)],
        'phone' => ['required', 'numeric'], 
        'address' => ['required', 'string', 'max:255'],
        'city' => ['required', 'string', 'max:255'],
        'state' => ['required', 'string', 'max:255'],
        'zip' => ['required', 'string', 'max:255'],
    ]);
    if ($validator->fails()) {
       return response()->json($validator->errors(), 422);
   }
   foreach ($userfields as $key => $userfield) {
    if ($key != '_token') {
        $user->$key=$userfield;               
    }            
} 
$user->update();        
return redirect()->back()->with('status', 'User Updated Successfully');

}


public function owner_account_info()
{
    $services_array=array();
    $unit_type=unit_type_owner_array(Auth::id());
    foreach ($unit_type as $key => $unit) {
     $services_array[$unit->id]=DB::table('services')->where('unit', $unit->id)->where('user_id',Auth::id())->count();
 }
 $id = auth()->user()->id;            
 $user = User::find($id);
 return view('owner/account_info', compact('services_array','user','id'));  
}

}
