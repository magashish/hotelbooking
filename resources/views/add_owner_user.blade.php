@extends('layouts.app')
@section('content')
@if (session('status'))
<div class="alert alert-success">
 {{ session('status') }}
</div>
@endif
<div class="container-fluid nss_style">
 <div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">
    <span class="rental insert_dates"><a href="{{ route('home.manage') }}">Manage</a> </span> 
    >>
    <span class="rental insert_dates"><a href="{{ route('user.userowner') }}">Owners</a> </span>
    >>
    Insert Owner
  </h1>
</div>
<div class="row">
  <div class="col-xl-12 col-md-12 mb-4 user-add-owner">
   <form class="input-form user-add"  method="POST" action="{{ isset($user) ? route('user.update', $user->id) : route('user.store') }}" enctype="multipart/form-data">
    @csrf
    <input type="text" name="check" value="owner" readonly style="display: none;">
    <input type="text" name="role" value="owner" readonly style="display: none;">
      
  <div class="row mb-3">
    <label for="name" class="col-md-2 col-form-label text-md-end">{{ __('Name') }}</label>
    <div class="col-md-10">
      <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
      @error('name')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>
  <div class="row mb-3">
    <label for="email" class="col-md-2 col-form-label text-md-end">{{ __('Email') }}</label>
    <div class="col-md-10">
      <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
      @error('email')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>
    <div class="row mb-3">
    <label for="phone" class="col-md-2 col-form-label text-md-end">{{ __('Phone') }}</label>
    <div class="col-md-10">
      <input id="phone" type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">
      @error('phone')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>
    <div class="row mb-3">
    <label for="hotel_name" class="col-md-2 col-form-label text-md-end">{{ __('Hotel Name') }}</label>

    <div class="col-md-10">
      <input id="hotel_name" type="text" class="form-control @error('hotel_name') is-invalid @enderror" name="hotel_name" value="{{ old('hotel_name') }}" required autocomplete="hotel_name" autofocus>
      @error('hotel_name')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>
   <div class="row mb-3">
    <label for="address" class="col-md-2 col-form-label text-md-end">{{ __('Address') }}</label>
    <div class="col-md-10">
      <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address">
      @error('address')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>
<div class="row mb-3">
    <label for="city" class="col-md-2 col-form-label text-md-end">{{ __('City') }}</label>
    <div class="col-md-2">
        <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="city">
        @error('city')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
     <label for="state" class="col-md-1 col-form-label text-md-end">{{ __('State') }}</label>
    <div class="col-md-3">
        <input id="state" type="text" class="form-control @error('state') is-invalid @enderror" name="state" value="{{ old('state') }}" required autocomplete="state">
        @error('state')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <label for="zip" class="col-md-1 col-form-label text-md-end">{{ __('Zip') }}</label>
    <div class="col-md-3">
        <input id="zip" type="text" class="form-control @error('zip') is-invalid @enderror" name="zip" value="{{ old('zip') }}" required autocomplete="zip">
        @error('zip')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>   
</div>





 <div class="row mb-3">
    <label for="username" class="col-md-2 col-form-label text-md-end">{{ __('UserName') }}</label>
    <div class="col-md-10">
      <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="" required autocomplete="off">
      @error('username')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>


  <div class="row mb-3">
    <label for="password" class="col-md-2 col-form-label text-md-end">{{ __('Password') }}</label>
    <div class="col-md-10">
      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
      @error('password')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>

  <div class="row mb-3">
    <label for="status" class="col-md-2 col-form-label text-md-end">{{ __('Status') }}</label>
    <div class="col-md-10">
      <select id="status" name="status" class="form-control " tabindex="-1" aria-hidden="true"> 
        @foreach (owner_status_array() as $key=> $status) 
        <option value="{{ $key; }}">{{ $status; }}</option> 
        @endforeach
      </select>
      @error('status')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>




  <div class="row mb-0">
    <div class="col-md-10 offset-md-4">
      <button type="submit" class="btn btn-primary">{{ __('Insert') }}</button>
    </div>
  </div>


</form>
</div>
</div>
</div>

@endsection