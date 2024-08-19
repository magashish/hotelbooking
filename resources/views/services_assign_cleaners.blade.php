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
          <h1 class="h3 mb-0 text-gray-800">
            <span class="rental insert_dates"><a href="{{ route('assigncleaner.index') }}">Assign Cleaner </a></span>
            >> 
            <span class="insert_dates"><a href="{{ route('services.services_assigncleaners') }}">View All</a></span></h1>
        </div>

        <div class="row">
          <div class="col-xl-12 col-md-12 mb-4">
            <div class="row mb-3">
                <div class="col-md-4 offset-md-4 col-form-label text-md-end">
                    <label for="unit_type" class="col-form-label text-md-end">{{ __('Select The Unit # to Assign Cleaners') }}</label>
                    <select id="unit_type" class="form-control">
                        <option value="{{ route('services.services_assigncleaners') }}">Select Unit #</option>
                        @foreach(unit_type_array() as $key => $value)
                        <option value="{{ route('services.services_assigncleaners', $value->id) }}" {{ $id == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                        @endforeach
                    </select>
                    <span class="all_dates"><a href="{{ route('services.services_calendar') }}">View Calendar</a></span>


                    <form class="form_top_sec">
                        <input class="form-control" type="date" id="start_date" name="start_date" value="{{ $startDate_data }}" required>
                        <input class="form-control" type="date" id="end_date" name="end_date" value="{{ $endDate_data }}" required>
                        <input type="submit" value="Serach">
                    </form> 
                    @if($print_search)
                    @if($services->isNotEmpty())
                    <span class="print_all_dates"> <a type="button" onclick="printDiv('printableArea')">Print Date</a></span>
                    @endif
                    @endif

                </div>
                <div class="col-md-6">              
                </div>
            </div>
        </div>
    </div>



    <div class="col-xl-12 col-md-12 mb-4">
       @if ($services->isNotEmpty())

       <div class="date_mobile_section">
           @foreach ($services as $service)
           <div class="services_date_detail">


              <div class="services_date_name">
                <div class="guest_name">Unit {{ get_unit_detail($service->unit)->name }}</div>
                <div class="arrival_date"> <strong>Arrival Date Time </strong> <span class="arrival_departure_date_value"> {{ \Carbon\Carbon::parse($service->arrival_date)->format('F d') }}
                 {{ \Carbon\Carbon::parse($service->arrival_date)->format('h:i A') !== '12:00 AM' ? \Carbon\Carbon::parse($service->arrival_date)->format('h:i A') : '' }}

             </span>
         </div>
         <div class="departure_date"><strong>Departure Date Time </strong> <span class="arrival_departure_date_value">  {{ \Carbon\Carbon::parse($service->departure_date)->format('F d') }}
           {{ \Carbon\Carbon::parse($service->departure_date)->format('h:i A') !== '12:00 AM' ? \Carbon\Carbon::parse($service->departure_date)->format('h:i A') : '' }}
       </span>
   </div>
</div>

<div class="services_date_detail_more"> 
 <div class="services_date_detail_action" style="display: none;">       
    <div><strong>Old Code</strong> {{ $service->old_room_code }} </div>      
    <div><strong>I.D.</strong> {{ get_unit_detail($service->unit)->master_code }}</div>
    <div><strong>New Code</strong> {{ $service->room_code }}</div>
    <div><strong>Bed</strong> @if (!empty($unserializedbed_size))
        {{ implode(', ', $unserializedbed_size) }}
        @else
        No data available
    @endif</div>
    <div><strong>Sofa </strong>{{ get_unit_detail($service->unit)->sofa_size }}</div>
    <div><strong>Notes </strong> {{ $service->notes }}</div> 
    <div class="action">
     <button type="button" data-url="{{route('services.assigncleaner',[$service->id])}}" class="btn btn-success mb-1 assign_cleaners"><i class="fas fa-plus"></i></button> 
 </div>
</div>
<span class="date_detail_more"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>

</div>

</div>
@endforeach
</div>

<div class="date_desktop_section service-table">
    <div class="result_date_desktop_section">
       @if ($checkin_data !== null)
       <div>
        <p>TOTAL Checkins: {{ $checkin_data }}</p>
    </div>
    @endif

    <!-- Display checkout_data if not null -->
    @if ($checkout_data !== null)
    <div>
        <p>TOTAL Checkouts: {{ $checkout_data }}</p>
    </div>
    @endif

    @if ($bb_data !== null)
    <div>
        <p>TOTAL Back-To-Back: {{ $bb_data }}</p>
    </div>
    @endif

</div>
<table class="service-table table table-bordered">
    <tr>
        <th>Unit #</th>
        <th>Bedroom Type</th>
        <th>Arrival Date</th>
        <th>Arrival Time</th>
        <th>Departure Date</th>
        <th>Departure Time</th>
        <th>I.D</th>
        <th>B/B</th>
        <th>Room Code</th>
        <th>Runner</th>
        <th>Cleaner</th>
        <th>Cleaner Carry Over Date</th>
        <th>Actions</th>
    </tr>
    @foreach ($services as $service)
    <tr>
        <td>{{ get_unit_detail($service->unit)->name }}</td>
        <td>{{ get_unit_detail($service->unit)->bedroom_type }}</td>
        <td> <span class="table_arrival_departure_date_value">{{ \Carbon\Carbon::parse($service->arrival_date)->format('F d') }} </span></td>
        <td>
            {{ \Carbon\Carbon::parse($service->arrival_date)->format('h:i A') !== '12:00 AM' ? \Carbon\Carbon::parse($service->arrival_date)->format('h:i A') : '---' }}
        </td>
        <td><span class="table_arrival_departure_date_value">{{ \Carbon\Carbon::parse($service->departure_date)->format('F d') }} </span></td>
        <td>
           {{ \Carbon\Carbon::parse($service->departure_date)->format('h:i A') !== '12:00 AM' ? \Carbon\Carbon::parse($service->departure_date)->format('h:i A') : '---' }}
       </td>
       <td>{{ get_unit_detail($service->unit)->master_code }}</td>
       <td class="text_red">{{ $service->b2b == 1 ? 'B/B' : '' }}</td>
       <td>{{ $service->room_code }}</td>          
       <td>{{ isset($service->runner) ? (isset(get_userdata($service->runner)->name) ? get_userdata($service->runner)->name : 'N/A') : 'N/A' }}</td>
       <td>{{ isset($service->cleaner) ? (isset(get_userdata($service->cleaner)->name) ? get_userdata($service->cleaner)->name : 'N/A') : 'N/A' }}</td>
       <td> {{ !empty($service->carry_over_date) ? \Carbon\Carbon::parse($service->carry_over_date)->format('F d') : '' }}</td>



       <td class="action">
           <button type="button" data-url="{{route('services.assigncleaner',[$service->id])}}" class="btn btn-success mb-1 assign_cleaners"><i class="fas fa-plus"></i></button>       
       </td>

   </tr>
   @endforeach
</table>
</div>


@else
<p>No dates are available for this unit right now.</p>
@endif
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
</div>





@if($services->isNotEmpty())
<div class="date_desktop_section service-table" id="printableArea" style="display:none">
    <div class="result_date_desktop_section">
        <table>
            <tr>         

               @if ($checkin_data !== null)
               <td>TOTAL Checkins: {{ $checkin_data }}</td>
               @endif

               <!-- Display checkout_data if not null -->
               @if ($checkout_data !== null)
               <td>TOTAL Checkouts: {{ $checkout_data }}</td>
               @endif

               @if ($bb_data !== null)
               <td>TOTAL Back-To-Back: {{ $bb_data }} </td>
               @endif
           </tr>
       </table>

   </div>


   <table class="service-table table table-bordered">
    <tr>
        <th>Unit #</th>
        <th>Bedroom Type</th>
        <th>Arrival Date</th>
        <th>Arrival Time</th>
        <th>Departure Date</th>
        <th>Departure Time</th>
        <th>I.D</th>
        <th>B/B</th>
        <th>Room Code</th>
        <th>Runner</th>
        <th>Cleaner</th>
    </tr>
    @foreach ($services as $service)
    <tr>
        <td>{{ get_unit_detail($service->unit)->name }}</td>
        <td>{{ get_unit_detail($service->unit)->bedroom_type }}</td>
        <td><span class="table_arrival_departure_date_value">{{ \Carbon\Carbon::parse($service->arrival_date)->format('F d') }}</span></td>
        <td>
            {{ \Carbon\Carbon::parse($service->arrival_date)->format('h:i A') !== '12:00 AM' ? \Carbon\Carbon::parse($service->arrival_date)->format('h:i A') : '---' }}
        </td>
        <td><span class="table_arrival_departure_date_value">{{ \Carbon\Carbon::parse($service->departure_date)->format('F d') }}</span></td>
        <td>
           {{ \Carbon\Carbon::parse($service->departure_date)->format('h:i A') !== '12:00 AM' ? \Carbon\Carbon::parse($service->departure_date)->format('h:i A') : '---' }}
       </td>
       <td>{{ get_unit_detail($service->unit)->master_code }}</td>
       <td class="text_red">{{ $service->b2b == 1 ? 'B/B' : '' }}</td>
       <td>{{ $service->room_code }}</td>          
       <td>{{ isset($service->runner) ? (isset(get_userdata($service->runner)->name) ? get_userdata($service->runner)->name : 'N/A') : 'N/A' }}</td>
       <td>{{ isset($service->cleaner) ? (isset(get_userdata($service->cleaner)->name) ? get_userdata($service->cleaner)->name : 'N/A') : 'N/A' }}</td>
   </tr>
   @endforeach
</table>
</div>
@endif



<script type="text/javascript">
    $(document).ready(function() {
        $('form').on('submit', function(e) {
            var startDate = new Date($('#start_date').val());
            var endDate = new Date($('#end_date').val());

            if (startDate > endDate) {
                alert('End date must be greater than or equal to the start date.');
                e.preventDefault(); 
            }
        });
    });
</script>


<script type="text/javascript">
    function printDiv(divId) {
        var printContents = $('#' + divId).html(); 
        var originalContents = $('body').html(); 
        $('body').html(printContents); 
        window.print();
        $('body').html(originalContents); 
    }
</script>



@endsection