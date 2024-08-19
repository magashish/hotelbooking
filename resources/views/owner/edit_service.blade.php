@extends('layouts.app')
@section('content')
@if (session('status'))
<div class="alert alert-success">
 {{ session('status') }}
</div>
@endif


@include('breadcrumb.owner_breadcrumb')

<div class="container-fluid nss_style unit-service-edit">
 <div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Edit Date</h1>
</div>

<div class="row">    
  <div class="col-xl-12 col-md-12 mb-4 unit_title">
    <div class="row mb-3">
        <div class="col-md-12 col-form-label text-md-end">
            <label for="unit_type" class="col-form-label text-md-end">{{ __('Unit #:')}}  <span class="unit_id">{{ get_unit_detail($service->unit)->name }}</span></label>           
        </div>       
    </div>
</div>
</div>


@php
 $room_code=get_unit_detail($service->unit)->room_code;
@endphp

<div class="row">
  <div class="col-xl-12 col-md-12 mb-4 service-edit">
    @if($errors->has('custom_error'))
    <div class="alert alert-danger">
        {{ $errors->first('custom_error') }}
    </div>
    @endif

    <form class="input-form"  method="POST" action="{{ route('owner-services.update', $service->id) }}" enctype="multipart/form-data">
       @csrf
       @method('PUT')


    <!-- <div class="row mb-3">
        <label for="unit" class="col-md-4 col-form-label text-md-end">{{ __('Unit') }}</label>

        <div class="col-md-6">
         <select id="unit" class="form-control @error('unit') is-invalid @enderror" name="unit" required>
           @foreach(unit_type_owner_array(auth()->user()->id) as $key => $value)
            <option value="{{ $value->id }}" @if( $service->unit == $value->id) selected @endif>{{ $value->name }}</option>
            @endforeach
        </select>
        @error('unit')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div> -->

   {{--  <div class="row mb-3">
        <label for="bed_type" class="col-md-4 col-form-label text-md-end">{{ __('Bed Type') }}</label>

        <div class="col-md-6">
            <!-- <input id="bed_type" type="text" class="form-control @error('bed_type') is-invalid @enderror" name="bed_type" value="{{ $service->bed_type }}" required> -->

            <select id="bed_type" class="form-control @error('bed_type') is-invalid @enderror" name="bed_type" required>
                @foreach(bed_type_array() as $key => $value)
                <option value="{{ $key }}" @if($service->bed_type == $key) selected @endif>{{ $value }}</option>
                @endforeach
            </select>

            @error('bed_type')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div> --}}

    <div class="row mb-3">
        <label for="guest_name" class="col-md-4 col-form-label text-md-end">{{ __('Guest Name') }}</label>

        <div class="col-md-6">
            <input id="guest_name" type="text" class="form-control @error('guest_name') is-invalid @enderror" name="guest_name" value="{{ $service->guest_name }}" required>

            @error('guest_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label for="arrival_date" class="col-md-4 col-form-label text-md-end">{{ __('Arrival Date') }}</label>

        <div class="col-md-6">
           <input id="arrival_date" type="date" class="form-control @error('arrival_date') is-invalid @enderror" name="arrival_date" value="{{ \Carbon\Carbon::parse($service->arrival_date)->format('Y-m-d') }}" required>

           @error('arrival_date')
           <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <label for="arrival_date" class="col-6 col-md-4 col-form-label text-md-end">{{ __('Arrival Time') }}</label>
    <div class="col-6">
        <!-- <span class="form-control">{{ date('h:i A', strtotime(get_unit_detail($service->unit)->checkin)) }}</span>                          -->
        <span class="form-control">{{ \Carbon\Carbon::parse($service->arrival_date)->format('H:i:s') !== '00:00:00' ? \Carbon\Carbon::parse($service->arrival_date)->format('h:i A') : '' }}</span>
 </div>
</div>

<div class="row mb-3">
    <label for="checkin" class="col-6 col-md-4 col-form-label text-md-end">{{ __('Early Check In') }}</label>
    <div class="col-6">
        <input type="checkbox" class="form-control checkin @error('checkin') is-invalid @enderror" name="checkin" value="1" {{ $service->checkin == 1 ? 'checked' : '' }}>         

    </div>
</div>

<div class="arrival_time_div" style="display:{{ $service->checkin == 1 ? 'block;' : 'none;' }}">
<div class="row mb-3">
    <label for="arrival_time" class="col-md-4 col-form-label text-md-end">{{ __('Time') }}</label>
    <div class="col-md-6">
        <!-- <input id="arrival_time" type="time" class="form-control @error('arrival_time') is-invalid @enderror" name="arrival_time" value="{{ \Carbon\Carbon::parse($service->arrival_date)->format('H:i:s') !== '00:00:00' ? \Carbon\Carbon::parse($service->arrival_date)->format('H:i:s') : '' }}"> -->

        <select id="arrival_time" name="arrival_time" class="form-control " tabindex="-1" aria-hidden="true" required> 
            @foreach (timeEntries_array() as $key=> $arrival_time) 
            <option value="{{ $key }}" {{ $service->arrival_time == $key ? 'selected' : '' }}>{{ $arrival_time }}</option> 
            @endforeach
        </select>

        @error('arrival_time')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
</div>

<div class="row mb-3">
    <label for="departure_date" class="col-md-4 col-form-label text-md-end">{{ __('Departure Date') }}</label>

    <div class="col-md-6">
        <input id="departure_date" type="date" class="form-control @error('departure_date') is-invalid @enderror" name="departure_date" value="{{ \Carbon\Carbon::parse($service->departure_date)->format('Y-m-d') }}" required>


        @error('departure_date')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <label for="arrival_date" class="col-6 col-md-4 col-form-label text-md-end">{{ __('Departure Time') }}</label>
    <div class="col-6">
     <!-- <span class="form-control">{{ date('h:i A', strtotime(get_unit_detail($service->unit)->checkout)) }}</span>                          -->
     <span class="form-control">{{ \Carbon\Carbon::parse($service->departure_date)->format('H:i:s') !== '00:00:00' ? \Carbon\Carbon::parse($service->departure_date)->format('h:i A') : '' }}</span> 
 </div>
</div>


<div class="row mb-3">
    <label for="checkout" class="col-6 col-md-4 col-form-label text-md-end">{{ __('Late Departure') }}</label>
    <div class="col-6">
        <input type="checkbox" class="form-control checkout @error('checkout') is-invalid @enderror" name="checkout" value="1" {{ $service->checkout == 1 ? 'checked' : '' }}>         
    </div>
</div>

<div class="departure_time_div" style="display:{{ $service->checkout == 1 ? 'block;' : 'none;' }}">
<div class="row mb-3">
    <label for="departure_time" class="col-md-4 col-form-label text-md-end">{{ __('Time') }}</label>
    <div class="col-md-6">
       <!-- <input id="departure_time" type="time" class="form-control @error('departure_time') is-invalid @enderror" name="departure_time" value="{{ \Carbon\Carbon::parse($service->departure_date)->format('H:i:s') !== '00:00:00' ? \Carbon\Carbon::parse($service->departure_date)->format('H:i:s') : '' }}"> -->

       <select id="departure_time" name="departure_time" class="form-control " tabindex="-1" aria-hidden="true" required> 
            @foreach (timeEntries_array() as $key=> $departure_time) 
            <option value="{{ $key }}" {{ $service->departure_time == $key ? 'selected' : '' }}>{{ $departure_time }}</option> 
            @endforeach
        </select>

       @error('departure_time')
       <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
</div>
</div>

<div class="row mb-3">
    <label for="room_code" class="col-md-4 col-form-label text-md-end">{{ __('Room Code') }}</label>

    <div class="col-md-6">
        <input id="room_code" type="number" class="form-control @error('room_code') is-invalid @enderror" name="room_code" value="{{ $service->room_code }}" @if($room_code) required @endif>

        @error('room_code')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <label for="b2b" class="col-md-4 col-form-label text-md-end">{{ __('B/B') }}</label>

    <div class="col-md-6">
        <input type="checkbox" class="form-control b2b @error('b2b') is-invalid @enderror" name="b2b" value="1" {{ $service->b2b ? 'checked' : '' }}>

    </div>
</div>

<div class="row mb-3">
    <label for="notes" class="col-md-4 col-form-label text-md-end">{{ __('Notes') }}</label>
    <div class="col-md-6">
        <textarea id="notes" class="form-control @error('notes') is-invalid @enderror" name="notes">{{ $service->notes }}</textarea>

        @error('notes')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>





<div class="row mb-3">
    <div class="col-md-6 offset-md-4">
        <a href="{{ route('owner-services.index') }}" class="btn btn-primary">{{ __('Go Back') }}</a>
        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
    </div>
</div>
</form>







</div>
</div>
</div>

@endsection