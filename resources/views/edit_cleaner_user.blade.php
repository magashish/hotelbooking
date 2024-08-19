<form  class="input-form user-add" method="POST" id="owneruseredit" action="{{ route('admin.cleaner_user_update', $user->id) }}" enctype="multipart/form-data">
@csrf
    <div class="modal-body">
        <div class="row">
            <div class="col-xl-12 col-md-12 mb-4">          
                <div class="row mb-3">
                    <label for="name" class="col-md-2 col-form-label text-md-end">{{ __('Name') }}</label>
                    <div class="col-md-10">
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
                <label for="address" class="col-md-2 col-form-label text-md-end">{{ __('Address') }}</label>
                <div class="col-md-10">
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
                <label for="city" class="col-md-2 col-form-label text-md-end">{{ __('City') }}</label>
                <div class="col-md-10">
                    <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ $user->city }}" required autocomplete="city">
                    @error('city')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

            </div>

            <div class="row mb-3">
                <label for="state" class="col-md-2 col-form-label text-md-end">{{ __('State') }}</label>
                <div class="col-md-10">
                    <input id="state" type="text" class="form-control @error('state') is-invalid @enderror" name="state" value="{{ $user->state }}" required autocomplete="state">
                    @error('state')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="zip" class="col-md-2 col-form-label text-md-end">{{ __('Zip') }}</label>
                <div class="col-md-10">
                    <input id="zip" type="text" class="form-control @error('zip') is-invalid @enderror" name="zip" value="{{ $user->zip }}" required autocomplete="zip">
                    @error('zip')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>   
            </div>

            <div class="row mb-3">
                <label for="phone" class="col-md-2 col-form-label text-md-end">{{ __('Phone') }}</label>
                <div class="col-md-10">
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
                <label for="email" class="col-md-2 col-form-label text-md-end">{{ __('E-Mail ') }}</label>
                <div class="col-md-10">
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
                <label for="status" class="col-md-2 col-form-label text-md-end">{{ __('Status') }}</label>
                <div class="col-md-10">
                  <select id="status" name="status" class="form-control " tabindex="-1" aria-hidden="true"> 
                    @foreach (cleaner_status_array() as $key=> $status) 
                    <option value="{{ $key }}" {{ $user->status == $key ? 'selected' : '' }}>{{ $status }}</option> 
                    @endforeach
                </select>
                @error('status')
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