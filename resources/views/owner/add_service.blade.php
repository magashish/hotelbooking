@extends('layouts.app')
@section('content')
@if (session('status'))
<div class="alert alert-success">
   {{ session('status') }}
</div>
@endif

@include('breadcrumb.owner_breadcrumb')

<div class="container-fluid nss_style add-service-date">  

   <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800"><span class="rental">Rental Info </span> >> <span class="insert_dates">Insert Dates </span></h1>
      <p>We take care of everything necessary to ensure rooms are ready for occupancy. With over a decade of experience in hotel rental vacation rooms, our
      certified cleaners and maintenance professionals take pride in providing expert service to sustain an enjoyable environment for your guests.</p>
  </div>

  @if(!isset($id))

  <div class="row">
      <div class="col-xl-12 col-md-12 mb-4">
        <div class="row mb-3">
            <div class="col-md-4 col-form-label text-md-end  offset-md-4">
                <label for="unit_type" class="col-form-label text-md-end">{{ __('Select The Unit # to Insert Dates') }}</label>
                <select id="unit_type" class="form-control">
                    <option value="">Select Unit #</option>
                    @foreach(unit_type_owner_array(auth()->user()->id) as $key => $value)
                    <option value="{{ route('owner.owner_create_date', $value->id) }}" >{{ $value->name }}</option>
                    @endforeach
                </select>
            </div>

        </div>
    </div>
</div>
@else

@php
    $data = get_unit_detail($id);
    $room_code = $data->room_code; 
    $checkinTime = get_unit_detail($id)->checkin;
    $checkoutTime =get_unit_detail($id)->checkout;
@endphp

<div class="row">
    <div class="col-xl-12 col-md-12 mb-4" id="message">     
    </div>
    <div class="col-xl-12 col-md-12 mb-4 unit_title">
        <div class="row mb-3">
            <div class="col-md-12 col-form-label text-md-end">
                <label for="unit_type" class="col-form-label text-md-end">{{ __('Unit #:')}}  <span class="unit_id">{{ get_unit_detail($id)->name }}</span></label>           
            </div>

        </div>
    </div>
</div>


