@extends('layouts.masterdashboard')
@section('css')
    <link href="{{url('https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/css/gijgo.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    @endsection
@section('isi')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Kepemilikan Lahan Petani</h1>
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
        
  <div class="row">
  <!-- Content Column Ke 1-->
  <div class="col-lg-6 mb-4">
    <!-- Project Card Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DAFTAR KEPEMILIKAN LAHAN</h6>
      </div>
      <div class="card-body">
        <label style="color:black">NIK</label>
        <input type="text" class="form-control form-control-user" id="nik" name="nik" aria-describedby="emailHelp"
               placeholder="">
        <label style="color:black">Nama Petani</label>
        <input type="text" class="form-control form-control-user" id="nama" name="nama" aria-describedby="emailHelp"
               placeholder="" disabled>
        <label style="color:black">Alamat</label>
        <input type="text" class="form-control form-control-user" id="alamat" name="alamat" aria-describedby="emailHelp"
               placeholder="" disabled>
        <label style="color:black">Jenis Lahan Yang Dimiliki</label>
        <select class="form-control show-tick" id="idjenis" name="idjenis">
            <option value="">-- Please select --</option>
            @foreach($jenislahan as $values)
                <option value="{{$values->idjenis}}">{{$values->jenislahan}}</option>
            @endforeach
        </select>
        <label style="color:black">Nama Lahan</label>
        <input type="text" class="form-control form-control-user" id="namalahan" name="namalahan" aria-describedby="emailHelp"
               placeholder="">
        <label style="color:black">Luas Lahan yang dimiliki (Ha)</label>
        <input type="text" class="form-control form-control-user" id="luas" name="luas" aria-describedby="emailHelp"
               placeholder="">

        <br><label style="color:black">LOKASI LAHAN:</label>
        <br>
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

        <label style="color:black">Keterangan</label>
        <input type="text" class="form-control form-control-user" id="keterangan" name="keterangan"
               aria-describedby="emailHelp" required>
        <input type="text" class="form-control form-control-user" id="idpetani" name="idpetani"
               aria-describedby="emailHelp" placeholder="" hidden>
               <label style="color:black">Nama Kelompok Tani</label> 
        <a href="{{route('kelompokpetani.create')}}" target="_blank" class="btn btn-sm btn-primary shadow-sm">Daftar Kelompok</a>
        <select class="form-control show-tick" id="idkelompok" name="idkelompok" required>
            <option value="">-- Please select --</option>
            @foreach($kelompok as $value)
                <option style="text-transform: lowercase" value="{{$value->idkelompok}}">{{$value->namakelompok}}</option>
            @endforeach
        </select>
        <br>
        <button type="submit" id="simpan" class="btn-sm btn-primary shadow-sm">
            SIMPAN
        </button>

    </form>
    </div>
        </div>
        </div>
        </div>
        <div class="col-lg-6 d-none d-lg-block bg-pertanian"></div>
    <br>
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
                ajax: '{{route('tabel.kepemilikan')}}',
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
                        data:'namadesa',
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
                            url: "{{route('kepemilikanlahan.index')}}/" + id,
                            method: "DELETE",
                        }).done(function (msg) {
                            dt.ajax.reload();
                            $('#nama').val("");
                            $('#nik').val("");
                            $('#alamat').val("");
                            $('#idjenis').val("");
                            $('#luas').val("");
                            $('#idkecamatan').val("");
                            $('#iddesa').val("");
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
        });

       
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
                        html += '<option>-- Please select --</option>';
                        for (i = 0; i < data.length; i++) {
                            html += '<option style="text-transform: lowercase;" value=' + data[i].iddesa + '>' + data[i].namadesa + '</option>';
                        }
                        $('#iddesa').html(html);
                    }
                });
                return false;
            });

        });

        $(document).ready(function () {
            $('#iddesa').change(function () {
                var id = $(this).val();
                $.ajax({
                    url: "/datakelompok/" + id,
                    method: "POST",
                    data: {id: id},
                    async: true,
                    dataType: 'json',
                    success: function (data) {
                        var html = '';
                        var i;
                        html += '<option>-- Please select --</option>';
                        for (i = 0; i < data.length; i++) {
                            html += '<option style="text-transform: lowercase;" value=' + data[i].idkelompok + '>' + data[i].namakelompok + '</option>';
                        }
                        $('#idkelompok').html(html);
                    }
                });
                return false;
            });

        });

        $('#nik').change(function () {
            var kode = $("#nik").val();
            $.ajax({
                url: "{{url('/ceknik')}}/" + kode,
                type: 'GET',
                datatype: 'json',
                error: function (x, exception) {
                    swal("Gagal", "Data Tidak Ditemukan", "error");
                    $('#nama').val("");
                    $('#alamat').val("");
                },
                success: function (x) {
                    $.each(x, function (index, z) {
                        $('#nama').val(z.nama);
                        $('#alamat').val(z.alamat);

                    });
                }
            });
        });

        $('body').on("click", '.edit-modal', function () {
                    var idkeanggotaan = $(this).attr('data-id');
                    $.ajax({
                        url: "{{url('/cekkepemilikan')}}/" + idkeanggotaan,
                        type: 'GET',
                        datatype: 'json',
                        success: function (x) {
                            $.each(x, function (index, z) {
                                $('#nik').val(z.nik);
                                document.getElementById("nik").readOnly =true;
                                $('#nama').val(z.nama);
                                $('#luas').val(z.luaslahan);
                                $('#alamat').val(z.alamat);
                                $('#idjenis').val(z.idjenis);
                                $('#idkelompok').val(z.idkelompok);
                                
                                
                                $('#simpan').text("UPDATE");
                            });
                        }
                    });
                });

    </script>
@endpush
