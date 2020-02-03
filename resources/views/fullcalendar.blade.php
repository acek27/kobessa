@extends('layouts.masterdashboard')
@section('css')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />

@endsection
@section('isi')
<div class="row">
        <!-- Content Column Ke 1-->
        <div class="col-lg-3 mb-4">
        <!-- Project Card Example -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                 <h6 class="m-0 font-weight-bold text-primary">KETERANGAN PENGISIAN</h6>
                 </div>
                 <div class="card-body">
                 <Label><b>TAMBAH JADWAL:</b></Label><br>
                 <Label>1. Klik/Blok tanggal yang akan diberikan isian penjadwalan</Label><br>
                 <Label>2. Isikan Nama Kegiatan</Label><br>
                 <Label>3. Simpan</Label><br>
                 <br>
                 <Label><b>PERUBAHAN JADWAL</b></Label><br>
                 <Label>Pilih Kegiatan yang ada di kalender, tahan dan geser ke tanggal yang diinginkan</Label><br>
                 <br>
                 <Label><b>PENGHAPUSAN JADWAL</b></Label><br>
                 <Label>Pilih Kegiatan yang ada di kalender,Klik dan Pilih Ok untuk Menghapus Jadwal</Label><br>

                
</div>
</div>
</div>

      
       <div class="col-lg-9 mb-4">
    <!-- Project Card Example -->
    <div class="card shadow mb-4">
    
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">KALENDER PENJADWALAN SALURAN IRIGASI KABUPATEN SITUBONDO</h6>
       
      </div>
      <div class="card-body">
      <div class="response"></div>
      <div id='calendar'></div>  

  </div>
  </div>
  </div>
  </div>
 
@endsection
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
<script>
  $(document).ready(function () {
         
        // var SITEURL = "{{url('/')}}";
        // $.ajaxSetup({
        //   headers: {
        //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //   }
        // });
 
        var calendar = $('#calendar').fullCalendar({
            editable: true,
            events: "fullcalendar",
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
                    var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                    var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
 
                    $.ajax({
                        url: "fullcalendar/create",
                        data: 'title=' + title + '& start=' + start + '& end=' + end,
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
                        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
                        $.ajax({
                            url: 'fullcalendar/update',
                            data: 'title=' + event.title + '& start=' + start + '& end=' + end + '& id=' + event.id,
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
                        url: 'fullcalendar/delete',
                        data: "id=" + event.id,
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
    $(".response").html("<div class='success'>"+message+"</div>");
    setInterval(function() { $(".success").fadeOut(); }, 1000);
  }
</script>
@endpush
