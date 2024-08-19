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
        /*$validator = Validator::make($request->all(), [
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
        }*/

        $servicesfields=$request->post();
        unset($servicesfields['_token']);
        unset($servicesfields['_method']);
        $data = Service::find($id);
        foreach ($servicesfields as $key => $service) {
                $data->$key=$service;         
        }        
        $data->update();        
        //return redirect('services')->with('status', 'Service Updated Sucessfully'); 
        return redirect()->back()->with('status', 'Service Updated Successfully');

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

    public function services_calendar(Request $request)
    {
      if($request->ajax()) { 
            $data = Service::all(); 
             $services_array=array();             
             $services=Service::all(); 
             foreach ($services as $key => $service) {
                if ($service->cleaner) {
                    $cleaner='Assigned';
                }else{
                    $cleaner='Not Assigned';
                }
                 $services_array[$key]['id']=$service->id;
                 $services_array[$key]['unit']=$service->unit.' '.$service->arrival_date.' / '.$service->departure_date;
                 $services_array[$key]['arrival_date']=$service->arrival_date;
                 $services_array[$key]['departure_date']=$service->departure_date;
                 $services_array[$key]['notes']=$service->notes;
                 $services_array[$key]['cleaner']=$cleaner;
             }
             return response()->json($services_array);
        }  
        return view('services_calendar');
    }

     public function services_calendar_edit(string $id)
    {
       $service = Service::find($id);
       $query =User::query();
       $user_data=$query->where('role', '=','cleaner')->get();
       return view('edit_calendar_service', compact('service','user_data','id')); 
    }

     public function services_ajax(Request $request)
    {
 
        switch ($request->type) {
           case 'add':
              $event = Service::create([
                  'title' => $request->title,
                  'start' => $request->start,
                  'end' => $request->end,
              ]); 
              return response()->json($event);
             break;
  
           case 'update':
              $event = Service::find($request->id)->update([
                  'title' => $request->title,
                  'start' => $request->start,
                  'end' => $request->end,
              ]);
 
              return response()->json($event);
             break;
  
           case 'delete':
              $event = Service::find($request->id)->delete();
  
              return response()->json($event);
             break;
             
           default:
             break;
        }
    }



}
