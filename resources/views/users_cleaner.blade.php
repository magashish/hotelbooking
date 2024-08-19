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
         <span class="insert_dates">Cleaners </span>
     </h1>
  </div>
  <div class="d-sm-flex align-items justify-content-end mr-2 mb-4">
    <div></div>
    <a href="{{ route('user.cleanercreate') }}" class="btn btn-primary  mr-2">Add Cleaner</a> 
    <a href="{{ route('assigncleaner.index') }}" class="btn btn-primary ">Assign Cleaners</a> 
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
                        <div>{{ $user->address }} {{ $user->city }} {{ $user->state }} {{ $user->zip }}</div>
                    </div>
                    <div class="services_date_detail_more"> 
                        <div class="services_date_detail_action" style="display: none;"> 
                         <div>{{ $user->email }}</div>
                         <div>{{ $user->phone }}</div>
                         <div>
                             @if(isset($user->status) && !empty($user->status))
                             {{ cleaner_status_array()[$user->status] }}
                             @else
                             N/A
                             @endif
                         </div>
                         <div class="action">
                          <a  class="btn btn-success btn-sm InsertUpdateunitinfo"  data-url="{{route('user.editcleaner',$user->id)}}"><i class="fas fa-pen"></i></a>
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
            <table class="table thead-dark table-striped ">
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->address }} {{ $user->city }} {{ $user->state }} {{ $user->zip }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>
                        @if(isset($user->status) && !empty($user->status))
                        {{ cleaner_status_array()[$user->status] }}
                        @else
                        N/A
                        @endif
                    </td>
                    <td class="action">
                        <a  class="btn btn-success btn-sm InsertUpdateunitinfo"  data-url="{{route('user.editcleaner',$user->id)}}"><i class="fas fa-pen"></i></a>
                        <form method="post" action="{{route('user.destroy',$user->id)}}" class="delete-form">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm mb-1 delete-btn"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        {!! $users->links() !!}
    </div>
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