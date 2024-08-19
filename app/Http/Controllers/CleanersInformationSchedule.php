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

class CleanersInformationSchedule extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentDate = date('Y-m-d');
        if (isset($_GET['dateInput'])) {
           $currentDate=$_GET['dateInput'];
        }
        // $servicesin = Service::whereDate('arrival_date', $currentDate)->where('b2b', 0)->where('checkin', 1)->get();
        // $servicesout = Service::whereDate('departure_date', $currentDate)->where('checkout', 1)->get();

        $servicesin = Service::whereDate('arrival_date', $currentDate)->get();
        $servicesout = Service::whereDate('departure_date', $currentDate)->get();

        return view('services_assign_cleaners_table', compact('currentDate','servicesin','servicesout'));  
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
