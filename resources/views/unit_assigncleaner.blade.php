
<form class="input-form service-add"  method="POST" action="{{ route('services.update', $service->id) }}" enctype="multipart/form-data">
 @csrf
 @method('PUT')
 <input type="hidden" name="check" value="assigncleaner">
 <div class="row mb-3">
    <label for="unit" class="col-md-4 col-form-label text-md-end">{{ __('Unit#') }}</label>
    <div class="col-md-6">
        <span class="form-control-span">{{ $service->unit }}</span>         
    </div>
</div>

<div class="row mb-3">
    <label for="bed_type" class="col-md-4 col-form-label text-md-end">{{ __('Bedroom Type') }}</label>
    <div class="col-md-6">           
      <span class="form-control-span">{{ get_unit_detail($service->unit)->bedroom_type }}</span> 
  </div>
</div>
<div class="row mb-3">
    <label for="guest_name" class="col-md-4 col-form-label text-md-end">{{ __('Guest Name') }}</label>
    <div class="col-md-8">
        <span class="form-control-span">{{ $service->guest_name }}</span> 
    </div>
</div>
<div class="row mb-3">
    <label for="arrival_date" class="col-md-4 col-form-label text-md-end">{{ __('Arrival Date') }}</label>

    <div class="col-md-8">
       <span class="form-control-span">{{ $service->arrival_date }}</span> 
    </div>
</div>

<div class="row mb-3">
    <label for="arrival_time" class="col-md-4 col-form-label text-md-end">{{ __('Arrival Time') }}</label>

    <div class="col-md-8">
       <span class="form-control-span">{{ $service->arrival_time }}</span> 
    </div>
</div>

<div class="row mb-3">
    <label for="departure_date" class="col-md-4 col-form-label text-md-end">{{ __('Departure Date') }}</label>
    <div class="col-md-8">
       <span class="form-control-span">{{ $service->departure_date }}</span> 
    </div>
</div>

<div class="row mb-3">
    <label for="departure_time" class="col-md-4 col-form-label text-md-end">{{ __('Departure Time') }}</label>
    <div class="col-md-8">
       <span class="form-control-span">{{ $service->departure_time }}</span> 
    </div>
</div>

<div class="row mb-3">
    <label for="room_code" class="col-md-4 col-form-label text-md-end">{{ __('Room Code') }}</label>
    <div class="col-md-8">
        <span class="form-control-span">{{ $service->room_code }}</span>    
    </div>
</div>
<div class="row mb-3">
    <label for="notes" class="col-md-4 col-form-label text-md-end">{{ __('Notes') }}</label>
    <div class="col-md-8">
        <span class="form-control-span">{{ $service->notes }}</span>    
    </div>
</div>
<div class="row mb-3">
  <label class="col-md-4 col-form-label text-md-end">{{ __('Runner') }}</label>
  <div class="col-md-8">
    <select id="runner" name="runner" class="form-control " tabindex="-1" aria-hidden="true" required> 
        <option value="">Select Runner</option>
        @foreach ($user_data as $key=> $user) 
        <option value="{{ $user->id; }}" @if($service->runner == $user->id) selected @endif>{{ $user->name; }}</option> 
        @endforeach
    </select>
</div>
</div>
<div class="row mb-3">
  <label class="col-md-4 col-form-label text-md-end">{{ __('Cleaner') }}</label>
  <div class="col-md-8">
    <select id="cleaner" name="cleaner" class="form-control " tabindex="-1" aria-hidden="true" required> 
        <option value="">Select Cleaner</option>
        @foreach ($user_data as $key=> $user) 
        <option value="{{ $user->id; }}" @if($service->cleaner == $user->id) selected @endif>{{ $user->name; }}</option> 
        @endforeach
    </select>
</div>
</div>

<div class="row mb-3">
  <label class="col-md-4 col-form-label text-md-end">{{ __('Carry Over Date ') }}</label>
  <div class="col-md-8">
    <input type="date" class="form-control carry_over_date" name="carry_over_date" value="{{ $service->carry_over_date; }}">
</div>
</div>

<div class="row mb-3">
    <div class="col-md-8 offset-md-4">
        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
    </div>
</div>
</form>
