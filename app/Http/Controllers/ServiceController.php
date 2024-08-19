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

use Illuminate\Support\Carbon;


class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {  
        $id=0;
        $currentDate = Carbon::now()->toDateString();

        //$services=DB::table('services')->orderBy('arrival_date','desc')->paginate(20); 
        $services = Service::whereDate('arrival_date', '>=', $currentDate)
        ->orderBy('arrival_date', 'asc')
        ->paginate(20); 
        return view('services', compact('services','id')); 
    }

    public function get_old_services(){  
        $id=0;
        $currentDate = Carbon::now()->toDateString();
        $services = Service::whereDate('departure_date', '<', $currentDate)
        ->orderBy('departure_date', 'desc')
        ->paginate(20); 
        return view('old_services', compact('services','id')); 
    }

    public function get_old_services_by_unit($id){

        $currentDate = Carbon::now()->toDateString();
        $services = Service::where('unit',$id)
        ->whereDate('departure_date', '<', $currentDate)
        ->orderBy('departure_date', 'desc')
        ->paginate(20);
        return view('old_services', compact('services','id')); 
    }


    public function services_assigncleaners($id = null)
    {
        $startDate_data = request()->query('start_date');
        $endDate_data = request()->query('end_date');        
        $currentDate = Carbon::now()->toDateString();
        $query = DB::table('services');
        $checkin_count = DB::table('services');
        $checkout_count = DB::table('services');
        $bb_count = DB::table('services');

        $checkin_data=null;
        $checkout_data=null;
        $bb_data=null;


        if ($id !== null) {
            $query->where('unit', $id);
            $checkin_count->where('unit', $id);
            $checkout_count->where('unit', $id);
            $bb_count->where('unit', $id);
        }

        $print_search=false;
        if ($startDate_data && $endDate_data ) {           
            $query->where(function ($query) use ($startDate_data, $endDate_data) {
                $query->where('arrival_date', 'LIKE', "%{$startDate_data}%")
                ->orWhere('departure_date', 'LIKE', "%{$endDate_data}%");
            });
            $checkin_count->where('arrival_date', 'LIKE', "%{$startDate_data}%");
            $checkout_count->where('departure_date', 'LIKE', "%{$endDate_data}%");

            $checkin_data=$checkin_count->count();
            $checkout_data=$checkout_count->count();


            $bb_data=$bb_count->where(function ($bb_count) use ($startDate_data, $endDate_data) {
                $bb_count->where('departure_date', 'LIKE', "%{$endDate_data}%")
                ->where('b2b', 1)
                ->orWhere(function ($bb_count) use ($startDate_data) {
                  $bb_count->where('arrival_date', 'LIKE', "%{$startDate_data}%")
                  ->where('b2b', 1);
              });
            })
            ->count();  
            $print_search=true;        

        }else{
         $query->whereDate('arrival_date', '>=', $currentDate);
     } 

      $services = $query->orderBy('arrival_date', 'desc')->get();

      
      


     return view('services_assign_cleaners', compact('services','id','startDate_data','endDate_data','checkin_data','checkout_data','bb_data','print_search')); 
 }



 public function assigncleaner(string $id)
 {
     $service = Service::find($id);
     $query =User::query();
     $user_data=$query->where('role', '=','cleaner')->get();
     return view('unit_assigncleaner', compact('service','user_data','id')); 
 }


 public function get_date($id)
 {
    $currentDate = Carbon::now()->toDateString();
        //$services=DB::table('services')->where('unit',$id)->orderBy('arrival_date','desc')->paginate(20);  
    $services = Service::where('unit',$id)
    ->whereDate('arrival_date', '>=', $currentDate)
    ->orderBy('arrival_date', 'asc')
    ->paginate(20);
    return view('services', compact('services','id')); 
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('add_service'); 
    }

    

    public function admin_create_date($id)
    {
       if ($unit = Unit::find($id)) {
         $owner_id=$unit->owner_id;
         return view('add_service', compact('id','owner_id')); 
     }

     return redirect()->back()->with('status', 'This unit not find in your server');
 }

    /**
     * Store a newly created resource in storage.
     */
    /*public function store(Request $request)
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
}*/

