@extends('layouts.app')
@section('content')
@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif
<div class="container-fluid">

    <div class="container-fluid nss_style">
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800"><span class="rental insert_dates"><a href="{{ route('home.manage') }}">Manage</a> </span> >> <span class="insert_dates"><a href="{{ route('services.index') }}">View Old Dates</a></span></h1>
  </div>

  <div class="row">
      <div class="col-xl-12 col-md-12 mb-4">
        <div class="row mb-3">
            <div class="col-md-4 offset-md-4 col-form-label text-md-end">
                <label for="unit_type" class="col-form-label text-md-end">{{ __('Select The Unit # to View Dates') }}</label>
                <select id="unit_type" class="form-control">
                    <option value="{{ route('admin.get_old_services') }}">Select Unit #</option>
                    @foreach(unit_type_array() as $key => $value)
                    <option value="{{ route('admin.get_old_services_by_unit', $value->id) }}" {{ $id == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                    @endforeach
                </select>
                <span class="all_dates"><a href="{{ route('admin.get_old_services') }}">View All Old Dates</a></span>
            </div>
            <div class="col-md-6">              
            </div>
        </div>
    </div>
</div>
<div class="d-sm-flex align-items justify-content-end mr-2 mb-4">
    <div></div>
    <div><a href="{{ route('services.create') }}" class="btn btn-primary">Insert Dates</a></div>
</div>



<div class="col-xl-12 col-md-12 mb-4">
 @if ($services->isNotEmpty())

 <div class="date_mobile_section">
     @foreach ($services as $service)
     <div class="services_date_detail">
       
        
        <div class="services_date_name">
            <div class="guest_name">{{ $service->guest_name }}</div>
            <div class="unit"><strong>Unit# </strong>{{ get_unit_detail($service->unit)->name }}</div>
            <div class="unit"><strong>Early Check In </strong>{{ $service->checkin == 1 ? 'Yes' : 'No' }}</div>
            <div class="arrival_date"> <strong>Arrival Date </strong> <span class="arrival_departure_date_value"> {{ \Carbon\Carbon::parse($service->arrival_date)->format('F d') }}
               {{ \Carbon\Carbon::parse($service->arrival_date)->format('h:i A') !== '12:00 AM' ? \Carbon\Carbon::parse($service->arrival_date)->format('h:i A') : '' }}

               </span>
            </div>
            <div class="unit"><strong>Late Departure </strong>{{ $service->checkout == 1 ? 'Yes' : 'No' }}</div>
            <div class="departure_date"><strong>Departure Date </strong> <span class="arrival_departure_date_value">  {{ \Carbon\Carbon::parse($service->departure_date)->format('F d') }}
                 {{ \Carbon\Carbon::parse($service->departure_date)->format('h:i A') !== '12:00 AM' ? \Carbon\Carbon::parse($service->departure_date)->format('h:i A') : '' }}
             </span>
            </div>
        </div>

        <div class="services_date_detail_more"> 
           <div class="services_date_detail_action" style="display: none;">       
            <div><strong>Room Code </strong> {{ $service->room_code }}</div> 
            <div><strong>Notes </strong> {{ $service->notes }}</div>&nbsp;         
            
             <div class="action">
               <span service-id="{{ $service->id }}" class="btn btn-success btn-sm mb-1 service-show"><i class="fas fa-eye"></i></span>
               {{-- <form method="post" action="{{route('services.destroy',$service->id)}}">
                @method('delete')
                @csrf
                <button type="submit" class="btn btn-danger btn-sm mb-1"><i class="fas fa-trash"></i></button>
            </form> --}}
        </div>
    </div>
    <span class="date_detail_more"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>

</div>

</div>
@endforeach
{!! $services->links() !!}
</div>

<div class="date_desktop_section service-table">
    <table class="service-table table table-bordered">
        <tr>
            <th>Unit #</th>
            <th>Guest Name</th>
            <th>Arrival Date</th>
            <th>Early Check In</th>
            <th>Arrival Time</th>
            <th>Departure Date</th>
            <th>Late Departure</th>
            <th>Departure Time</th>
            <th>Room Code</th>
            <th>B/B</th>
            <th>Cleaner Carry Over Date</th>
            <th class="service_notes">Notes</th>
             <th>Actions</th>
        </tr>
        @foreach ($services as $service)
        <tr>
            <td>{{ get_unit_detail($service->unit)->name }}</td>
            <td>{{ $service->guest_name }}</td>
            <td> <span class="table_arrival_departure_date_value">{{ \Carbon\Carbon::parse($service->arrival_date)->format('F d') }}</span></td>
            <td>{{ $service->checkin == 1 ? 'Yes' : 'No' }}</td>
            <td>
                {{ \Carbon\Carbon::parse($service->arrival_date)->format('h:i A') !== '12:00 AM' ? \Carbon\Carbon::parse($service->arrival_date)->format('h:i A') : '---' }}
            </td>
            <td><span class="table_arrival_departure_date_value">{{ \Carbon\Carbon::parse($service->departure_date)->format('F d') }} </span></td>
            <td>{{ $service->checkout == 1 ? 'Yes' : 'No' }}</td>
            <td>
               {{ \Carbon\Carbon::parse($service->departure_date)->format('h:i A') !== '12:00 AM' ? \Carbon\Carbon::parse($service->departure_date)->format('h:i A') : '---' }}
            </td>
            <td>{{ $service->room_code }}</td>
            <td class="text_red">{{ $service->b2b == 1 ? 'B/B' : '' }}</td>
            <td>  {{ !empty($service->carry_over_date) ? \Carbon\Carbon::parse($service->carry_over_date)->format('F d Y') : '---' }} </td>
            <td class="notes">
                <div id="notes-{{ $service->id }}" class="notes-div" data-truncated-notes="{{ mb_substr($service->notes, 0, 50) }} @if (strlen($service->notes) > 50)....  @endif" data-full-notes="{{ $service->notes }}">
                    {{ mb_substr($service->notes, 0, 50) }} @if (strlen($service->notes) > 50)....  @endif 
                </div>
                @if (strlen($service->notes) > 50)
                <a href="#" class="read-more-link" data-service-id="{{ $service->id }}">Read more</a>
                @endif
            </td>
             <td class="action">
                <span service-id="{{ $service->id }}" class="btn btn-success btn-sm mb-1 service-show"><i class="fas fa-eye"></i></span>                
            </td>
            
        </tr>
        @endforeach
    </table>
    {!! $services->links() !!}
</div>
@else
<p>No dates are available for this unit right now.</p>
@endif
</div>


<div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="mediumBody">
                <div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
@endsection