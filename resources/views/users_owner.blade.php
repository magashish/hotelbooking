@extends('layouts.app')
@section('content')
@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif
<div class="container-fluid nss_style">
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <span class="rental insert_dates"><a href="{{ route('home.manage') }}">Manage</a> </span> 
        >>       
         <span class="insert_dates">Owners </span>
     </h1>
  </div>
  <div class="d-sm-flex align-items justify-content-between mb-4">
    <div></div>
    <a href="{{ route('user.ownercreate') }}" class="btn btn-primary">Insert Owner</a>
</div>

<div class="row date_mobile_section">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="service-table"> 
            <div class="user-div thead-dark div-striped display responsive">
             <div>
                @foreach ($users as $user)
                <div class="services_date_detail">
                    <div class="services_date_name">
                        <div><strong>{{ $user->name }}</strong></div>
                        <div>{{ count(unit_type_owner_array($user->id)) }}</div>
                        <div>{{ $user->hotel_name }}</div>
                        <div>{{ $user->address }} {{ $user->city }} {{ $user->state }} {{ $user->zip }}</div>
                    </div>
                    <div class="services_date_detail_more"> 
                        <div class="services_date_detail_action" style="display: none;"> 
                           <div>{{ $user->email }}</div>
                            <div>{{ $user->phone }}</div>
                            <div>
                                @if(isset($user->status) && !empty($user->status))
                                {{ owner_status_array()[$user->status] }}
                                @else
                                N/A
                                @endif
                            </div>
                            <div class="action">
                              <a href="{{route('user.ownershow',$user->id)}}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
                              {{-- <a href="{{route('user.owner_unit',$user->id)}}" class="btn btn-success btn-sm">Units</a>  --}}
                              <form method="post" action="{{route('user.destroy',$user->id)}}" class="delete-form">
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
</div>
{!! $users->links() !!}
</div>
</div>


<div class="row date_desktop_section">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="service-table"> 
            <table class="table thead-dark table-striped display responsive" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Total Unit</th>
                        <th>Hotel Name</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ count(unit_type_owner_array($user->id)) }}</td>
                        <td>{{ $user->hotel_name }}</td>
                        <td>{{ $user->address }} {{ $user->city }} {{ $user->state }} {{ $user->zip }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>
                            @if(isset($user->status) && !empty($user->status))
                            {{ owner_status_array()[$user->status] }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td class="action">
                          <a href="{{route('user.ownershow',$user->id)}}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
                          {{-- <a href="{{route('user.owner_unit',$user->id)}}" class="btn btn-success btn-sm">Units</a>  --}}
                          <form method="post" action="{{route('user.destroy',$user->id)}}" class="delete-form">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm mb-1 delete-btn"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {!! $users->links() !!}
</div>
</div>
</div>

<div class="modal fade" id="serviceconfirmModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="sample_form" class="form-horizontal">
                <div class="modal-body">
                    <h4 align="center" style="margin: 0;">Are you sure you want to delete this user?</h4>
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
@endsection