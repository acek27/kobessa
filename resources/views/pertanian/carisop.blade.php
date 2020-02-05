@extends('layouts.masterdashboard')
@section('css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection
@section('isi')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DAFTAR SOP PERTANIAN </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table style="text-align: center" id="tabelkepemilikan" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width: 10%; text-align: left; vertical-align: middle">ID</th>
                        <th style="text-align: center; vertical-align: middle">Nama SOP</th>
                        <th style="text-align: center; vertical-align: middle">Pemilik SOP</th>
                        <th style="text-align: center; vertical-align: middle">Jenis Tanaman</th>
                        <th style="text-align: center; vertical-align: middle">Action</th>
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
    <script src="{{asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('asetsba2/js/demo/datatables-demo.js')}}"></script>

    <script>
$(document).ready(function() {
        var dt = $('#tabelkepemilikan').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route('tabel.sop')}}',
            columns: [{
                    data: 'idversi',
                    name: 'idversi'
                },
                    {
                        data: 'versisop',
                        name: 'versisop'
                    },
                    {
                        data: 'pemiliksop',
                        name: 'pemiliksop'
                    },
                    {
                        data: 'jenis',
                        name: 'jenis'
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

