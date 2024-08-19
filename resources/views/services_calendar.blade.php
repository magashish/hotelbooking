@extends('layouts.app')
@section('content')
@if (session('status'))
<div class="alert alert-success" role="alert">
  {{ session('status') }}
</div>
@endif

<div class="container-fluid nss_style">  
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><span class="rental">Rental Calendar </span></h1>
  </div>

  <div class="mb-4">
    <a href="{{ route('services.create') }}" class="btn btn-primary">Add Date</a> 
    <a href="{{ route('assigncleaner.index') }}" class="btn btn-primary">Assign Cleaner</a> 
  </div>

  <div class="d-sm-flex justify-content-between mb-4">
    <h2 class="h3 mb-0 text-gray-800">All Dates</h2>
  </div>

  <div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
      <div class="container-fluid">
        <div id='calendar'></div>
      </div>

      <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
      aria-hidden="true">
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

    <script type="text/javascript">
     document.addEventListener('DOMContentLoaded', function() {
      var currentDate = new Date().toISOString().split('T')[0];
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
        headerToolbar: {
          left: 'prev,next',
          center: 'title',
          right: 'resourceTimelineDay,resourceTimelineWeek,resourceTimelineMonth'
        },
        views: {
          resourceTimelineMonth: {
            slotLabelFormat: [
              {day: 'numeric'},
              {hour: 'numeric'},
              ],
            slotLabelInterval: {hours: 1},
            slotMinWidth: 5,
            eventMinWidth: 5,
            slotLabelContent: function(arg) {
              return arg.date.toLocaleDateString('en-US', {
                day: '2-digit'
              }) + ' ' + arg.date.toLocaleDateString('en-US', { weekday: 'short' });
            }
          }
        },

        displayEventTime: false,    
        aspectRatio: 1.5,
        initialView: 'resourceTimelineMonth',
        initialDate: currentDate,
        eventColor: '#028695',
        resourceAreaWidth: '10%',
        height: 650,
        resourceAreaColumns: [{
          field: 'title',
          headerContent: 'Unit#',
        }],
        resources: <?php echo $resources_json; ?>,
        events: <?php echo $events_json; ?>,
        eventClick: function(info) {
          $('#mediumModal').modal('show');
          $.ajax({
            url: '/service/calendar/edit/' + info.event.id,
            success: function(response) {
              $('#mediumBody').html(response).show();
            }
          });
        },
        eventDidMount: function(info) {
          var tooltip = new Tooltip(info.el, {
            title: "<div class='custom-tooltip'><div><strong>Unit:</strong> " + info.event.extendedProps.unitid + "</div><div><strong>Arrival Info:</strong> " + info.event.extendedProps.arrival_date + "</div><div><strong>Departure Info:</strong> " + info.event.extendedProps.departure_date + "</div><div><strong>B/B:</strong> " + info.event.extendedProps.b2b + "</div><div><strong>Code:</strong> " + info.event.extendedProps.room_code + "</div><div><strong>Cleaner:</strong> " + info.event.extendedProps.cleaner + "</div><div><strong>Notes:</strong> " + info.event.extendedProps.notes + "</div></div>",
            html: true,
            placement: 'top',
            trigger: 'hover',
            container: 'body'
          });
        },
        dateClick: function(info) {
      /* var date = info.dateStr;
      console.log(date);
      loadEvents(date);*/
        },
        datesSet: function(info) {
      /* var start = info.startStr;
      var end = info.endStr;
      console.log(start, end);
      loadEvents(start, end);*/
          addCustomClasses(info);
        },
         viewDidMount: function(info) {
            addCustomClasses(info);
        },
        viewDidUpdate: function(info) {
            addCustomClasses(info);
        }
      });

  // Check screen width and adjust resourceAreaWidth accordingly
      function adjustResourceAreaWidth() {
    if (window.innerWidth <= 768) { // Adjust width for screens with max-width 768px (typical for mobile devices)
      calendar.setOption('resourceAreaWidth', '30%');
    } else {
      calendar.setOption('resourceAreaWidth', '10%'); // Default width for desktop
    }
  }

  // Call the function on page load and resize
  adjustResourceAreaWidth();
  window.addEventListener('resize', adjustResourceAreaWidth);


      // Function to add custom classes to the table elements
    function addCustomClasses(info) {
        var viewName = info.view.type;
        var viewClass = 'fc-' + viewName + '-view';

        // Remove existing view classes from the calendar element
        calendarEl.classList.remove('fc-resourceTimelineDay-view', 'fc-resourceTimelineWeek-view', 'fc-resourceTimelineMonth-view');

        // Add the current view class to the calendar element
        calendarEl.classList.add(viewClass);

        // Add custom classes to the specific table elements
        var scrollGrids = calendarEl.querySelectorAll('.fc-scrollgrid');
        scrollGrids.forEach(function(grid) {
            grid.classList.remove('fc-resourceTimelineDay-view-table', 'fc-resourceTimelineWeek-view-table', 'fc-resourceTimelineMonth-view-table');
            grid.classList.add(viewClass + '-table');
        });
    }

  calendar.render();

  function loadEvents(start, end = null) {
    var data = {
      start: start
    };
    if (end) {
      data.end = end;
    }
    $.ajax({
      url: '/calendarAjaxData',
      type: 'GET',
      data: data,
      success: function(response) {
        calendar.removeAllEvents();
        calendar.addEventSource(response);
      },
      error: function(xhr, status, error) {
        console.error(error);
      }
    });
  }
});

</script>

</div>
</div>
</div>
@endsection