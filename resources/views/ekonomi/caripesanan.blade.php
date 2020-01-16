@extends('layouts.masterdashboard')
@section('css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

@endsection
@section('isi')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DATA PESANAN</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table style="text-align: center" id="tabelpesanan" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width: 20%; text-align: left; vertical-align: middle">No PO</th>
                        <th style="text-align: center; vertical-align: middle">Nama Pemesan</th>
                        <th style="text-align: center; vertical-align: middle">Kecamatan</th>
                        <th style="text-align: center; vertical-align: middle">Desa</th>
                        <th style="text-align: center; vertical-align: middle">Nama Saprodi</th>
                        <th style="text-align: center; vertical-align: middle">Jumlah</th>
                        <th style="text-align: center; vertical-align: middle">Tgl Pesan</th>
                        <th style="text-align: center; vertical-align: middle">Tgl Kirim</th>
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
    <script src="{{asset('plugins/dist/js/standalone/selectize.js')}}"></script>
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('asetsba2/js/demo/datatables-demo.js')}}"></script>

    <script>
$(document).ready(function() {
        var dt = $('#tabelpesanan').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route('tabel.pesanan')}}',
            columns: [{
                    data: 'PO',
                    name: 'PO'
                   },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'namakecamatan',
                        name: 'namakecamatan'
                    },
                    {
                        data: 'namadesa',
                        name: 'namadesa'
                    },
                    {
                        data: 'namasaprodi',
                        name: 'namasaprodi'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'tglpesan',
                        name: 'tglpesan'
                    },
                    {
                        data: 'tglkirim',
                        name: 'tglkirim'
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

