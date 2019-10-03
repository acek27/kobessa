@extends('layouts.masterdashboard')
@section('css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection

@section('isi')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Ternak</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div>
@if (session()->has('flash_notification.message'))
        <div class="alert alert-{{ session()->get('flash_notification.level') }}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! session()->get('flash_notification.message') !!}
        </div>
    @endif
<form method="POST" action="{{route('dataternak.store')}}" role="form">
    @csrf
    <label style="color:black">Nama Hewan Ternak</label>
    <input type="text" class="form-control form-control-user" id="nama" name="nama" aria-describedby="emailHelp" required>
    <label style="color:black">Jenis Ternak</label>
    <select class="form-control show-tick" name="idjenis" required>
        <option value="">-- Please select --</option>
        @foreach($jenis as $values)
        <option value="{{$values->idjenis}}">{{$values->jenisternak}}</option>
        @endforeach
    </select>
    <br>
    <button class="btn btn-sm btn-primary shadow-sm">
        SIMPAN</button>

</form>

<br>
<div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Data Hewan Ternak</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
        <table class="table table-bordered" id="tabelhewan" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th style="width: 50%; text-align: left; vertical-align: middle" >Nama Hewan Ternak</th>
                    <th style="width: 40%; text-align: left; vertical-align: middle" >Jenis</th>
                    <th style="width: 60%; text-align: left; vertical-align: middle" >Action</th>
                    
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
</div>


@endsection
@push('script')
  <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="{{asset('asetsba2/js/demo/datatables-demo.js')}}"></script>

<script>
    $(document).ready(function() {
        var dt = $('#tabelhewan').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route('tabel.ternak')}}',
            columns: [{
                    data: 'idternak',
                    name: 'idternak'
                },
                {
                    data: 'namaternak',
                    name: 'namaternak'
                },
                {
                    data: 'namajenis',
                    name: 'namajenis'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    align: 'center'
                },
            ]
        });
    });
</script>
@endpush