@extends('layouts.masterdashboard')
@section('css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{url('https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/css/gijgo.min.css')}}" rel="stylesheet"/>
@endsection

@section('isi')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">JADWAL PENGAIRAN</h1>
</div>
@if (session()->has('flash_notification.message'))
        <div class="alert alert-{{ session()->get('flash_notification.level') }}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! session()->get('flash_notification.message') !!}
        </div>
    @endif
<form method="POST" action="#" role="form">
    @csrf
    <label style="color:black">Arah Air</label>
    <input type="text" class="form-control form-control-user" id="namasaprodi" name="namasaprodi" aria-describedby="emailHelp" required>
    <label style="color:black">Tanggal Mulai</label>
    <input type="text" class="form-control datepicker1" id="datepicker1" name="tglmulai" aria-describedby="emailHelp" required>
    <label style="color:black">Tanggal AKhir</label>
    <input type="text" class="form-control datepicker2" id="datepicker2" name="tglakhir" aria-describedby="emailHelp" required>
    <br>
    <button class="btn btn-sm btn-primary shadow-sm">
        SIMPAN</button>

</form>

<br>
@endsection
@push('script')
<script src="{{url('https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/js/gijgo.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('asetsba2/js/demo/datatables-demo.js')}}"></script>

<script>
          
        $(function () {
            $('.datepicker1').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                });
            });
        $(function () {
            $('.datepicker2').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                });
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
     

    
</script>
@endpush