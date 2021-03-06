@extends('layouts.masterdashboard')
@section('css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{url('https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/css/gijgo.min.css')}}" rel="stylesheet"/>
@endsection

@section('isi')
<!-- Page Heading -->
<!-- TAMPIL TABEL -->
<div class="row">
<div class="col-lg-12 mb-4"> 
<div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">HISTORY PESANAN SAPRODI</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
        <table class="table table-bordered" id="tabelhistori" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No.PO</th>
                    <th style="width: 50%; text-align: left; vertical-align: middle" >Nama Suplier</th>
                    <th style="width: 50%; text-align: left; vertical-align: middle" >Nama Saprodi</th>
                    <th style="width: 40%; text-align: left; vertical-align: middle" >Kebutuhan</th>
                    <th style="width: 40%; text-align: left; vertical-align: middle" >Satuan</th>
                    <th style="width: 40%; text-align: left; vertical-align: middle" >Tgl Pesan</th>
                    <th style="width: 40%; text-align: left; vertical-align: middle" >Tgl Kirim</th>
                    <th style="width: 40%; text-align: left; vertical-align: middle" >Status</th>
                    <th style="width: 40%; text-align: left; vertical-align: middle" >Action</th>
                                  
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
    <script src="{{url('https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/js/gijgo.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('asetsba2/js/demo/datatables-demo.js')}}"></script>

    <script>
    $(document).ready(function() {
        var dt = $('#tabelhistori').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route('tabel.history')}}',
            columns: [{
                    data: 'PO',
                    name: 'PO'
                },
                {
                    data: 'namasuplier',
                    name: 'namasuplier'
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
                    data: 'satuan',
                    name: 'satuan'
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
                    data: 'status',
                    name: 'status'
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
