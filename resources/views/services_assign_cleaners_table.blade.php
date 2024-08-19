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
       <h1 class="h3 mb-0 text-gray-800"><span class="insert_dates"><a href="{{ route('assigncleaner.index') }}">Assign Cleaner</a></span></h1> 
   </div>


   <div class="row">
      <div class="col-xl-12 col-md-12 mb-4">
        <form class="service-assigncleaner"  action="{{ route('assigncleaner.index') }}" method="GET"  enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col-md-4 offset-md-4 col-form-label text-md-end">
                    <label for="unit_type" class="col-form-label text-md-end">{{ __('Select The Date to View Cleaner') }}</label>
                    <input class="form-control" type="date" name="dateInput" id="dateInput" value="{{$currentDate}}">
                    <span class="all_dates"><a href="{{ route('services.services_assigncleaners') }}">View All Assign Cleaner</a></span>
                </div>
                <div class="col-md-6">              
                </div>
            </div>
        </form>

    </div>
</div>




<div class="col-xl-12 col-md-12 mb-4">
    <div class="date_mobile_section">
        <div>
            <div><strong>C/OUTS</strong></div>
        </div>

        @if ($servicesout->isNotEmpty())
        @foreach ($servicesout as $service)
        @php    $unserializedbed_size = unserialize(get_unit_detail($service->unit)->bed_size); @endphp
        <div class="services_date_detail">
          <div class="services_date_name">
            <div class="guest_name">Unit {{ $service->unit }}</div>
            <div><strong> Date </strong> <span class="arrival_departure_date_value"> {{ \Carbon\Carbon::parse($service->departure_date)->format('F d') }}</span></div>
            <div><strong>Time Out</strong> {{ \Carbon\Carbon::parse($service->departure_date)->format('h:i A') !== '12:00 AM' ? \Carbon\Carbon::parse($service->departure_date)->format('h:i A') : '---' }}</div>
            <div><strong>B/B </strong> <span class="text_red">{{ $service->b2b == 1 ? 'B/B' : '' }}</span></div>   
        </div>
        <div class="services_date_detail_more"> 
         <div class="services_date_detail_action" style="display: none;"> 
          <div><strong>Old Code</strong> {{ $service->old_room_code }} </div>      
          <div><strong>I.D.</strong> {{ get_unit_detail($service->unit)->master_code }}</div>
          {{-- <div><strong>New Code</strong> {{ $service->room_code }}</div> --}}
          <div><strong>Bed</strong> @if (!empty($unserializedbed_size))
            {{ implode(', ', $unserializedbed_size) }}
            @else
            No data available
        @endif</div>
        <div><strong>Sofa </strong>{{ get_unit_detail($service->unit)->sofa_size }}</div>
        <div><strong>Notes </strong> {{ $service->notes }}</div>      
        <form class="input-form service-edit-mobile"  method="POST" action="{{ route('services.update', $service->id) }}" enctype="multipart/form-data">
         @csrf
         @method('PUT')
         <input type="hidden" name="check" value="assigncleaner">
         <div class="row mb-3">
            <label for="name" class="col-md-2 col-form-label text-md-end">{{ __('Runner') }}</label>
            <div class="col-md-10">
              <select id="runner" name="runner" class="form-control" tabindex="-1" aria-hidden="true">
                <option value="">Select Runner</option>
                @foreach (get_cleaner_Users() as $key => $user)
                <option value="{{ $user->id }}" @if($service->runner == $user->id) selected @endif>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <label for="name" class="col-md-2 col-form-label text-md-end">{{ __('Cleaner') }}</label>
        <div class="col-md-10">
         <select id="cleaner" name="cleaner" class="form-control" tabindex="-1" aria-hidden="true">
            <option value="">Select Cleaner</option>
            @foreach (get_cleaner_Users() as $key => $user)
            <option value="{{ $user->id }}" @if($service->cleaner == $user->id) selected @endif>{{ $user->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row mb-3">
    <label for="name" class="col-md-2 col-form-label text-md-end">{{ __('   Cleaner Carry Over Date') }}</label>
    <div class="col-md-10">
     <input type="date" class="form-control carry_over_date" name="carry_over_date" value="{{ $service->carry_over_date; }}">
 </div>
</div>
<div class="action">
 <button type="submit" class="btn btn-success">Save</button>     
</div> 
</form> 
</div>
<span class="date_detail_more"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
</div>
</div>
@endforeach
@else
<p>No dates are available right now.</p>
@endif

<div>
    <div><strong>C/IN</strong></div>
</div>
 @if ($servicesin->isNotEmpty())
@foreach ($servicesin as $service)
@php    $unserializedbed_size = unserialize(get_unit_detail($service->unit)->bed_size); @endphp
<div class="services_date_detail">
  <div class="services_date_name">
    <div class="guest_name">Unit {{ $service->unit }}</div>
    <div><strong> Date </strong> <span class="arrival_departure_date_value"> {{ \Carbon\Carbon::parse($service->arrival_date)->format('F d') }}</span></div>
    <div><strong>Time In</strong> {{ \Carbon\Carbon::parse($service->arrival_date)->format('h:i A') !== '12:00 AM' ? \Carbon\Carbon::parse($service->arrival_date)->format('h:i A') : '---' }}</div>
    <div><strong>B/B </strong><span class="text_red">{{ $service->b2b == 1 ? 'B/B' : '' }}</span></div>   
</div>
<div class="services_date_detail_more"> 
 <div class="services_date_detail_action" style="display: none;"> 
  <div><strong>I.D.</strong> {{ get_unit_detail($service->unit)->master_code }}</div>
  <div><strong>New Code</strong> {{ $service->room_code }}</div>
  <div><strong>Bed</strong> @if (!empty($unserializedbed_size))
    {{ implode(', ', $unserializedbed_size) }}
    @else
    No data available
@endif</div>
<div><strong>Sofa </strong>{{ get_unit_detail($service->unit)->sofa_size }}</div>
<div><strong>Notes </strong> {{ $service->notes }}</div>      
{{-- <form class="input-form service-edit-mobile"  method="POST" action="{{ route('services.update', $service->id) }}" enctype="multipart/form-data">
 @csrf
 @method('PUT')
 <input type="hidden" name="check" value="assigncleaner">
 <div class="row mb-3">
    <label for="name" class="col-md-2 col-form-label text-md-end">{{ __('Runner') }}</label>
    <div class="col-md-10">
      <select id="runner" name="runner" class="form-control" tabindex="-1" aria-hidden="true">
        <option value="">Select Runner</option>
        @foreach (get_cleaner_Users() as $key => $user)
        <option value="{{ $user->id }}" @if($service->runner == $user->id) selected @endif>{{ $user->name }}</option>
        @endforeach
    </select>
</div>
</div>
<div class="row mb-3">
    <label for="name" class="col-md-2 col-form-label text-md-end">{{ __('Cleaner') }}</label>
    <div class="col-md-10">
     <select id="cleaner" name="cleaner" class="form-control" tabindex="-1" aria-hidden="true">
        <option value="">Select Cleaner</option>
        @foreach (get_cleaner_Users() as $key => $user)
        <option value="{{ $user->id }}" @if($service->cleaner == $user->id) selected @endif>{{ $user->name }}</option>
        @endforeach
    </select>
</div>
</div>
<div class="row mb-3">
    <label for="name" class="col-md-2 col-form-label text-md-end">{{ __('Cleaner Carry Over Date') }}</label>
    <div class="col-md-10">
     <input type="date" class="form-control carry_over_date" name="carry_over_date" value="{{ $service->carry_over_date; }}">
 </div>
</div>
<div class="action">
 <button type="submit" class="btn btn-success">Save</button>     
</div> 
</form> --}} 
</div>
<span class="date_detail_more"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
</div>
</div>
@endforeach
@else
<p>No dates are available right now.</p>
@endif
</div>
</div>








<div class="col-xl-12 col-md-12 mb-4">
    <div class="date_desktop_section service-table">
        <table class="service-table table table-bordered">
            <tr>
                <th>Unit</th>
                <th>Date</th>
                <th>Time Out</th>
                <th>B/B</th>
                <th>Old Code</th>
                <th>I.D.</th>
                <th>New Code</th>                
                <th>Bed</th>
                <th>Sofa</th>
                <th>Runner</th>
                <th>Cleaner</th>
                <th>Cleaner Carry Over Date</th>
                <th class="service_notes">Notes</th>  
                <th>Action</th>        
            </tr>
            <tr>
                <td colspan="13">C/OUTS</td>
            </tr>
            @foreach ($servicesout as $service)
            @php    $unserializedbed_size = unserialize(get_unit_detail($service->unit)->bed_size); @endphp
            <tr class="td_service_{{ $service->id }}">
               <form class="input-form service-add"  method="POST" action="{{ route('services.update', $service->id) }}" enctype="multipart/form-data">
                 @csrf
                 @method('PUT')
                 <input type="hidden" name="check" value="assigncleaner">
                 <td>{{ $service->unit }}</td>
                 <td><span class="table_arrival_departure_date_value">{{ \Carbon\Carbon::parse($service->departure_date)->format('F d') }}</span></td>
                 <td>{{ \Carbon\Carbon::parse($service->departure_date)->format('h:i A') !== '12:00 AM' ? \Carbon\Carbon::parse($service->departure_date)->format('h:i A') : '---' }}</td>           
                 <td class="text_red">{{ $service->b2b == 1 ? 'B/B' : '' }}</td>
                 <td>{{ $service->old_room_code }}</td> 
                 <td>{{ get_unit_detail($service->unit)->master_code }} </td>      
                 <td>
                   {{--  {{ $service->room_code }} --}}
                </td>

                
            <td style="text-transform: capitalize;">@if (!empty($unserializedbed_size))
                {{ implode(', ', $unserializedbed_size) }}
                @else
                No data available
            @endif</td>
            <td style="text-transform: capitalize;">{{ get_unit_detail($service->unit)->sofa_size }}</td>
             <td>
                   <select id="runner" name="runner" class="form-control" tabindex="-1" aria-hidden="true">
                    <option value="">Select Runner</option>
                    @foreach (get_cleaner_Users() as $key => $user)
                    <option value="{{ $user->id }}" @if($service->runner == $user->id) selected @endif>{{ $user->name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select id="cleaner" name="cleaner" class="form-control" tabindex="-1" aria-hidden="true">
                    <option value="">Select Cleaner</option>
                    @foreach (get_cleaner_Users() as $key => $user)
                    <option value="{{ $user->id }}" @if($service->cleaner == $user->id) selected @endif>{{ $user->name }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="date" class="form-control carry_over_date" name="carry_over_date" value="{{ $service->carry_over_date; }}"></td>

            <td class="notes">
                <div id="notes-{{ $service->id }}" class="notes-div" data-truncated-notes="{{ mb_substr($service->notes, 0, 50) }} @if (strlen($service->notes) > 50)....  @endif" data-full-notes="{{ $service->notes }}">
                    {{ mb_substr($service->notes, 0, 50) }} @if (strlen($service->notes) > 50)....  @endif 
                </div>
                @if (strlen($service->notes) > 50)
                <a href="#" class="read-more-link" data-service-id="{{ $service->id }}">Read more</a>
                @endif
            </td>
            <td class="action">
             <button type="submit" class="btn btn-success">Save</button>     
         </td> 
     </form>       

 </tr>
 @endforeach
 <tr>
    <td colspan="13">C/IN</td>
</tr>
@foreach ($servicesin as $service)
@php    $unserializedbed_size = unserialize(get_unit_detail($service->unit)->bed_size); @endphp
<tr class="td_service_{{ $service->id }}">
    <form class="input-form service-add"  method="POST" action="{{ route('services.update', $service->id) }}" enctype="multipart/form-data">
     @csrf
     @method('PUT')
     <input type="hidden" name="check" value="assigncleaner">
     <td>{{ $service->unit }}</td>
     <td><span class="table_arrival_departure_date_value">{{ \Carbon\Carbon::parse($service->arrival_date)->format('F d') }}</td>
     <td>{{ \Carbon\Carbon::parse($service->arrival_date)->format('h:i A') !== '12:00 AM' ? \Carbon\Carbon::parse($service->arrival_date)->format('h:i A') : '---' }}</td>           
     <td class="text_red">{{ $service->b2b == 1 ? 'B/B' : '' }}</td>
     <td>{{-- {{ $service->old_room_code }} --}}</td> 
     <td>{{ get_unit_detail($service->unit)->master_code }}  </td>      
     <td>{{ $service->room_code }}</td>
    
<td style="text-transform: capitalize;">@if (!empty($unserializedbed_size))
    {{ implode(', ', $unserializedbed_size) }}
    @else
    No data available
@endif</td>
<td style="text-transform: capitalize;">{{ get_unit_detail($service->unit)->sofa_size }}</td>
 <td>
      {{--  <select id="runner" name="runner" class="form-control" tabindex="-1" aria-hidden="true">
        <option value="">Select Runner</option>
        @foreach (get_cleaner_Users() as $key => $user)
        <option value="{{ $user->id }}" @if($service->runner == $user->id) selected @endif>{{ $user->name }}</option>
        @endforeach
    </select> --}}
</td>
<td>
    {{-- <select id="cleaner" name="cleaner" class="form-control" tabindex="-1" aria-hidden="true">
        <option value="">Select Cleaner</option>
        @foreach (get_cleaner_Users() as $key => $user)
        <option value="{{ $user->id }}" @if($service->cleaner == $user->id) selected @endif>{{ $user->name }}</option>
        @endforeach
    </select> --}}
</td>
<td>
    {{-- <input type="date" class="form-control carry_over_date" name="carry_over_date" value="{{ $service->carry_over_date; }}"> --}}
</td>
<td class="notes">
    <div id="notes-in-{{ $service->id }}" class="notes-div" data-truncated-notes="{{ mb_substr($service->notes, 0, 50) }} @if (strlen($service->notes) > 50)....  @endif" data-full-notes="{{ $service->notes }}">
        {{ mb_substr($service->notes, 0, 50) }} @if (strlen($service->notes) > 50)....  @endif 
    </div>
    @if (strlen($service->notes) > 50)
    <a href="#" class="read-more-link-in" data-service-id="{{ $service->id }}">Read more</a>
    @endif
</td>  
<td class="action">
  {{-- <button type="submit" class="btn btn-success">Save</button>             --}}
</td>  
</form>   

</tr>
@endforeach
</table>
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

</div>
@endsection