<div class="row mobile_section d-md-none">
  <div class="col-xl-12 col-md-12 mb-4 mobile_service_section">
    <form id="service_form_mobile" class="input-form user-add"  method="POST" action="{{ route('owner-services.store') }}" enctype="multipart/form-data">
        @csrf 
        <div class="rental_dates_div"> 
            <div class="rental_dates mt-4 rental_date_1"> 
                <div class="row mb-3 service_minus_div" style="display:none;">
                    <label for="notes" class="col-6 col-md-4 col-form-label text-md-end"></label>
                    <div class="col-6 text-end">  
                       <span class="service_minus btn btn-danger btn-circle" ><i class="fa fa-minus" aria-hidden="true"></i></span>                    
                   </div>
               </div>
               <div class="row mb-3" style="display:none;">
                <label for="unit" class="col-6 col-md-4 col-form-label text-md-end">{{ __('Unit') }}</label>
                <div class="col-6">
                    <input  type="number" class="copy_value form-control @error('unit') is-invalid @enderror" name="service[1][unit]" value="{{ $id }}" readonly>
                </div>
            </div>

            <div class="row mb-3">
                <label for="guest_name" class="col-6 col-md-4 col-form-label text-md-end">{{ __('Guest Name') }}</label>
                <div class="col-6">
                    <input  type="text" class="form-control @error('guest_name') is-invalid @enderror" name="service[1][guest_name]" value="{{ old('guest_name') }}" required>

                </div>
            </div>

            <div class="row mb-3">
                <label for="arrival_date" class="col-6 col-md-4 col-form-label text-md-end">{{ __('Arrival Date') }}</label>
                <div class="col-6">
                    <input  type="date" class="form-control @error('arrival_date') is-invalid @enderror" name="service[1][arrival_date]" value="{{ old('arrival_date') }}" required>

                </div>
            </div>
            <div class="row mb-3">
                <label for="arrival_date" class="col-6 col-md-4 col-form-label text-md-end">{{ __('Arrival Time') }}</label>
                <div class="col-6">
                 <span class="form-control-data">{{ date('h:i A', strtotime(get_unit_detail($id)->checkin)) }}</span>                         
             </div>
         </div>

         <div class="row mb-3">
            <label for="checkin" class="col-6 col-md-4 col-form-label text-md-end">{{ __('Early Check In') }}</label>
            <div class="col-6">
                <input type="checkbox" class="form-control checkin @error('checkin') is-invalid @enderror" name="service[1][checkin]" value="1">            
            </div>
        </div>

        <div class="arrival_time_div">
            <div class="row mb-3">
                <label for="arrival_time" class="col-6 col-md-4 col-form-label text-md-end">{{ __('Time') }}</label>
                <div class="col-6">
                    <!-- <input  type="time" class="arrival_time form-control @error('arrival_time') is-invalid @enderror" name="service[1][arrival_time]" value="{{ old('arrival_time') }}">                         -->

                <select class="arrival_time form-control @error('arrival_time') is-invalid @enderror" name="service[1][arrival_time]" tabindex="-1" aria-hidden="true"> 
                    @foreach (timeEntries_array() as $key=> $arrival_time) 
                    <option value="{{ $key }}"  {{ $checkinTime === $key ? 'selected' : '' }}>{{ $arrival_time }}</option> 
                    @endforeach
                </select> 

                </div>
            </div>
        </div>


        <div class="row mb-3">
            <label for="departure_date" class="col-6 col-md-4 col-form-label text-md-end">{{ __('Departure Date') }}</label>
            <div class="col-6">
                <input  type="date" class="form-control @error('departure_date') is-invalid @enderror" name="service[1][departure_date]" value="{{ old('departure_date') }}" required>

            </div>
        </div>

        <div class="row mb-3">
            <label for="arrival_date" class="col-6 col-md-4 col-form-label text-md-end">{{ __('Departure Time') }}</label>
            <div class="col-6">
             <span class="form-control-data">{{ date('h:i A', strtotime(get_unit_detail($id)->checkout)) }}</span>                         
         </div>
     </div>


     <div class="row mb-3">
        <label for="checkout" class="col-6 col-md-4 col-form-label text-md-end">{{ __('Late Departure') }}</label>
        <div class="col-6">
            <input type="checkbox" class="form-control checkout @error('checkout') is-invalid @enderror" name="service[1][checkout]" value="1">         
        </div>
    </div>

    <div class="departure_time_div">
        <div class="row mb-3">
            <label for="departure_time" class="col-6 col-md-4 col-form-label text-md-end">{{ __('Time') }}</label>
            <div class="col-6">
                <!-- <input  type="time" class="departure_time form-control @error('departure_time') is-invalid @enderror" name="service[1][departure_time]" value="{{ old('departure_time') }}"> -->         

                <select class="form-control departure_time @error('departure_time') is-invalid @enderror" name="service[1][departure_time]" tabindex="-1" aria-hidden="true"> 
                    @foreach (timeEntries_array() as $key=> $departure_time) 
                    <option value="{{ $key }}"  {{ $checkoutTime === $key ? 'selected' : '' }}>{{ $departure_time }}</option> 
                    @endforeach
                </select>

            </div>
        </div>
    </div>

    <div class="row mb-3">
        <label for="b2b" class="col-6 col-md-4 col-form-label text-md-end">{{ __('B/B') }}</label>
        <div class="col-6">
            <input type="checkbox" class="form-control b2b @error('b2b') is-invalid @enderror" name="service[1][b2b]" value="1">

        </div>
    </div>


    <div class="row mb-3">
        <label for="room_code" class="col-6 col-md-4 col-form-label text-md-end">{{ __('Room Code') }}</label>
        <div class="col-6">
            <input  type="number" class="form-control @error('room_code') is-invalid @enderror" name="service[1][room_code]" value="{{ old('room_code') }}"  @if($room_code) required @endif>

        </div>
    </div>

    <div class="row mb-3">
        <label for="notes" class="col-6 col-md-4 col-form-label text-md-end">{{ __('Notes') }}</label>
        <div class="col-6">
            <textarea class="form-control @error('notes') is-invalid @enderror" name="service[1][notes]">{{ old('notes') }}</textarea>

        </div>
    </div> 


</div>
</div>
{{-- <div class="row mb-3">
    <label for="notes" class="col-6 col-md-4 col-form-label text-md-end"></label>
    <div class="col-6">
        <span id="service_add_more" newIndex="1" class="btn"><i class="fa fa-plus" aria-hidden="true"></i></span>
    </div>
</div> --}}

<div class="row mb-3">
    <label for="notes" class="col-6 col-md-4 col-form-label text-md-end">
        <span id="service_add_more" newIndex="1" class="btn  btn-circle"><i class="fa fa-plus" aria-hidden="true"></i></span>
    </label>
    <div class="col-6 mb-3">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
</form>
</div>
</div>