public function store(Request $request)
{

    $servicsfields = $request->post();
    $errors = [];    

    foreach ($servicsfields['service'] as $key => $service) {
        $unit_id = $service['unit'];
        $Unitdata = Unit::find($unit_id);
        $arrivalDateTime = '';
        $departureDateTime = '';

        if (!isset($service['checkin'])) {
            $arrivalDateTime = date('Y-m-d H:i:s', strtotime($service['arrival_date'] . ' ' . $Unitdata->checkin));
        } else {
            $arrivalDateTime = date('Y-m-d H:i:s', strtotime($service['arrival_date'] . ' ' . $service['arrival_time']));
        }

        if (!isset($service['checkout'])) {
            $departureDateTime = date('Y-m-d H:i:s', strtotime($service['departure_date'] . ' ' . $Unitdata->checkout));
        } else {
            $departureDateTime = date('Y-m-d H:i:s', strtotime($service['departure_date'] . ' ' . $service['departure_time']));
        }

        if ($departureDateTime < $arrivalDateTime) {
            $errors[$key] = "Departure Date ". $departureDateTime." must be greater than Arrival Date ".$arrivalDateTime." for " . $service['guest_name'];
        }
    }
    if (!empty($errors)) {
        echo json_encode(['status' => 'unsuccess','errors' => $errors]);
        exit();
    } 
    /***************************************** Check here Departure Date & Arrival Date will be unique in Array*****************************************************/
    $servicedata=array();
    foreach ($servicsfields['service'] as $key => $service) {
        $unit_id=$service['unit'];
        $Unitdata = Unit::find($unit_id);

        $arrival_time=$service['arrival_time'];
        $departure_time=$service['departure_time'];
        if (!isset($service['checkin'])) {
            $arrival_time=$Unitdata->checkin;
        }
        if (!isset($service['checkout'])) {
            $departure_time=$Unitdata->checkout;
        }

        $servicsfields['service'][$key]['unit_arrival_time']=$Unitdata->checkin;
        $servicsfields['service'][$key]['unit_departure_time']=$Unitdata->checkout;


        $servicsfields['service'][$key]['arrival_date']= date('Y-m-d H:i:s', strtotime($service['arrival_date'] . ' ' . $arrival_time));
        $servicsfields['service'][$key]['departure_date']=date('Y-m-d H:i:s', strtotime($service['departure_date'] . ' ' . $departure_time));
        $servicsfields['service'][$key]['arrival_time']= date('H:i:s', strtotime($arrival_time));
        $servicsfields['service'][$key]['departure_time']=date('H:i:s', strtotime($departure_time));

        $servicedata[$key]['arrival_date']= date('Y-m-d H:i:s', strtotime($service['arrival_date'] . ' ' . $arrival_time));
        $servicedata[$key]['departure_date']= date('Y-m-d H:i:s', strtotime($service['departure_date'] . ' ' . $departure_time));
    }


    /*foreach ($servicedata as $key => $entry) {
        $arrivalDate = $entry['arrival_date'];
        $departureDate = $entry['departure_date'];
        foreach ($servicedata as $otherKey => $otherEntry) {
            if ($otherKey !== $key) {
                $otherArrival = $otherEntry['arrival_date'];
                $otherDeparture = $otherEntry['departure_date'];
                if (($otherArrival >= $arrivalDate && $otherArrival <= $departureDate) ||
                    ($otherDeparture >= $arrivalDate && $otherDeparture <= $departureDate)
                ) {
                    $errors[$key] = "Duplicate Entries found between the specified Arrival Date ($arrivalDate) and Departure Date ($departureDate)";
                break;
            }
        }
    }
}*/





// Convert dates to \DateTime objects and store them with their original keys
$entries = array();
foreach ($servicedata as $key => $entry) {
    $entries[$key] = array(
        'arrival_date' => new \DateTime($entry['arrival_date']),
        'departure_date' => new \DateTime($entry['departure_date'])
    );
}
// Check if each arrival_date is greater than the previous departure_date
$previousDeparture = null;
foreach ($entries as $key => $entry) {
    $currentArrival = $entry['arrival_date'];
    if ($previousDeparture !== null) {
        // Check if the current arrival_date is not greater than the previous departure_date
        if ($currentArrival < $previousDeparture) {
            $errors[$key] = "Error: Arrival Date ({$currentArrival->format('Y-m-d H:i:s')}) must be greater than the previous Departure Date ({$previousDeparture->format('Y-m-d H:i:s')})";
        }
    }
    // Update the previous departure date to the current entry's departure date
    $previousDeparture = $entry['departure_date'];
}



if (!empty($errors)) {
    echo json_encode(['status' => 'unsuccess', 'errors' => $errors]);
    exit();
}


/***************************************** Check here Departure Date & Arrival Date will be unique in Databse*****************************************************/
foreach ($servicsfields['service'] as $key => $entry) { 
    $unit_id=$service['unit'];
    $Unitdata = Unit::find($unit_id); 
    $checkinTime=$Unitdata->checkin; 
    $checkoutTime=$Unitdata->checkout;    
    $arrivalDate = $entry['arrival_date'];
    $departureDate = $entry['departure_date'];
        // $conflicts =Service::where('unit', $entry['unit'])
        // ->where('arrival_date', '>=', $entry['arrival_date'])
        // ->where('departure_date', '<=', $entry['departure_date'])
        // ->exists();

    $conflicts = Service::where('unit', $entry['unit'])->where(function ($query) use ($arrivalDate, $departureDate) {
        $query->where('arrival_date', '<=', $arrivalDate)
        ->where('departure_date', '>=', $arrivalDate)
        ->orWhere(function ($query) use ($arrivalDate, $departureDate) {
          $query->where('arrival_date', '<=', $departureDate)
          ->where('departure_date', '>=', $departureDate);
      });
    })->exists();

     // $arrivalDate=date('Y-m-d H:i:s A', strtotime($arrivalDate));
     // $arrivalDate=date('Y-m-d H:i:s A', strtotime($arrivalDate));
    if ($conflicts) {
        $errors[$key] = "Entries found between the specified Arrival Date ".$arrivalDate." and Departure Date ".$departureDate." in the database.";
    }

}
if (!empty($errors)) {
    echo json_encode(['status' => 'unsuccess', 'errors' => $errors]);
    exit();
}   
/***************************************** Save Data *****************************************************/

unset($servicsfields['_token']);
foreach ($servicsfields['service'] as $key => $services) {
 $data = new Service;
 $lastRecord = Service::where('unit', $unit_id)->orderBy('id', 'desc')->first();
 if ($lastRecord) {
    $data->old_room_code=$lastRecord->room_code; 
}
$data->user_id = Auth::id(); 
foreach ($services as $key => $service) {
    $data->$key=$service;         
}        
$data->save(); 
}    

$response = [
    'status' => 'success',
    'message' => 'Services added successfully.',
    'redirect' => route('services.create') 
];
return response()->json($response);

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
        $units = Unit::where('owner_id',$service->owner_id)->get();
        $query =User::query();
        $user_data=$query->where('role', '=','cleaner')->get();
        return view('edit_service', compact('service','user_data','units','id')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       $servicsfields=$request->post();
       $data = Service::find($id);
       if (isset($servicsfields['check'])) {
        unset($servicsfields['check']);
        unset($servicsfields['_token']);
        unset($servicsfields['_method']);        
        foreach ($servicsfields as $key => $service) {
            $data->$key=$service;         
        }        
        $data->update();        
        return redirect()->back()->with('status', 'Servics Updated Sucessfully');
    }else{
        $unit_id=$data->unit;   

        $arrivalDateTime = '';
        $departureDateTime = '';

        $Unitdata = Unit::find($unit_id);
        $arrivalDateTime = '';
        $departureDateTime = '';

        // if (!isset($servicsfields['checkin'])) {
        //     $arrivalDateTime = date('Y-m-d H:i:s', strtotime($servicsfields['arrival_date'] . ' ' . $Unitdata->checkin));
        // } else {
        //     $arrivalDateTime = date('Y-m-d H:i:s', strtotime($servicsfields['arrival_date'] . ' ' . $servicsfields['arrival_time']));
        // }

        // if (!isset($servicsfields['checkout'])) {
        //     $departureDateTime = date('Y-m-d H:i:s', strtotime($servicsfields['departure_date'] . ' ' . $Unitdata->checkout));
        // } else {
        //     $departureDateTime = date('Y-m-d H:i:s', strtotime($servicsfields['departure_date'] . ' ' . $servicsfields['departure_time']));
        // }
        
        $arrivalDateTime = date('Y-m-d H:i:s', strtotime($servicsfields['arrival_date'] . ' ' . $servicsfields['arrival_time']));
        $departureDateTime = date('Y-m-d H:i:s', strtotime($servicsfields['departure_date'] . ' ' . $servicsfields['departure_time']));

        if ($departureDateTime < $arrivalDateTime) {
            $errorsmsg= "Departure Date ". $departureDateTime." must be greater than Arrival Date ".$arrivalDateTime." for " . $servicsfields['guest_name'];
            $errors = new \Illuminate\Support\MessageBag(['custom_error' => $errorsmsg]);
            return redirect()->back()->withErrors($errors)->withInput();
        }

        $servicsfields['arrival_date']= $arrivalDateTime;
        $servicsfields['departure_date']=$departureDateTime;  

        $arrivalDate=$arrivalDateTime;
        $departureDate= $departureDateTime;  

        $conflictingEntry = Service::where('unit', $data->unit)
        ->where('id', '!=', $id)
        ->where(function ($query) use ($arrivalDate,$departureDate) {
            $query->where('arrival_date', '<=', $arrivalDate)
            ->where('departure_date', '>=', $departureDate);
        })->exists();

        if ($conflictingEntry) {
           $errors = new \Illuminate\Support\MessageBag(['custom_error' => "Entries found between the specified Arrival Date ($arrivalDate) and Departure Date ($departureDate) in the database."]);        
           return redirect()->back()->withErrors($errors)->withInput();

       }

       unset($servicsfields['_token']);
       unset($servicsfields['_method']);
       $data->b2b = isset($_POST['b2b']) ? 1 : 0; 
       $data->checkin = isset($_POST['checkin']) ? 1 : 0;  
       $data->checkout = isset($_POST['checkout']) ? 1 : 0; 
       foreach ($servicsfields as $key => $servicsfield) {
        $data->$key=$servicsfield;         
    }        
    $data->update(); 
    
    // $mail_data = [
    //     'arrival_date' => $servicsfields['arrival_date'],
    //     'arrival_time' => $servicsfields['arrival_time'],
    //     'departure_date' => $servicsfields['departure_date'],
    //     'departure_time' => $servicsfields['departure_time'],
    //     'room_code' => $servicsfields['room_code'],
    //     'notes' => $servicsfields['notes'],
    //     'url' => route('services.edit', $id),
    //     'user' => Auth::user()->name,
    // ];
    // $userEmail= 'datatest@bcleanhi.com';
    // Mail::send('emails.edit_service_date', $mail_data, function($message) use ($userEmail) {
    //     $message->to($userEmail, 'Rental Project Database')
    //     ->subject('Rental Project Database - Edit Date');
    //     $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')); 
    // });

    
    return redirect()->route('services.index')->with('status','Servics Updated successfully');
    //return redirect()->back()->with('status', 'Servics Updated Sucessfully'); 

}



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

    $data = Service::all(); 
    $resources_array=array(); 
    $events_array=array();            
    $services=Service::all(); 
    $loop=1;
    foreach ($services as $key => $service) {

        if ($service->cleaner) {
            $cleaner='Assigned';
        }else{
            $cleaner='Not Assigned';
        }

        if ($service->b2b) {
            $b2b='Yes';
        }else{
            $b2b='No';
        }

        $backgroundColor = ($loop % 2 == 0) ? '#00a5b8' : '#028695';
        $borderColor = ($loop % 2 == 0) ? '#028695' : '#00a5b8';

        $unit_id=get_unit_detail($service->unit)->name;

        $resources_array[$service->unit]['id']=$unit_id;
        $resources_array[$service->unit]['title']='Unit #'.$unit_id;

        $events_array[$key]['id']=$service->id;
        $events_array[$key]['resourceId']=$unit_id;
        $events_array[$key]['unitid']=$unit_id;
        $events_array[$key]['arrival_date']=date('g A - j M', strtotime($service->arrival_date));
        $events_array[$key]['departure_date']=date('g A - j M', strtotime($service->departure_date));
        $events_array[$key]['room_code']=$service->room_code;
        $events_array[$key]['b2b']=$b2b;

            // $start_date_title = date('g A - j M', strtotime($service->arrival_date));
            // $end_date_title = date('g A - j M', strtotime($service->departure_date)); 

        $start_date_title = date('g A', strtotime($service->arrival_date));
        $end_date_title = date('g A', strtotime($service->departure_date)); 

        $events_array[$key]['title']=$start_date_title.' / '.$end_date_title;  

        $start_date = date('Y-m-d H:i:s', strtotime($service->arrival_date));
        $end_date = date('Y-m-d H:i:s', strtotime($service->departure_date));       
        $events_array[$key]['start']=$start_date;
        $events_array[$key]['end'] = $end_date;
        $events_array[$key]['notes']=$service->notes;
        $events_array[$key]['cleaner']=$cleaner;
        if (strtotime($end_date) < time()) {
            $backgroundColor = '#E0E0E0'; 
            $borderColor = '#028695'; 
        }else{
            if ($service->b2b) {
                $backgroundColor = '#F2C64D';
                $borderColor = '#F2C64D';
            }
        }

        $events_array[$key]['backgroundColor']=$backgroundColor;
        $events_array[$key]['borderColor'] = $borderColor;

        $loop++;
    }

    $resources_json = json_encode(array_values($resources_array), JSON_PRETTY_PRINT);
    $events_json = json_encode($events_array, JSON_PRETTY_PRINT);

       // echo "<pre>";
       // print_r($resources_json);
       // print_r($events_json);


    return view('services_calendar', compact('resources_json','events_json'));
}

public function services_calendar_edit(string $id)
{
 $service = Service::find($id);
 $query =User::query();
 $user_data=$query->where('role', '=','cleaner')->get();
 return view('edit_calendar_service', compact('service','user_data','id')); 
}

public function calendarAjaxData(Request $request)
{
    $start = $request->input('start');
    $end = $request->input('end');
    $resources = Service::where(function ($query) use ($start, $end) {
        $query->whereBetween('arrival_date', [$start, $end])
        ->orWhereBetween('departure_date', [$start, $end]);
    })
    ->get()
    ->map(function ($service) {
        return [
            'id' => $service->unit,
            'title' => $service->unit,
        ];
    })
    ->unique('id');

    $events = Service::where(function ($query) use ($start, $end) {
        $query->whereBetween('arrival_date', [$start, $end])
        ->orWhereBetween('departure_date', [$start, $end]);
    })
    ->get()
    ->map(function ($service) {
        $cleaner = $service->cleaner ? 'Assigned' : 'Not Assigned';
        return [
            'id' => $service->id,
            'resourceId' => $service->unit,
            'title' => $service->unit . ' ' . $service->arrival_date . ' / ' . $service->departure_date,
            'start' => $service->arrival_date,
            'end' => $service->departure_date != $service->arrival_date ? date('Y-m-d', strtotime($service->departure_date . ' +1 day')) : $service->departure_date,
            'notes' => $service->notes,
            'cleaner' => $cleaner,
        ];
    });
    return response()->json([
        'resources' => $resources,
        'events' => $events,
    ]);

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
