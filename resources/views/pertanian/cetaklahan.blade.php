@extends('layouts.masterdashboard')
@section('css')
    <link href="{{url('https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/css/gijgo.min.css')}}"
          rel="stylesheet"/>
    <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection
@section('isi')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pemilihan Lahan Untuk MOU</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Buat Laporan</a>
    </div>
    @if (session()->has('flash_notification.message'))
        <div class="alert alert-{{ session()->get('flash_notification.level') }}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! session()->get('flash_notification.message') !!}
        </div>
    @endif
    <form method="POST" action="{{route('kepemilikanlahan.store')}}" role="form">
        @csrf

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Kepemilikan Lahan Petani</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table style="text-align: center" id="datalahan"
                           class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <th style="width: 7%;text-align: center; vertical-align: middle">NIK</th>
                            <th style="text-align: center; vertical-align: middle">Nama</th>
                            <th style="text-align: center; vertical-align: middle">Alamat Petani</th>
                            <th style="text-align: center; vertical-align: middle">Nama Lahan</th>
                            <th style="text-align: center; vertical-align: middle">Luas Lahan (Ha)</th>
                            <th style="text-align: center; vertical-align: middle">Lokasi Lahan</th>
                            <th style="text-align: center; vertical-align: middle">Nama Kelompok</th>
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
            <script src="{{url('https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/js/gijgo.min.js')}}"></script>
            <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
            <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
            <script src="{{asset('asetsba2/js/demo/datatables-demo.js')}}"></script>

            <script>
                $(document).ready(function () {
                    var dt = $('#datalahan').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: '{{route('mou.lahan',$data)}}',
                        columns: [{
                            data: 'nik',
                            name: 'nik'
                        },
                            {
                                data: 'nama',
                                name: 'nama'
                            },
                            {
                                data: 'alamat',
                                name: 'alamat'
                            },
                            {
                                data: 'namalahan',
                                name: 'namalahan'
                            },
                            {
                                data: 'luaslahan',
                                name: 'luaslahan'
                            },
                            {
                                data: 'namadesa',
                                name: 'namadesa'
                            },
                            {
                                data: 'namakelompok',
                                name: 'namakelompok'
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
