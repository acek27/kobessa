@extends('layouts.masterdashboard')
@section('css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection

@section('isi')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">DATA SAPRODI</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div>
@if (session()->has('flash_notification.message'))
        <div class="alert alert-{{ session()->get('flash_notification.level') }}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! session()->get('flash_notification.message') !!}
        </div>
    @endif
<form method="POST" action="{{route('datasaprodi.store')}}" role="form">
    @csrf
    <label style="color:black">Nama Saprodi</label>
    <input type="text" class="form-control form-control-user" id="namasaprodi" name="namasaprodi" aria-describedby="emailHelp" required>
    <label style="color:black">Satuan</label>
    <input type="text" class="form-control form-control-user" id="satuan" name="satuan" aria-describedby="emailHelp" required>
    <label style="color:black">Harga Satuan</label>
    <input type="text" class="form-control form-control-user" id="hargasatuan" name="hargasatuan" aria-describedby="emailHelp" required>
    <label style="color:black">Fungsi / Kegunaan</label>
    <input type="text" class="form-control form-control-user" id="fungsi" name="fungsi" aria-describedby="emailHelp" required>
    <br>
    <button class="btn btn-sm btn-primary shadow-sm">
        SIMPAN</button>

</form>

<br>
<div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Data Saprodi</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
        <table class="table table-bordered" id="tabelsaprodi" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th style="width: 50%; text-align: left; vertical-align: middle" >Nama Saprodi</th>
                    <th style="width: 40%; text-align: left; vertical-align: middle" >Satuan</th>
                    <th style="width: 40%; text-align: left; vertical-align: middle" >Harga Satuan</th>
                    <th style="width: 40%; text-align: left; vertical-align: middle" >Fungsi</th>
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
        var dt = $('#tabelsaprodi').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route('tabel.saprodi')}}',
            columns: [
                {
                    data: 'idsaprodi',
                    name: 'idsaprodi'
                },
                {
                    data: 'namasaprodi',
                    name: 'namasaprodi'
                },
                {
                    data: 'satuan',
                    name: 'satuan'
                },
                {
                    data: 'hargasatuan',
                    name: 'hargasatuan'
                },
                {
                    data: 'fungsi',
                    name: 'fungsi'
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
        var del = function (id) {
                swal({
                    title: "Apakah anda yakin?",
                    text: "Anda tidak dapat mengembalikan data yang sudah terhapus!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Iya!",
                    cancelButtonText: "Tidak!",
                }).then(
                    function (result) {
                        $.ajax({
                            url: "{{route('datasaprodi.index')}}/" + id,
                            method: "DELETE",
                        }).done(function (msg) {
                         dt.ajax.reload();
                            $('#namasaprodi').val("");
                            $('#satuan').val("");
                            $('#hargasatuan').val("");
                            $('#fungsi').val("");
                            $('#simpan').text("SIMPAN");
                            swal("Deleted!", "Data sudah terhapus.", "success");
                        }).fail(function (textStatus) {
                            alert("Request failed: " + textStatus);
                        });
                    }, function (dismiss) {
                        // dismiss can be 'cancel', 'overlay', 'esc' or 'timer'
                        swal("Cancelled", "Data batal dihapus", "error");
                    });
            };

            $('body').on('click', '.hapus-data', function () {
                del($(this).attr('data-id'));
            });

            $('body').on("click", '.edit-modal', function () {
                var idsaprodi = $(this).attr('data-id');
                $.ajax({
                    url: "/saprodi/"+ idsaprodi+"/edit",
                    type: 'GET',
                    datatype: 'json',
                    success: function (x) {
                        $.each(x, function (index, z) {
                            $('#namasaprodi').val(z.namasaprodi);
                            $('#satuan').val(z.satuan);
                            $('#hargasatuan').val(z.hargasatuan);
                            $('#fungsi').val(z.fungsi);
                            $('#simpan').text("UPDATE");
                        });

                    }
                });
            });
    
    
    });

    
</script>
@endpush