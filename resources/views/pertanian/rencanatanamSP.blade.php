@extends('layouts.masterdashboard')
@section('css')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{url('https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/css/gijgo.min.css')}}" rel="stylesheet"/>
@endsection

@section('isi')
<!-- Page Heading -->
<div class="row">  
<div class="col-lg-12 mb-4">
<div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">RENCANA JADWAL TANAM PETANI KOBESSA SITUBONDO</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
        <table class="table table-bordered" id="tabeljadwaltanamSP" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>NIK</th>
                    <th style="width: 20%; text-align: left; vertical-align: middle" >Nama Petani</th>
                    <th style="width: 20%; text-align: left; vertical-align: middle" >Nama Lahan</th>
                    <th style="width: 20%; text-align: left; vertical-align: middle" >Lokasi Lahan</th>
                    <th style="width: 20%; text-align: left; vertical-align: middle" >Kecamatan</th>
                    <th style="width: 20%; text-align: left; vertical-align: middle" >SOP Tanam</th>
                    <th style="width: 20%; text-align: left; vertical-align: middle" >Metode Tanam</th>
                    <th style="width: 10%; text-align: left; vertical-align: middle" >Tgl Tanam</th>
                    <th style="width: 10%; text-align: left; vertical-align: middle" >Jenis Tanaman</th>
                    <th style="width: 20%; text-align: left; vertical-align: middle" >Komoditas</th>
                                        
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
<script src="{{url('https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/js/gijgo.min.js')}}"></script>
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('asetsba2/js/demo/datatables-demo.js')}}"></script>
<script>
 $(document).ready(function() {
        var dt = $('#tabeljadwaltanamSP').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route('tabel.historitanamSP')}}',
            columns: [{
                    data: 'nik',
                    name: 'nik'
                },
                {
                    data: 'namapetani',
                    name: 'namapetani'
                },
                {
                    data: 'namalahan',
                    name: 'namalahan'
                },
                {
                    data: 'namadesa',
                    name: 'namadesa'
                },
                {
                    data: 'kecamatan',
                    name: 'kecamatan'
                },
                {
                    data: 'versisop',
                    name: 'versisop'
                },
                {
                    data: 'idmetode',
                    name: 'idmetode'
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
                
            ]
        });
        });
 </script>
@endpush