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
                 <h6 class="m-0 font-weight-bold text-primary">Aktivitas Petani</h6>
                 </div>
                 <div class="card-body">
   @if (session()->has('flash_notification.message'))
        <div class="alert alert-{{ session()->get('flash_notification.level') }}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! session()->get('flash_notification.message') !!}
        </div>
    @endif
<form method="POST" action="{{route('aktivitas.store')}}" role="form">
    @csrf
    <label style="color:red ">Tanggal Aktivitas : {{date("d M Y")}}</label>
    <label style="color:black">Nama Lahan</label>
    <select class="form-control show-tick" id="idlahan" name="idlahan" required>
        <option value="">-- Please select --</option>
        @foreach($lahan as $values)
        <option value="{{$values->idlahan}}">{{$values->namalahan}}</option>
        @endforeach
    </select>
    <label style="color:black">Fase Tanam</label>
    <select class="form-control show-tick" id="idfase" name="idfase" required>
        <option value="">-- Please select --</option>
        @foreach($fase as $values)
        <option value="{{$values->idfase}}">{{$values->namafase}}</option>
        @endforeach
    </select>
    <label style="color:black">Aktivitas</label>
    <select class="form-control show-tick" id="idsop" name="idsop" required>
        <option value="">-- Please select --</option>
       
    </select>
    <label style="color:black">Biaya</label>
    <input type="text" class="form-control uang" id="biaya" name="biaya" aria-describedby="emailHelp" required>
    <label style="color:black">Keterangan</label>
    <input type="text" class="form-control form-control-user" id="keterangan" name="keterangan" aria-describedby="emailHelp" required>
    <label style="color:black">Foto</label>
    <input type="text" class="form-control form-control-user" id="foto" name="foto" aria-describedby="emailHelp" required>
    <label style="color:black">Rekomendasi (Khusus PPL)</label>
    <textarea rows="4" cols="38" name="comment" form="usrform"></textarea>
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
              <h6 class="m-0 font-weight-bold text-primary">Histori Aktivitas Petani</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
        <table class="table table-bordered" id="tabelaktivitas" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th style="width: 20%; text-align: left; vertical-align: middle" >Nama Lahan</th>
                    <th style="width: 20%; text-align: left; vertical-align: middle" >Fase Tanam</th>
                    <th style="width: 20%; text-align: left; vertical-align: middle" >Aktivitas</th>
                    <th style="width: 10%; text-align: left; vertical-align: middle" >Biaya</th>
                    <th style="width: 10%; text-align: left; vertical-align: middle" >Keterangan</th>
                    <th style="width: 20%; text-align: left; vertical-align: middle" >Foto</th>
                                        
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
  </div>
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
<script src="{{asset('asetsba2/rupiah/jquery.mask.min.js')}}"></script>


<script>
 $(document).ready(function() {
        var dt = $('#tabelaktivitas').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route('tabel.aktivitas')}}',
            columns: [{
                    data: 'idaktivitas',
                    name: 'idaktivitas'
                },
                {
                    data: 'namalahan',
                    name: 'namalahan'
                },
                {
                    data: 'namafase',
                    name: 'namafase'
                },
                {
                    data: 'aktivitas',
                    name: 'aktivitas'
                },
                {
                    data: 'biaya',
                    name: 'biaya'
                },
                {
                    data: 'keterangan',
                    name: 'keterangan'
                },
                {
                    data: 'foto',
                    name: 'foto'
                },
                
            ]
        });
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
    $( '.uang' ).mask('000.000.000', {reverse: true});

});
  </script>

  <script>
 $(document).ready(function () {
            $('#idfase').change(function () {
                var id = $(this).val();
                $.ajax({
                    url: "/sopdetail/" + id,
                    method: "POST",
                    data: {id: id},
                    async: true,
                    dataType: 'json',
                    success: function (data) {
                        var html = '';
                        var i;
                        html += '<option>-- Please select --</option>';
                        for (i = 0; i < data.length; i++) {
                            html += '<option style="text-transform: lowercase;" value=' + data[i].idsop + '>' + data[i].kegiatan + '</option>';
                        }
                        $('#idsop').html(html);
                       
                    }
                });
                return false;
            });
            
        });
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  </script>
  
@endpush