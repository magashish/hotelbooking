@extends('layouts.app')
@section('content')
@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif
<div class="container-fluid">
    <a style="float: right;" href="{{ route('user.create') }}" class="btn btn-primary">Add User</a> 
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">All Users</h1>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="service-table"> 
            <table class="table thead-dark table-striped ">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    {{--<th>Password</th>--}}
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    {{--<td>{{ $user->password }}</td>--}}
                    <td>{{  date('d F Y, h:i:s A', strtotime($user->created_at)) }}</td>
                    <td class="action"> <a href="{{route('user.edit',$user->id)}}" class="btn btn-success btn-sm"><i class="fas fa-pen"></i></a>
                       <form method="post" action="{{route('user.destroy',$user->id)}}">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm mb-1"><i class="fas fa-trash"></i></button>
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
@endsection