<div class="row desktop_section d-none d-md-block">
  <div class="col-xl-12 col-md-12 mb-4">
     <form id="service_form" class="input-form user-add"  method="POST" action="{{ route('owner-services.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="add-service-table"> 
            <div class="service-table-div"> 
                <table class="services_table date_services_table">
                  <thead>
                   <tr>
                    <th style="display: none">{{ __('Unit') }}</th>
                    <th>{{ __('Guest Name') }}</th>
                    <th>{{ __('Arrival Date') }}</th>
                    <th>{{ __('Arrival Time') }}</th>
                    <th>{{ __('Early Check In') }}</th>
                    <th>{{ __('Time') }}</th>
                    <th>{{ __('Departure Date') }}</th>
                    <th>{{ __('Departure Time') }}</th>
                    <th>{{ __('Late Departure') }}</th>
                    <th>{{ __('Time') }}</th>
                    <th>{{ __('Room Code') }}</th>
                    <th>{{ __('B/B') }}</th>
                    <th>{{ __('Notes') }}</th>
                    <th>{{ __('') }}</th>
                </tr>
            </thead>
            <tbody>               
                <tr class="clone_tr unit_item_1">
                 <td style="display:none;">  
                     <input type="number" class="form-control copy_value" name="service[1][unit]" value="{{ $id }}" readonly> 

                 </td>

                 <td>
                    <input type="text" class="form-control guest_name @error('guest_name') is-invalid @enderror" name="service[1][guest_name]" value="{{ old('guest_name') }}" required>
                </td>
                <td>
                    <input  type="date" class="form-control arrival_date @error('arrival_date') is-invalid @enderror" name="service[1][arrival_date]" value="{{ old('arrival_date') }}" required>
                </td>

                <td>
                 <span class="form-control-data">{{ date('h:i A', strtotime(get_unit_detail($id)->checkin)) }}</span> 
             </td>

             <td>
                <input type="checkbox" class="form-control checkin @error('checkin') is-invalid @enderror" name="service[1][checkin]" value="1">
            </td>

            <td>
                <!-- <input type="time" class="form-control arrival_time @error('arrival_time') is-invalid @enderror" name="service[1][arrival_time]" value="{{ old('arrival_time') }}"> -->
            <select class="form-control arrival_time @error('arrival_time') is-invalid @enderror" name="service[1][arrival_time]" tabindex="-1" aria-hidden="true"> 
                    @foreach (timeEntries_array() as $key=> $arrival_time) 
                    <option value="{{ $key }}" {{ $checkinTime == $key ? 'selected' : '' }}>{{ $arrival_time }}</option> 
                    @endforeach
                </select> 
            </td>
            <td>
                <input type="date" class="form-control departure_date @error('departure_date') is-invalid @enderror" name="service[1][departure_date]" value="{{ old('departure_date') }}" required>
            </td>

            <td>
             <span class="form-control-data">{{ date('h:i A', strtotime(get_unit_detail($id)->checkout)) }}</span> 
         </td>

         <td>
            <input type="checkbox" class="form-control checkout @error('checkout') is-invalid @enderror" name="service[1][checkout]" value="1">
        </td>

        <td>
            <!-- <input type="time" class="form-control departure_time @error('departure_time') is-invalid @enderror" name="service[1][departure_time]" value="{{ old('departure_time') }}"> -->

            <select class="form-control departure_time @error('departure_time') is-invalid @enderror" name="service[1][departure_time]" tabindex="-1" aria-hidden="true"> 
                    @foreach (timeEntries_array() as $key=> $departure_time) 
                    <option value="{{ $key }}" {{ $checkoutTime == $key ? 'selected' : '' }}>{{ $departure_time }}</option> 
                    @endforeach
                </select>

        </td>
        <td>
            <input type="number" class="form-control  room_code @error('room_code') is-invalid @enderror" name="service[1][room_code]" value="{{ old('room_code') }}" @if($room_code) required @endif>
        </td>
        <td>
            <input type="checkbox" class="form-control b2b @error('b2b') is-invalid @enderror" name="service[1][b2b]" value="1">
        </td>
        <td>
            <textarea class="form-control notes @error('notes') is-invalid @enderror" name="service[1][notes]">{{ old('notes') }}</textarea>
        </td>
        <td class="service_minus_more_tr" style="display:none">
         <span class="service_minus_more" ><i class="fa fa-minus" aria-hidden="true"></i></span>
     </td>

 </tr>
</tbody>
</table>
</div>
</div>
<div class="service_add_more_div">
    <span class="service_add_more_tr" newIndex="1" class="btn btn-danger btn-circle"><i class="fa fa-plus" aria-hidden="true"></i></span>
    <span>Click on + to enter more dates</span>        
</div>
<div class="col-md-12">
    <div class="col-md-12 col-form-label text-right">
       <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
   </div>
</div>
</form>
</div>
</div>
@endif
</div>

@endsection