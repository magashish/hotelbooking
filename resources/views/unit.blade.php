@extends('layouts.app')
@section('content')
@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif
<div class="container-fluid">
    <a href="{{ route('unit.create') }}" class="btn btn-primary">Add Unit</a> 
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">All Units</h1>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="service-table"> 
            <table class="table table-bordered">                    
                <tr>
                    <th>Unit #</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                @foreach ($units as $unit)
                <tr>
                    <td>Unit {{ $unit->id }}</td>
                    <td>{{ $unit->name }}</td>
                    <td>{{  date('h:i:s A', strtotime($unit->updated_at)) }}</td>
                   
                    <td class="action">
                        {{-- <a href="{{route('unit.show',$unit->id)}}" class="btn btn-success btn-sm mb-1"><i class="fas fa-eye"></i></a> --}}
                        <a href="{{route('unit.edit',$unit->id)}}" class="btn btn-success btn-sm mb-1"><i class="fas fa-pen"></i></a>
                       <form method="post" action="{{route('unit.destroy',$unit->id)}}">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm mb-1"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
        {!! $units->links() !!}
    </div>
</div>
</div>
@endsection