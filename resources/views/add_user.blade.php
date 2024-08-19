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
    Insert Admin
  </h1>
</div>





<div class="row">
  <div class="col-xl-12 col-md-12 mb-4 user-add-owner">
   <form class="input-form user-add"  method="POST" action="{{ isset($user) ? route('user.update', $user->id) : route('user.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="row mb-3" style="display: none;">
     <label class="col-md-4 col-form-label text-md-end">User Type</label>
     <div class="col-md-6">
      <select id="role" name="role" class="form-control " tabindex="-1" aria-hidden="true"> 
        @foreach ($role_type as $key=> $role) 
        <option value="{{ $key; }}">{{ $role; }}</option> 
        @endforeach
      </select>
    </div>
  </div>  
  <div class="row mb-3">
    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

    <div class="col-md-6">
      <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

      @error('name')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>

  <div class="row mb-3">
    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

    <div class="col-md-6">
      <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

      @error('email')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>

   <div class="row mb-3">
    <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('Address') }}</label>
    <div class="col-md-6">
      <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address">
      @error('address')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>


    <div class="row mb-3">
    <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone') }}</label>
    <div class="col-md-6">
      <input id="phone" type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">
      @error('phone')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>



  <div class="row mb-3">
    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

    <div class="col-md-6">
      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

      @error('password')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>

  <div class="row mb-3">
    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

    <div class="col-md-6">
      <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
    </div>
  </div>

  <div class="row mb-0">
    <div class="col-md-6 offset-md-4">
      <button type="submit" class="btn btn-primary">
        {{ __('Insert ') }}
      </button>
    </div>
  </div>


</form>
</div>
</div>
</div>

@endsection