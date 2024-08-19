<?php
namespace App\Http\Controllers;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $units=DB::table('units')->orderBy('id','desc')->paginate(20);  
       return view('unit', compact('units')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('add_unit'); 
    }

    // public function create_unit($ownerid, $unitid=null)
    // {    

    //     $unit = Unit::find($unitid);
    //      return view('add_unit', compact('ownerid','unit')); 
    // }

    public function create_unit($ownerid, $unitid = null)
    {    
        $unit = Unit::find($unitid);
        if ($unitid !== null) {
            $bed_size_data=unserialize($unit->bed_size);          
            return view('edit_unit', compact('ownerid', 'unit','bed_size_data'));
        } else {
            return view('add_unit', compact('ownerid'));
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $rules = [
            'name' => ['required', 'unique:units'],
            'master_code' => ['required', 'unique:units'],
        ];
        $validator = Validator::make($request->all(), $rules);

         if ($validator->fails()) {
           return response()->json($validator->errors(), 422);
        }
        $unitfields=$request->post();
        unset($unitfields['_token']);
        $data = new Unit;        
        $data->user_id = auth()->user()->id;
        $data->room_code = isset($_POST['room_code']) ? 1 : 0; 
        foreach ($unitfields as $key => $unitfield) {
                if(is_array($unitfield)) {
                    $data->$key=serialize($unitfield);
                } else {                   
                $data->$key=$unitfield;
                }        
             
        }        
        $data->save();
        return redirect()->back()->with('status', 'Unit Added Successfully');
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
        $unit = Unit::find($id);
        return view('edit_unit', compact('unit')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {



        $data = Unit::find($id);    
        $rules = [
            'name' => ['required', Rule::unique('units')->ignore($data->name, 'name')->ignore($data->id)],
            'master_code' => ['required', Rule::unique('units')->ignore($data->master_code, 'master_code')->ignore($data->id)],
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $unitfields=$request->post();
        unset($unitfields['_token']);
        unset($unitfields['_method']);
        $data = Unit::find($id);  
        $data->room_code = isset($_POST['room_code']) ? 1 : 0;    
        foreach ($unitfields as $key => $unitfield) {
                if(is_array($unitfield)) {
                    $data->$key=serialize($unitfield);
                } else {                   
                $data->$key=$unitfield;
                } 
         }        
        $data->update();
        return redirect()->back()->with('status', 'Service Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $data = Unit::find($id);
       $data->delete();  
       return redirect()->back()->with('status', 'Unit has been deleted successfully'); 
    }

    public function owner_unit(string $id)
    {
        $user=get_userdata($id);
        if ($user->role != 'owner') {
            return redirect()->back()->with('status', 'This user is not allowed to add units please check this user role.');
        } 
        $units=DB::table('units')->where('owner_id', $id)->orderBy('id','desc')->paginate(20);  
        return view('unit', compact('units')); 
    }

}


