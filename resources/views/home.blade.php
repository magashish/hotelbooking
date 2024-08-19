@extends('layouts.app')
@section('content')
@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif
<div class="container-fluid nss_style dashboard">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800"><span class="rental">Dashboard </span></h1>
  </div>
  
  @php
  $user = auth()->user();
  @endphp

  @if ($user && $user->role === 'admin') 

  <div class="row">
    <div class="dashboard_main admin_dashboard">
        <div class="icon_box">
            <a href="{{route('services.services_calendar')}}">
                <div class="icon_box"></div>
                <h3>Rental Calendar</h3>
            </a>
        </div>
        <div class="icon_box">
           <a href="{{route('home.manage')}}">
            <div class="icon_box"></div>
            <h3>Manage</h3>
        </a>
    </div>
    <div class="icon_box">
       <a href="{{ route('assigncleaner.index') }}">
        <div class="icon_box"></div>
        <h3>Assign Cleaners</h3>
    </a>
</div>
<div class="icon_box">
    <a href="{{ route('contactowner.create') }}">
        <div class="icon_box"></div>
        <h3>Contact Owners</h3>
    </a>
</div>
</div>
</div>

@elseif ($user && $user->role === 'owner')

<div class="row">
    <div class="dashboard_main owner_dashboard">
        <h2>Request Rental Cleaning Service</h2> 
        <div class="icon_box">
            <a href="{{route('owner-services.create')}}">
                <div class="icon_box"><img class="logo" src="{{ asset('images/plus.png') }}" /></div>
                <h3>Insert Dates</h3>
            </a>
        </div>

        <div class="icon_box">
           <a href="{{route('owner.owner_get_date')}}">
            <div class="icon_box"><img class="logo" src="{{ asset('images/calender.png') }}" /></div>
            <h3>View Dates</h3>
        </a>
    </div>

    <div class="icon_box">
       <a href="{{route('owner.owner_edit_date')}}">
        <div class="icon_box"><img class="logo" src="{{ asset('images/edit.png') }}" /></div>
        <h3>Edit Dates</h3>
    </a>
</div>
<div class="icon_box">
    <a href="{{ route('owner.owner_contact_bclean') }}">
        <div class="icon_box"><img class="logo" src="{{ asset('images/mail.png') }}" /></div>
        <h3>Contact BClean</h3>
    </a>
</div>
</div>
</div>


<div class="row">    
 <div class="box_section">   
    <h2>Other Service Provided</h2> 
    <div class="box_one_item">
        <a href="https://bcleanhi.com/request-form/">
            <span><img class="logo" src="{{ asset('images/1.png') }}" /></span>
            <h3>Request for Room Supplies</h3>
            <p>Our efficient team has the supplies and the knowledge for a quick turnaround.</p>
        </a>
    </div>
    <div class="box_one_item">
        <a href="https://bcleanhi.com/request-form/">
            <span><img class="logo" src="{{ asset('images/2.png') }}" /></span>
            <h3>Request for Maintenance</h3>
            <p>From minor repairs to large overhaul projects, we assess, consult, and restore everything that needs attention.</p>
        </a>
    </div>
    <div class="box_one_item">
        <a href="https://bcleanhi.com/request-form/">
            <span><img class="logo" src="{{ asset('images/3.png') }}" /></span>
            <h3>Request for Repair</h3>
            <p>Leaky faucets or a loose doorknob, our experienced, high-quality handymen services will fix your unit from everyday wear and tear.</p>
        </a>
    </div>
</div>
</div>


@endif
</div>
@endsection