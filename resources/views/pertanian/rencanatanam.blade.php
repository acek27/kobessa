@extends('layouts.masterdashboard')
@section('css')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{url('https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/css/gijgo.min.css')}}" rel="stylesheet"/>
@endsection

@section('isi')
<!-- Page Heading -->
<div class="row">
    <!-- Content Column Ke 1-->
    <div class="col-lg-3 mb-4">
      <!-- Project Card Example -->
      <div class="card shadow mb-4">
      <div class="card-header py-3">
                 <h6 class="m-0 font-weight-bold text-primary">Rencana Tanam</h6>
                 </div>
                 <div class="card-body">
   @if (session()->has('flash_notification.message'))
        <div class="alert alert-{{ session()->get('flash_notification.level') }}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! session()->get('flash_notification.message') !!}
        </div>
    @endif
<form method="POST" action="{{route('rencanatanam.store')}}" role="form">
    @csrf
    <label style="color:black">Nama Lahan</label>
    <select class="form-control show-tick" id="idlahan" name="idlahan" required>
        <option value="">-- Please select --</option>
        @foreach($lahan as $values)
        <option value="{{$values->idlahan}}">{{$values->namalahan}}</option>
        @endforeach
    </select>
    <label style="color:black">Jenis Tanaman</label>
    <select class="form-control show-tick" id="idjenis" name="idjenis" required>
        <option value="">-- Please select --</option>
        @foreach($jenis as $values)
        <option value="{{$values->idjenis}}">{{$values->jenistanaman}}</option>
        @endforeach
    </select>
    <label style="color:black">Komoditas</label>
    <input type="text" class="form-control form-control-user" id="komoditas" name="komoditas" aria-describedby="emailHelp" required>
    <label style="color:black">Tanggal Tanam</label>
    <input type="text" class="form-control datepicker" id="datepicker" name="tgltanam" aria-describedby="emailHelp" required>
    <label style="color:black">Pilih SOP Tanam</label>
    <select class="form-control show-tick" id="idversi" name="idversi" required>
        <option value="">-- Please select --</option>
        @foreach($sop as $values)
        <option value="{{$values->idversi}}">{{$values->versisop}}</option>
        @endforeach
    </select>
    <label style="color:black">Pilih Metode</label>
    <select class="form-control show-tick" id="metode" name="metode" required>
        <option value="">-- Please select --</option>
        
        <option value="1">Pembenihan</option>
        <option value="2">Pembibitan/Tanam</option>
       
    </select>  
    <br>
    <button class="btn btn-sm btn-primary shadow-sm">
        SIMPAN</button>

    </form>
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
<br>
<div class="col-lg-12 mb-4">
<div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Histori Jadwal Tanam</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
        <table class="table table-bordered" id="tabeljadwaltanam" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th style="width: 20%; text-align: left; vertical-align: middle" >Nama Lahan</th>
                    <th style="width: 20%; text-align: left; vertical-align: middle" >SOP Tanam</th>
                    <th style="width: 20%; text-align: left; vertical-align: middle" >Metode Tanam</th>
                    <th style="width: 10%; text-align: left; vertical-align: middle" >Tgl Tanam</th>
                    <th style="width: 10%; text-align: left; vertical-align: middle" >Jenis Tanaman</th>
                    <th style="width: 20%; text-align: left; vertical-align: middle" >Komoditas</th>
                    <th style="width: 20%; text-align: left; vertical-align: middle" >Periode Tanam Ke</th>
                    <th style="width: 20%; text-align: left; vertical-align: middle" >Action</th>
                                        
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
</div>
</div>


@endsection
@push('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
<script src="{{url('https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/js/gijgo.min.js')}}"></script>
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('asetsba2/js/demo/datatables-demo.js')}}"></script>
<script>
 $(document).ready(function() {
        var dt = $('#tabeljadwaltanam').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route('tabel.histori')}}',
            columns: [{
                    data: 'idjadwaltanam',
                    name: 'idjadwaltanam'
                },
                {
                    data: 'namalahan',
                    name: 'namalahan'
                },
                {
                    data: 'versisop',
                    name: 'versisop'
                },
                {
                    data: 'metode',
                    name: 'metode'
                },
                {
                    data: 'tgltanam',
                    name: 'tgltanam'
                },
                {
                    data: 'jenis',
                    name: 'jenis'
                },
                {
                    data: 'komoditas',
                    name: 'komoditas'
                },
                {
                    data: 'periode',
                    name: 'periode'
                },
                {   data: 'action', name: 'action', orderable: false, searchable: false, align: 'center'},
                
            ]
        });
        });

        $('#idjenis').change(function () {
                var id = $(this).val();
                $.ajax({
                    url: "/datasop/" + id,
                    method: "POST",
                    data: {id: id},
                    async: true,
                    dataType: 'json',
                    success: function (data) {
                        var html = '';
                        var i;
                        html += '<option>-- Please select --</option>';
                        for (i = 0; i < data.length; i++) {
                            html += '<option style="text-transform: lowercase;" value=' + data[i].idversi + '>' + data[i].versisop + '</option>';
                        }
                        $('#idversi').html(html);
                       
                    }
                });
                return false;
            });

        $(function () {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                });
            });

 </script>
 <script>
  $(document).ready(function () {
         
  
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
            selectHelper: true,
            select: function (start, end, allDay) {
                            
                    calendar.fullCalendar('renderEvent',
                            {
                                title: title,
                                start: start,
                                end: end,
                                allDay: allDay
                            },
                    true
                            );
              
                calendar.fullCalendar('unselect');
            },
             
        });
  });
 
</script>
@endpush