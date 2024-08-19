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
        <h1 class="h3 mb-0 text-gray-800">
    <span class="rental insert_dates"><a href="{{ route('home.manage') }}">Manage</a> </span> 
    >>
    <span class="rental insert_dates"><a href="{{ route('user.userowner') }}">Owners</a> </span>
    >>
    Information
  </h1>
    </div>

    <div class="col-xl-12 col-md-12 mb-4 accountinfo_title">
        <div class="row mb-3">
            <div class="col-md-4 col-form-label text-md-end">
                <h3 class="col-form-label text-md-end">General Information</h3>           
            </div>
            <div class="col-md-8">  
                <button type="button" class="btn btn-primary usereditinfo InsertUpdateunitinfo"  data-url="{{ route('user.editowneruser', $user->id) }}">Edit Info </button>           
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
                <label for="hotel_name" class="col-md-4 col-form-label text-md-end">{{ __('Hotel Name') }}</label>
                <div class="col-md-6">
                   <span class="userinfo"> {{ $user->hotel_name }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('Address') }}</label>
                <div class="col-md-6">
                   <span class="userinfo"> {{ $user->address }}</span>
                   <span class="userinfo"> {{ $user->city }}{{ $user->state }}{{ $user->zip }}</span>
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
                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>
                <div class="col-md-6">
                    <span class="userinfo"> {{ $user->email }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Status') }}</label>
                <div class="col-md-6">
                    <span class="userinfo"><td>
                        @if(isset($user->status) && !empty($user->status))
                        {{ owner_status_array()[$user->status] }}
                        @else
                        N/A
                        @endif
                    </td></span>
                </div>
            </div>
        </div>
    </div>

    <form  class="input-form user-add" method="POST" action="{{ route('admin.admin_user_update', $user->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="col-xl-12 col-md-12 mb-4 accountinfo_title">
            <div class="row mb-3">
                <div class="col-md-4 col-form-label text-md-end">
                    <h3 class="col-form-label text-md-end">Login Information</h3>           
                </div>
                <div class="col-md-8">  
                    <button type="submit" class="btn btn-primary" id="update_password">{{ __('Update') }}</button>        
                </div>
            </div>
        </div>    
        <div class="row">
            <div class="col-xl-6 col-md-12 mb-4">          
                <div class="row mb-3">
                    <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>
                    <div class="col-md-6">
                        <span class="userinfo"> {{ $user->username }} </span>
                    </div>
                </div>
              
           </div>
            <div class="col-xl-6 col-md-12 mb-4">         
              
                <div class="row mb-3">
                    <label for="status" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="password" name="password" {{ old('password') }} required >
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                       </span>
                       @enderror
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
                {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#unitinfo">Insert </button>  --}}
                 <button type="button" class="btn btn-primary InsertUpdateunitinfo"  data-url="{{ route('admin.create_unit', $user->id) }}" >Insert </button> 
            </div>
        </div>
    </div>

     <div class="row date_mobile_section">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="service-table"> 
            <div class="div div-bordered">             

                @foreach ($units as $unit)
                @php    $unserializedbed_size = unserialize($unit->bed_size); @endphp
                <div class="services_date_detail">
                    <div class="services_date_name">
                        <div><strong>Unit # {{ $unit->name }}</strong></div>
                        <div><strong>Bedroom Type:- </strong>{{ $unit->bedroom_type }}</div>
                    </div>
                    <div class="services_date_detail_more"> 
                        <div class="services_date_detail_action" style="display: none;"> 
                            <div style="text-transform: capitalize;"><strong>Bed Size:- </strong>@if (!empty($unserializedbed_size))
                                {{ implode(', ', $unserializedbed_size) }}
                                @else
                                No data available
                            @endif</div>
                            <div style="text-transform: capitalize;"><strong>Sofa:- </strong>{{ $unit->sofa_size }}</div>
                            <div><strong>I.D.:- </strong>{{ $unit->master_code }}</div> 
                            <div><strong>Room Code Manually:- </strong>{{ $unit->room_code == 1 ? 'Yes' : 'No' }}</div> &nbsp;   

                            <div class="action">
                                <a  class="btn btn-success btn-sm mb-1 InsertUpdateunitinfo"  data-url="{{ route('admin.create_unit', [$user->id,$unit->id]) }}"><i class="fas fa-pen"></i></a>

                                <form method="post" action="{{route('unit.destroy',$unit->id)}}" class="delete-form">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm mb-1 delete-btn"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                        <span class="date_detail_more"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        {!! $units->links() !!}
    </div>
</div>

    <div class="row date_desktop_section">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="service-table"> 
                <table class="table table-bordered">                    
                    <tr>
                        <th>Unit #</th>
                        <th>Bedroom Type</th>
                        <th>Bed Size</th>
                        <th>Sofa</th>
                        <th>I.D.</th>
                        <th>Room Code Manually</th>
                        <th>Check in/out</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($units as $unit)
                    @php    $unserializedbed_size = unserialize($unit->bed_size); @endphp
                    <tr>
                        <td>{{ $unit->name }}</td>
                        <td>{{ $unit->bedroom_type }}</td>
                       <td style="text-transform: capitalize;">@if (!empty($unserializedbed_size))
                                {{ implode(', ', $unserializedbed_size) }}
                                @else
                                No data available
                            @endif</td>
                        <td style="text-transform: capitalize;">{{ $unit->sofa_size }}</td>
                        <td>{{ $unit->master_code }}</td>
                        <td>{{ $unit->room_code == 1 ? 'Yes' : 'No' }}</td>
                        <td>{{  date('h:i A', strtotime($unit->checkin)) }} / {{  date('h:i A', strtotime($unit->checkout)) }}</td>

                        <td class="action">
                            {{-- <a href="{{route('unit.show',$unit->id)}}" class="btn btn-success btn-sm mb-1"><i class="fas fa-eye"></i></a> --}}
                            <a  class="btn btn-success btn-sm mb-1 InsertUpdateunitinfo"  data-url="{{ route('admin.create_unit', [$user->id,$unit->id]) }}"><i class="fas fa-pen"></i></a>
                      {{--  <form method="post" action="{{route('unit.destroy',$unit->id)}}">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm mb-1"><i class="fas fa-trash"></i></button>
                    </form> --}}
                    <form method="post" action="{{route('unit.destroy',$unit->id)}}" class="delete-form">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm mb-1 delete-btn"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    {!! $units->links() !!}
</div>
</div>

<div class="modal fade" id="unitinfo" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="unitinfoBody">

        </div>
    </div>
</div>
</div>

<div class="modal fade" id="serviceconfirmModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="sample_form" class="form-horizontal">
                <div class="modal-body">
                    <h4 align="center" style="margin: 0;">Are you sure you want to delete this unit?</h4>
                    <p>You cannot undo this action.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>



</div>
@endsection