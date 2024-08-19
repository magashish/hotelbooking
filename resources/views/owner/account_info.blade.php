@extends('layouts.app')
@section('content')
@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif

  @include('breadcrumb.owner_breadcrumb')
<div class="container-fluid nss_style accountinfo">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Account Info</h1>
    </div>

    <div class="col-xl-12 col-md-12 mb-4 accountinfo_title">
        <div class="row mb-3">
            <div class="col-md-4 col-form-label text-md-end">
                <h3 class="col-form-label text-md-end">General Information</h3>           
            </div>
            <div class="col-md-8">  
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#usereditinfo">Edit Info </button>           
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 col-md-12 mb-4">          
            <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                <div class="col-md-6">
                   <span class="userinfo"> {{ $user->name }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Hotel Name') }}</label>
                <div class="col-md-6">
                   <span class="userinfo"> {{ $user->hotel_name }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('Address') }}</label>
                <div class="col-md-6">
                   <span class="userinfo"> {{ $user->address }}</span>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-12 mb-4">
            <div class="row mb-3">
                <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone') }}</label>
                <div class="col-md-6">
                   <span class="userinfo"> {{ $user->phone }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('E-Mail Address') }}</label>
                <div class="col-md-6">
                    <span class="userinfo"> {{ $user->email }}</span>
                </div>
            </div>
        </div>
    </div>


    <div class="col-xl-12 col-md-12 mb-4 accountinfo_title">
        <div class="row mb-3">
            <div class="col-md-4 col-form-label text-md-end">
                <h3 class="col-form-label text-md-end">Login Information</h3>           
            </div>
            <div class="col-md-8">  
            </div>
        </div>
    </div>

    <form  class="input-form user-add" method="POST" action="{{ route('owner.user_update', $user->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-xl-6 col-md-12 mb-4">          
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                    <div class="col-md-6">
                        <span class="userinfo"> {{ $user->name }} </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="status" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="password" name="password" required >
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                 </div>
             </div>
             <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
              </div>
          </div>
      </div>
  </div>
</form>





  <div class="col-xl-12 col-md-12 mb-4 accountinfo_title">
        <div class="row mb-3">
            <div class="col-md-4 col-form-label text-md-end">
                <h3 class="col-form-label text-md-end">Unit Information</h3>           
            </div>
            <div class="col-md-8">  
            </div>
        </div>
    </div>

    <div class="col-xl-12 col-md-12 mb-4">
        <div class="row mb-3">
            <div class="col-md-2 col-form-label text-md-end unitleft">
                <label for="unit_type" class="col-form-label text-md-end">Unit:</label>           
            </div>
            <div class="col-md-10 unitright"> 
            <table style="width: 100%; border-collapse: collapse;">
                @foreach ($services_array as $unit_id => $servicecount)
                <tr class="unitid">
                    <td><span>{{ get_unit_detail($unit_id)->name }}</span></td> 
                    <td> <span> ({{ $servicecount }})</span> </td>
                    <td> <span><a href="{{ route('owner.owner_get_date', $unit_id) }}">View</a></span> </td>
                </tr>              
                @endforeach
            </table>
            </div>
        </div>
    </div>

    




   <div class="modal fade" id="usereditinfo" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  class="input-form user-add" method="POST" action="{{ route('owner.user_update', $user->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-4">          
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
                                <label for="hotel_name" class="col-md-4 col-form-label text-md-end">{{ __('Hotel Name') }}</label>
                                <div class="col-md-6">
                                    <input id="hotel_name" type="text" class="form-control @error('hotel_name') is-invalid @enderror" name="hotel_name"
                                    value="{{ $user->hotel_name }}" required autocomplete="hotel_name" autofocus>

                                    @error('hotel_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('Address') }}</label>
                                <div class="col-md-6">
                                    <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                                    value="{{ $user->address }}" required autocomplete="address">

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
                                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                                    value="{{ $user->phone }}" required autocomplete="phone">

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('E-Mail Address') }}</label>
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
                        </div>                            
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">{{ __('Update Info') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>









</div>
@endsection