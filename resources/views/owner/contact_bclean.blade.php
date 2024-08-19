@extends('layouts.app')
@section('content')
@if (session('status'))
<div class="alert alert-success">
   {{ session('status') }}
</div>
@endif

  @include('breadcrumb.owner_breadcrumb')
<div class="container-fluid nss_style">
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Contact BClean</h1>
  </div>
  <div class="row">
      <div class="col-xl-12 col-md-12 mb-4 contactbclean">

          <form class="input-form user-add"  method="POST" action="{{ route('owner.post_contact_bclean') }}" enctype="multipart/form-data">
             @csrf
             <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ $user->name }}" required autocomplete="name" autofocus>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone') }}</label>
                <div class="col-md-6">
                  <input id="phone" type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $user->phone }}" required autocomplete="phone">
                  @error('phone')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('E-Mail') }}</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ $user->email }}" required autocomplete="email">

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <label for="notes" class="col-md-4 col-form-label text-md-end">{{ __('Message') }}</label>
            <div class="col-md-6">
                <textarea id="notes" class="form-control @error('notes') is-invalid @enderror" name="notes" required>{{ old('notes') }}</textarea>
                @error('notes')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="row mb-0">
            <div class="col-md-6 offset-md-4">
              <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
          </div>
      </div>
  </form>
</div>
</div>
</div>

@endsection