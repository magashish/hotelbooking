   <form class="input-form unitinfo-add" id="unitinfoform" method="POST" action="{{ route('unit.store') }}" enctype="multipart/form-data">
             @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-4"> 
                            <input type="hidden" name="owner_id" value="{{ $ownerid }}" >

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Unit') }}</label>
                                <div class="col-md-8">
                                    <input id="name" type="number" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="bedroom_type" class="col-md-4 col-form-label text-md-end">{{ __('Bedroom Type') }}</label>
                                <div class="col-md-8">
                                    <input id="bedroom_type" type="number" class="form-control @error('bedroom_type') is-invalid @enderror" name="bedroom_type" value="{{ old('bedroom_type') }}" required>
                                    @error('bedroom_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                             <div class="row mb-3">
                                <label for="bed_size" class="col-md-4 col-form-label text-md-end">{{ __('Bed Size') }}</label>
                                <div class="col-md-8">
                                    <select id="bed_size"  class="form-control js-bed-size-basic-single" name="bed_size[]" multiple="multiple"required> 
                                    @foreach (bed_size_array() as $key=> $bed_size) 
                                        <option value="{{ $bed_size }}">{{ $bed_size }}</option> 
                                    @endforeach
                                </select>

                                    @error('bed_size')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                             <div class="row mb-3">
                                <label for="sofa_size" class="col-md-4 col-form-label text-md-end">{{ __('Sofa') }}</label>
                                <div class="col-md-8">
                                   
                                    <select id="sofa_size" name="sofa_size" class="form-control " tabindex="-1" aria-hidden="true"> 
                                    @foreach (sofa_size_array() as $key=> $sofa_size) 
                                        <option value="{{ $key }}">{{ $sofa_size }}</option> 
                                    @endforeach
                                </select>

                                    @error('sofa_size')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                           {{--   <div class="row mb-3">
                                <label for="futon_size" class="col-md-4 col-form-label text-md-end">{{ __('Futon Size') }}</label>
                                <div class="col-md-8">

                                    <select id="futon_size" name="futon_size" class="form-control " tabindex="-1" aria-hidden="true"> 
                                    @foreach (futon_size_array() as $key=> $futon_size) 
                                        <option value="{{ $key }}">{{ $futon_size }}</option> 
                                    @endforeach
                                </select>

                                    @error('futon_size')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div> --}}

                             <div class="row mb-3">
                                <label for="master_code" class="col-md-4 col-form-label text-md-end">{{ __('I.D.') }}</label>
                                <div class="col-md-8">
                                    <input id="master_code" type="text" class="form-control @error('master_code') is-invalid @enderror" name="master_code" value="{{ old('master_code') }}" required>
                                    @error('master_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="row mb-3">
                                <label for="room_code" class="col-md-4 col-form-label text-md-end">{{ __('Room Code Manually') }}</label>
                                <div class="col-md-8 text-md-start">
                                    <input id="room_code" type="checkbox" class="form-control @error('room_code') is-invalid @enderror" name="room_code" value="1">                                   
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="checkin" class="col-md-4 col-form-label text-md-end">{{ __('Check in') }}</label>
                                <div class="col-md-8">                                   
                                    <select id="checkin" name="checkin" class="form-control " tabindex="-1" aria-hidden="true" required> 
                                        @foreach (timeEntries_array() as $key=> $checkin) 
                                        <option value="{{ $key }}">{{ $checkin }}</option> 
                                        @endforeach
                                    </select>
                                    @error('checkin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="checkout" class="col-md-4 col-form-label text-md-end">{{ __('Check out') }}</label>
                                <div class="col-md-8">
                                    <select id="checkout" name="checkout" class="form-control " tabindex="-1" aria-hidden="true" required> 
                                        @foreach (timeEntries_array() as $key=> $checkout) 
                                        <option value="{{ $key }}">{{ $checkout }}</option> 
                                        @endforeach
                                    </select>

                                    @error('checkout')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">{{ __('Insert') }}</button>
                                </div>
                            </div>                         

                        </div>                            
                    </div>
                </div>
               {{--  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div> --}}
            </form>