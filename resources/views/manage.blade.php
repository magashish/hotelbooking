@extends('layouts.app')
@section('content')
@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif
<div class="container-fluid nss_style dashboard">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800"><span class="rental">Manage </span></h1>
  </div>


  <div class="row">
    <div class="col-xl-4 col-md-6 mb-4 manage_box">
        <div class="card py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <h2 class="text-xs font-weight-bold">Rental Dates</h2>
                        <ul class="manage_ul">
                            <li><a href="{{ route('services.index') }}">View Dates</a></li>
                            <li><a href="{{ route('services.create') }}">Insert Dates</a></li>
                            <li><a href="{{route('services.services_calendar')}}">Calendar</a></li>
                        </ul>
                        <a href="{{ route('services.index') }}" class="btn btn-success btn-icon-split"> <span class="text">Manage</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4 manage_box">
        <div class="card py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <h2 class="text-xs font-weight-bold">Owners</h2>
                        <ul class="manage_ul">
                           <li><a href="{{ route('user.userowner') }}">View Owners</a></li>
                           <li><a href="{{ route('user.ownercreate') }}">Insert Owners</a></li>
                           <li><a href="{{ route('user.userowner') }}">Manage Units</a></li>
                       </ul>
                       <a href="{{ route('user.userowner') }}" class="btn btn-success btn-icon-split"> <span class="text">Manage</span></a>
                   </div>
               </div>
           </div>
       </div>
   </div>

   <div class="col-xl-4 col-md-6 mb-4 manage_box">
    <div class="card py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <h2 class="text-xs font-weight-bold">Cleaners</h2>
                    <ul class="manage_ul">
                       <li><a href="{{ route('user.usercleaner') }}">View Cleaners</a></li>
                       <li><a href="{{ route('user.cleanercreate') }}">Insert Cleaner</a></li>
                       <li><a href="{{ route('assigncleaner.index') }}">Assign Cleaner</a></li>
                   </ul>
                   <a href="{{ route('user.usercleaner') }}" class="btn btn-success btn-icon-split"> <span class="text">Manage</span></a>
               </div>
           </div>
       </div>
   </div>
</div>


</div>



{{-- <div class="row">
    <div class="dashboard_main">
        <div class="icon_box manage_box">
            <a href="{{route('services.services_calendar')}}">
                <div class="icon_box"></div>
                <h3>Rental Calendar</h3>
            </a>
        </div>
        <div class="icon_box manage_box">
           <a href="{{route('services.services_calendar')}}">
            <div class="icon_box"></div>
            <h3>Manage</h3>
        </a>
    </div>
    <div class="icon_box manage_box">
       <a href="{{route('services.index')}}">
        <div class="icon_box"></div>
        <h3>Assign Cleaners</h3>
    </a>
</div>

</div>
</div> --}}

</div>
@endsection