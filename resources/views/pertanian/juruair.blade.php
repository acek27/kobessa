@extends('layouts.masterdashboard')
@section('css')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
@endsection
@section('isi')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DATA KEPEMILIKAN LAHAN</h6>
    </div>
    <div class="card-body">
      <div class="container">

             <div class="response"></div>

             <div id='calendar'></div>  

        </div>
    </div>
</div>
@endsection

@push('script')
<script>

$(document).ready(function () {

       

      var SITEURL = "{{url('/')}}";

      $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

      });



      var calendar = $('#calendar').fullCalendar({

          editable: true,

          events: SITEURL + "/fullcalendareventmaster",

          displayEventTime: true,

          editable: true,

          eventRender: function (event, element, view) {

              if (event.allDay === 'true') {

                  event.allDay = true;

              } else {

                  event.allDay = false;

              }

          },

          selectable: true,

          selectHelper: true,

          select: function (start, end, allDay) {

              var title = prompt('Event Title:');



              if (title) {

                  var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");

                  var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");



                  $.ajax({

                      url: SITEURL + "/fullcalendareventmaster/create",

                      data: 'title=' + title + '&start=' + start + '&end=' + end,

                      type: "POST",

                      success: function (data) {

                          displayMessage("Added Successfully");

                      }

                  });

                  calendar.fullCalendar('renderEvent',

                          {

                              title: title,

                              start: start,

                              end: end,

                              allDay: allDay

                          },

                  true

                          );

              }

              calendar.fullCalendar('unselect');

          },

           

          eventDrop: function (event, delta) {

                      var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");

                      var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");

                      $.ajax({

                          url: SITEURL + '/fullcalendareventmaster/update',

                          data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,

                          type: "POST",

                          success: function (response) {

                              displayMessage("Updated Successfully");

                          }

                      });

                  },

          eventClick: function (event) {

              var deleteMsg = confirm("Do you really want to delete?");

              if (deleteMsg) {

                  $.ajax({

                      type: "POST",

                      url: SITEURL + '/fullcalendareventmaster/delete',

                      data: "&id=" + event.id,

                      success: function (response) {

                          if(parseInt(response) > 0) {

                              $('#calendar').fullCalendar('removeEvents', event.id);

                              displayMessage("Deleted Successfully");

                          }

                      }

                  });

              }

          }



      });

});



function displayMessage(message) {

  $(".response").html("
"+message+"
");

  setInterval(function() { $(".success").fadeOut(); }, 1000);

}

</script>
@endpush

