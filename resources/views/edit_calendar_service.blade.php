<form class="input-form service-add"  method="POST" action="{{ route('services.update', $service->id) }}" enctype="multipart/form-data">
 @csrf
 @method('PUT')
 <div class="row mb-3">
    <label for="unit" class="col-md-6 col-form-label text-md-end">{{ __('Unit#') }}</label>
    <div class="col-md-6">
        <span class="form-control-span">{{ get_unit_detail($service->unit)->name }}</span>         
       {{-- <select id="unit" class="form-control @error('unit') is-invalid @enderror" name="unit" required>
        @foreach(unit_type_array() as $key => $value)
        <option value="{{ $value->id }}" @if( $service->unit == $value->id) selected @endif>{{ $value->name }}</option>
        @endforeach
    </select> --}}
</div>
</div>

<div class="row mb-3">
    <label for="bed_type" class="col-md-6 col-form-label text-md-end">{{ __('Bed Type') }}</label>
    <div class="col-md-6">
        <span class="form-control-span">{{ get_unit_detail($service->unit)->bedroom_type }}</span> 
        {{-- <select id="bed_type" class="form-control @error('bed_type') is-invalid @enderror" name="bed_type" required>
            @foreach(bed_type_array() as $key => $value)
            <option value="{{ $key }}" @if($service->bed_type == $key) selected @endif>{{ $value }}</option>
            @endforeach
        </select> --}}
    </div>
</div>

<div class="row mb-3">
    <label for="guest_name" class="col-md-6 col-form-label text-md-end">{{ __('Guest Name') }}</label>

    <div class="col-md-6">
       <span class="form-control-span">{{ $service->guest_name }}</span>
    </div>
</div>
<div class="row mb-3">
    <label for="arrival_date" class="col-md-6 col-form-label text-md-end">{{ __('Arrival Date') }}</label>

    <div class="col-md-6">
        <span class="form-control-span">{{ \Carbon\Carbon::parse($service->arrival_date)->format('Y-m-d') }}</span>
    </div>
</div>

<div class="row mb-3">
    <label for="arrival_time" class="col-md-6 col-form-label text-md-end">{{ __('Arrival Time') }}</label>

    <div class="col-md-6">
        <span class="form-control-span">{{ \Carbon\Carbon::parse($service->arrival_date)->format('h:i A') !== '12:00 AM' ? \Carbon\Carbon::parse($service->arrival_date)->format('h:i A') : '---' }}</span>

    </div>
</div>

<div class="row mb-3">
    <label for="departure_date" class="col-md-6 col-form-label text-md-end">{{ __('Departure Date') }}</label>
    <div class="col-md-6">
        <span class="form-control-span">{{ \Carbon\Carbon::parse($service->departure_date)->format('Y-m-d') }}</span>
    </div>
</div>

<div class="row mb-3">
    <label for="departure_time" class="col-md-6 col-form-label text-md-end">{{ __('Departure Time') }}</label>
    <div class="col-md-6">
        <span class="form-control-span"> {{ \Carbon\Carbon::parse($service->departure_date)->format('h:i A') !== '12:00 AM' ? \Carbon\Carbon::parse($service->departure_date)->format('h:i A') : '---' }}</span>
    </div>
</div>

<div class="row mb-3">
    <label for="room_code" class="col-md-6 col-form-label text-md-end">{{ __('Room Code') }}</label>
    <div class="col-md-6">
        <span class="form-control-span">{{ $service->room_code }}</span>
    </div>
</div>
<div class="row mb-3">
    <label for="notes" class="col-md-6 col-form-label text-md-end">{{ __('Notes') }}</label>
    <div class="col-md-6">
        <span class="form-control-span">{{ $service->notes }}</span>
    </div>
</div>
<div class="row mb-3">
  <label class="col-md-6 col-form-label text-md-end">{{ __('Cleaner') }}</label>
  <div class="col-md-6">
    @if (!empty($service->cleaner))
    {{ get_userdata($service->cleaner)->name }}
@endif
</div>
</div>

<div class="row mb-3">
  <label class="col-md-6 col-form-label text-md-end">{{ __('Runner') }}</label>
  <div class="col-md-6">
     @if (!empty($service->runner))
    {{ get_userdata($service->runner)->name }}
@endif
</div>
</div>

<div class="row mb-3">
  <label class="col-md-6 col-form-label text-md-end">{{ __('Cleaner Carry Over Date') }}</label>
  <div class="col-md-6">
    <span class="form-control-span">{{ $service->carry_over_date }}</span>
</div>
</div>
{{-- <div class="row mb-3">
    <div class="col-md-6 offset-md-4">
        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
    </div>
</div> --}}
</form>
