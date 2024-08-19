<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Service;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services=DB::table('services')->orderBy('id','desc')->paginate(10);  
        return view('services', compact('services')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('add_service'); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $servicesfields=$request->post();
        unset($servicesfields['_token']);
        foreach ($servicesfields['service'] as $key => $services) {
         $data = new Service;
         $data->user_id = Auth::id(); 
         foreach ($services as $key => $service) {
            $data->$key=$service;         
        }        
        $data->save(); 
    }
    
    return redirect('services')->with('status', 'Service Added Sucessfully');        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $service = Service::find($id);
       return view('view_service', compact('service','id')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       $service = Service::find($id);
        $query =User::query();
		$user_data=$query->where('role', '=','cleaner')->get();
       return view('edit_service', compact('service','user_data','id')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'unit' => 'required|string',
            'bed_type' => 'required|string',
            'guest_name' => 'required|string',
            'arrival_date' => 'required|date',
            'arrival_time' => 'required',
            'departure_date' => 'required|date',
            'departure_time' => 'required',
            'room_code' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect('services/'.$id.'/edit/')->withErrors($validator)->withInput();
        }
        $servicesfields=$request->post();
        unset($servicesfields['_token']);
        unset($servicesfields['_method']);
        $data = Service::find($id);
        foreach ($servicesfields as $key => $service) {
                $data->$key=$service;         
        }        
        $data->update();        
        return redirect('services')->with('status', 'Service Updated Sucessfully'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $data = Service::find($id);
       $data->delete();   
       return redirect()->route('services.index')->with('status','Service has been deleted successfully');
    }
    public function services_calendar()
    {
        $services=DB::table('services')->orderBy('id','desc')->paginate(10);  
        return view('services', compact('services')); 
    }
}
