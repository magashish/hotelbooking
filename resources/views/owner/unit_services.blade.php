@extends('layouts.app')
@section('content')
@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif

  @include('breadcrumb.owner_breadcrumb')
  
<div class="container-fluid nss_style">
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800"><span class="rental">Rental Info </span> >> <span class="insert_dates"><a href="{{ route('owner-services.index') }}">View Dates</a></span></h1>
  </div>

  @if(!isset($id))
  <div class="row">
      <div class="col-xl-12 col-md-12 mb-4">
        <div class="row mb-3">
            <div class="col-md-4 offset-md-4 col-form-label text-md-end">
                <label for="unit_type" class="col-form-label text-md-end">{{ __('Select The Unit # to View Dates') }}</label>
                <select id="unit_type" class="form-control">
                    <option value="">Select Unit #</option>
                    @foreach(unit_type_owner_array(auth()->user()->id) as $key => $value)
                    <option value="{{ route('owner.owner_get_date', $value->id) }}" >{{ $value->name }}</option>
                    @endforeach
                </select>
                <span class="all_dates"><a href="{{ route('owner.owner_get_date', 'all') }}">View All Dates</a></span>
            </div>
            <div class="col-md-6">              
            </div>
        </div>
    </div>
</div>
@else

@foreach ($services_array as $key => $services)
<div class="row">
  <div class="col-xl-12 col-md-12 mb-4 unit_title">
    <div class="row mb-3">
        <div class="col-md-12 col-form-label text-md-end">
            <label for="unit_type" class="col-form-label text-md-end unit_title_label">{{ __('Unit #:')}}  <span class="unit_id">{{ get_unit_detail($key)->name }}</span></label> 
        </div>
        
    </div>
</div>


      <div class="col-xl-12 col-md-12 mb-4">
        <div class="row mb-3">
            <div class="col-md-4 offset-md-4 col-form-label text-md-end">
                <label for="unit_type" class="col-form-label text-md-end">{{ __('Select The Unit # to View Dates') }}</label>
                <select id="unit_type" class="form-control">
                    <option value="">Select Unit #</option>
                    @foreach(unit_type_owner_array(auth()->user()->id) as $keydata => $value)
                    <option value="{{ route('owner.owner_get_date', $value->id) }}" {{ $key == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">              
            </div>
        </div>
    </div>

<div class="col-xl-12 col-md-12 mb-4">
   @if ($services->isNotEmpty())

   <div class="date_mobile_section">
       @foreach ($services as $service)

       <div class="services_date_detail">
           <div class="services_date_name">
            <div class="guest_name">{{ $service->guest_name }}</div>
            <div class="unit"><strong>Unit# </strong>{{ $service->unit }}</div>
            <div class="unit"><strong>Early Check In </strong> {{ $service->checkin == 1 ? 'Yes' : 'No' }}</div>
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
              <a href="{{ route('owner-services.edit', $service->id) }}" class="btn btn-success btn-sm mb-1"><i class="fas fa-pen"></i></a>              
              <form method="post" action="{{ route('owner-services.destroy', $service->id) }}" class="delete-form">
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

    {!! $services->links() !!}
</div>

   <div class="date_desktop_section">
    <table class="service-table table table-bordered">
        <tr>
            <th>Guest Name</th>
            <th>Arrival Date</th>
            <th>Arrival Time</th>
            <th>Departure Date</th>
            <th>Departure Time</th>
            <th>Room Code</th>
            <th>B/B</th>
            <th class="service_notes">Notes</th>
            <th>Actions</th>
        </tr>
        @foreach ($services as $service)
        <tr>
            <td>{{ $service->guest_name }}</td>
            <td> <span class="table_arrival_departure_date_value">{{ \Carbon\Carbon::parse($service->arrival_date)->format('F d') }}</span></td>
            <td>
                {{ \Carbon\Carbon::parse($service->arrival_date)->format('h:i A') !== '12:00 AM' ? \Carbon\Carbon::parse($service->arrival_date)->format('h:i A') : '---' }}
            </td>
             <td><span class="table_arrival_departure_date_value">{{ \Carbon\Carbon::parse($service->departure_date)->format('F d') }} </span></td>
            <td>
               {{ \Carbon\Carbon::parse($service->departure_date)->format('h:i A') !== '12:00 AM' ? \Carbon\Carbon::parse($service->departure_date)->format('h:i A') : '---' }}
            </td>
            <td>{{ $service->room_code }}</td>
            <td>
                @if (!empty($service->b2b) && $service->b2b == 1)
                B/B
                @endif
            </td>
            <td class="notes">
                <div id="notes-{{ $service->id }}" class="notes-div" data-truncated-notes="{{ mb_substr($service->notes, 0, 50) }} @if (strlen($service->notes) > 50)....  @endif" data-full-notes="{{ $service->notes }}">
                    {{ mb_substr($service->notes, 0, 50) }} @if (strlen($service->notes) > 50)....  @endif 
                </div>
                @if (strlen($service->notes) > 50)
                <a href="#" class="read-more-link" data-service-id="{{ $service->id }}">Read more</a>
                @endif
            </td>
            <td class="action">
                <a href="{{ route('owner-services.edit', $service->id) }}" class="btn btn-success btn-sm mb-1"><i class="fas fa-pen"></i></a>
                <form method="post" action="{{ route('owner-services.destroy', $service->id) }}" class="delete-form">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm mb-1 delete-btn"><i class="fas fa-trash"></i></button>
                </form>
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



</div>
@endforeach
@endif
</div>

<div class="modal fade" id="serviceconfirmModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="sample_form" class="form-horizontal">
                <div class="modal-body">
                    <h4 align="center" style="margin: 0;">Are you sure you want to delete this date?</h4>
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