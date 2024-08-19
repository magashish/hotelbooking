@extends('layouts.app')
@section('content')
@if (session('status'))
<div class="alert alert-success">
 {{ session('status') }}
</div>
@endif
<div class="container-fluid nss_style">
 <div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Add service</h1>
</div>
<div class="row">
  <div class="col-xl-12 col-md-12 mb-4">




  

    <div class="row mb-3">
        <label for="unit" class="col-md-4 col-form-label text-md-end">{{ __('Unit') }}</label>

        <div class="col-md-6">
            {{ $service->unit }}
        </div>
    </div>

    <div class="row mb-3">
        <label for="bed_type" class="col-md-4 col-form-label text-md-end">{{ __('Bed Type') }}</label>

        <div class="col-md-6">
            {{ $service->bed_type }}
        </div>
    </div>

    <div class="row mb-3">
        <label for="guest_name" class="col-md-4 col-form-label text-md-end">{{ __('Guest Name') }}</label>

        <div class="col-md-6">
            {{ $service->guest_name }}
        </div>
    </div>

    <div class="row mb-3">
        <label for="arrival_date" class="col-md-4 col-form-label text-md-end">{{ __('Arrival Date') }}</label>

        <div class="col-md-6">
            {{  date('d F Y', strtotime($service->arrival_date)) }}
        </div>
    </div>

    <div class="row mb-3">
        <label for="arrival_time" class="col-md-4 col-form-label text-md-end">{{ __('Arrival Time') }}</label>

        <div class="col-md-6">
            {{  date('h:i:s A', strtotime($service->arrival_time)) }}
        </div>
    </div>

    <div class="row mb-3">
        <label for="departure_date" class="col-md-4 col-form-label text-md-end">{{ __('Departure Date') }}</label>

        <div class="col-md-6">
            {{  date('d F Y', strtotime($service->departure_date)) }}
        </div>
    </div>

    <div class="row mb-3">
        <label for="departure_time" class="col-md-4 col-form-label text-md-end">{{ __('Departure Time') }}</label>

        <div class="col-md-6">
            {{  date('h:i:s A', strtotime($service->departure_time)) }}
        </div>
    </div>

    <div class="row mb-3">
        <label for="room_code" class="col-md-4 col-form-label text-md-end">{{ __('Room Code') }}</label>

        <div class="col-md-6">
            {{ $service->room_code }}
        </div>
    </div>

    <div class="row mb-3">
        <label for="notes" class="col-md-4 col-form-label text-md-end">{{ __('Notes') }}</label>

        <div class="col-md-6">
           {{ $service->notes }}
        </div>
    </div>

    








</div>
</div>
</div>

@endsection