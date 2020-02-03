@extends('layouts.masterdashboard')
@section('css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection
@section('isi')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Kelompok Tani</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div>
@if (session()->has('flash_notification.message'))
        <div class="alert alert-{{ session()->get('flash_notification.level') }}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! session()->get('flash_notification.message') !!}
        </div>
    @endif
<form method="POST" action="{{route('kelompokpetani.store')}}" role="form">
    @csrf
    <div class="row">
  <!-- Content Column Ke 1-->
  <div class="col-lg-6 mb-4">
    <!-- Project Card Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DAFTAR KEOMPOK TANI</h6>
      </div>
      <div class="card-body">
    <label style="color:black">Nama Kelompok</label>
    <input type="text" class="form-control form-control-user" id="nama" name="nama" aria-describedby="emailHelp" placeholder="" required>
    <input type="text" class="form-control form-control-user" id="id" name="id" aria-describedby="emailHelp" placeholder="" hidden>
    <label style="color:black">Alamat Sekretariat</label>
    <input type="text" class="form-control form-control-user" id="alamat" name="alamat" aria-describedby="emailHelp" placeholder="" required>
    <label style="color:black">Kecamatan</label>
    <label style="color:black">Kecamatan</label>
        <select class="form-control show-tick" id="idkecamatan" name="idkecamatan" required>
            <option value="">-- Please select --</option>
            @foreach($kecamatan as $value)
                <option style="text-transform: lowercase" value="{{$value->idkecamatan}}">{{$value->kecamatan}}</option>
            @endforeach
        </select>
        <label style="color:black">Desa</label>
        <select class="form-control show-tick" id="iddesa" name="iddesa" required>
            <option value="">-- Please select --</option>

        </select>
    <label style="color:black">Tahun Pembentukan</label>
    <input type="text" class="form-control form-control-user" id="thn" name="thn" aria-describedby="emailHelp" placeholder="" required>
    <label style="color:black">Jenis Kelompok</label>
    <select class="form-control show-tick" id="jeniskelompok" name="jeniskelompok" required>
        <option value="">-- Please select --</option>
        @foreach($jenis as $values)
        <option value="{{$values->jeniskelompok}}">{{$values->jeniskelompok}}</option>
        @endforeach
    </select>
        <br>
    <button type="submit" id="simpan" style="align-center" class="btn-sm btn-primary shadow-sm">
        SIMPAN</button>

</form>
</div>
        </div>
        </div>
        <div class="col-lg-6 d-none d-lg-block bg-pertanian"></div>
</div>
@csrf
<br>
<div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Data Kelompok Petani</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
        <table class="table table-bordered" id="kelompoktani" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kelompok Peternak</th>
                    <th>Alamat Sekretariat</th>
                    <th>Desa</th>
                    <th>Kecamatan</th>
                    <th>Tahun Pembentukan</th>
                    <th>Jenis Kelompok</th>
                    <th>Action</th>
                    
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
        var dt = $('#kelompoktani').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route('tabel.kelompokpetani')}}',
            columns: [{
                    data: 'idkelompok',
                    name: 'idkelompok'
                },
                {
                    data: 'namakelompok',
                    name: 'namakelompok'
                },
                {
                    data: 'alamatsekretariat',
                    name: 'alamatsekretariat'
                },
                {
                    data: 'desa',
                    name: 'adesa'
                },
                {
                    data: 'namakecamatan',
                    name: 'namakecamatan'
                },
                {
                    data: 'tahunpembentukan',
                    name: 'tahunpembentukan'
                },
                {
                    data: 'jeniskelompok',
                    name: 'jeniskelompok'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    align: 'center'
                },
            ]
        });var del = function (id) {
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
                                url: "{{route('kelompokpetani.index')}}/" + id,
                                method: "DELETE",
                            }).done(function (msg) {
                                dt.ajax.reload();
                                $('#nama').val("");
                                $('#alamat').val("");
                                $('#desa').val("");
                                $('#thn').val("");
                                $('#jeniskelompok').val("");
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
                    var idkelompokpetani = $(this).attr('data-id');
                    $.ajax({
                        url: "{{url('/cekkelompokpetani')}}/" + idkelompokpetani,
                        type: 'GET',
                        datatype: 'json',
                        success: function (x) {
                            $.each(x, function (index, z) {
                                $('#nama').val(z.namakelompok);
                                $('#id').val(z.idkelompok);
                                $('#alamat').val(z.alamatsekretariat);
                                $('#desa').val(z.iddesa);
                                $('#jeniskelompok').val(z.jeniskelompok);
                                $('#thn').val(z.tahunpembentukan);
                                $('#simpan').text("UPDATE");
                            });
                        }
                    });
                });

                var start = new Date().getFullYear();
                var end = start - 50;
                var options = "";
                for (var year = start; year >= end; year--) {
                    options += "<option>" + year + "</option>";
                }
                document.getElementById("thn").innerHTML = options;
            });
</script>
 <script>
        $(document).ready(function () {
            $('#idkecamatan').change(function () {
                var id = $(this).val();
                $.ajax({
                    url: "/datadesa/" + id,
                    method: "POST",
                    data: {id: id},
                    async: true,
                    dataType: 'json',
                    success: function (data) {
                        var html = '';
                        var i;
                        for (i = 0; i < data.length; i++) {
                            html += '<option style="text-transform: lowercase;" value=' + data[i].iddesa + '>' + data[i].namadesa + '</option>';
                        }
                        $('#iddesa').html(html);
                    }
                });
                return false;
            });

        });
    </script>
@endpush