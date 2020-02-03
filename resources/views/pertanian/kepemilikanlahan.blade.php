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
        <label style="color:black">Nama Lahan</label>
        <input type="text" class="form-control form-control-user" id="namalahan" name="namalahan" aria-describedby="emailHelp"
               placeholder="">
        <label style="color:black">Luas Lahan yang dimiliki (Ha)</label>
        <input type="text" class="form-control form-control-user" id="luas" name="luas" aria-describedby="emailHelp"
               placeholder="">
        <label style="color:black">Status Lahan</label>
        <select class="form-control show-tick" id="idstatus" name="idstatus" required>
            <option value="5">-- Tidak diketahui --</option>
            <option value="4">Pengolahan Lahan</option>
            <option value="1">Tanam</option>
            <option value="2">Panen</option>
            </select>
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
            @foreach($desa as $value)
                <option style="text-transform: lowercase" value="{{$value->iddesa}}">{{$value->namadesa}}</option>
            @endforeach

        </select>

        <label style="color:black">Keterangan</label>
        <input type="text" class="form-control form-control-user" id="keterangan" name="keterangan"
               aria-describedby="emailHelp" required>
        <input type="text" class="form-control form-control-user" id="idpetani" name="idpetani"
               aria-describedby="emailHelp" placeholder="" hidden>
        <input type="text" class="form-control form-control-user" id="idlahan" name="idlahan"
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
       

  
        </div>
        </div>
        </div>
    <div class="col-lg-6 mb-4">
    <div class="card shadow mb-4">
    <div class="card-body">
        <label style="color:black">Koordinat</label>
        <input type="text" class="form-control form-control-user" id="koordinat" name="koordinat"
               aria-describedby="emailHelp" required> 
<br>
               <div class="card-body" id="googleMap" style="width:100%;height:500px;"></div>  
               <br>
        <button type="submit" id="simpan" class="btn-sm btn-primary shadow-sm">
        SIMPAN
        </button>     
        <button type="button" id="resetPolygon" value="Reset" class="btn-sm btn-primary shadow-sm">
         RESET
        </button>     
    </div> 
    </div> 
    </div> 
    <div class="card-body">
   
        </form>
</div> 
</div> 
<!-- End Row -->

    <div class="col-lg-6 d-none d-lg-block bg-pertanian"></div> <!-- Backgroubd-->
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
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCyz35pK5Ccrp8a58PJSEO9vhLC6WU3FvU&sensor=false&libraries=drawing,geometry"></script>
    <script src='https://npmcdn.com/@turf/turf/turf.min.js'></script>
  
<script>
var peta;
var x;
var path;
var xpath=[];
var  x = -7.70623;
var  y = 114.00976;
var z = 10;

    $(document).ready(function () {
        $('#iddesa').change(function () {
                    var id = $(this).val();
                    $.ajax({
                        url: "/ambilkoordinat/" + id,
                        method: "GET",
                        data: {id: id},
                        async: true,
                        dataType: 'json',
                        success: function (data) {
                            x = data.latitude;
                            y = data.longitude;
                            z = 15;
                        // alert(y);
                            initialize(x,y,z);
                            

                        }
                    });

                    return false;
                });

            });

  function initialize(x,y,z) {
    var situbondo = new google.maps.LatLng(x,y)
    var propertiPeta = {
      center:situbondo,
      zoom:z,
      mapTypeId:google.maps.MapTypeId.HYBRID
    };
        peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);
    
        var drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: null,
            drawingControl: true,
            drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: [ 'polygon']
            },
            markerOptions: {
                icon: "{{asset('images/padi.png')}}"},
            polygonOptions: {
                editable: true
            },
            map: peta

        });
    
        @foreach($polygon as $values)
        var x{{$values->idlahan}} = "{{$values->koordinat}}";
        var y{{$values->idlahan}} = "{{$values->warna}}";
        var namalahan{{$values->idlahan}} ="{{$values->namalahan}}";
        var luaslahan{{$values->idlahan}} ="{{$values->luaslahan}}";
        var pemiliklahan{{$values->idlahan}} ="{{$values->nama}}";
        var lokasilahan{{$values->idlahan}} ="{{$values->namadesa}}";
        var keterangan{{$values->idlahan}} ="{{$values->keterangan}}";
        var status{{$values->idlahan}} ="{{$values->status}}";
        //mengembalikan patch encoding geometry dari database(String)
        var path = google.maps.geometry.encoding.decodePath(x{{$values->idlahan}});
        var contentString =         'Nama Lahan : '+namalahan{{$values->idlahan}}+'<br>'+
                                    'Luas Lahan : '+ luaslahan{{$values->idlahan}} +' Ha' + '<br>' +
                                    'Pemilik Lahan : '+ pemiliklahan{{$values->idlahan}} +'<br>' +
                                    'Lokasi Lahan : '+ lokasilahan{{$values->idlahan}} +'<br>' +
                                    'Keterangan : '+ keterangan{{$values->idlahan}} +'<br>' +
                                    'Status Lahan : '+'<font color=#ff0000>'+ status{{$values->idlahan}} +'</font>';
        // menghilangkan tool draw
       // drawingManager.setMap(null);
                    bermudaTriangle = new google.maps.Polygon({
                        paths: path,
                        strokeColor: "{{$values->warna}}",
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: "{{$values->warna}}",
                        fillOpacity: 0.35,
                        html: contentString
                        //,editable: true
                    });
                    
                    bermudaTriangle.setMap(peta);

                    infoWindow = new google.maps.InfoWindow();
                    google.maps.event.addListener(bermudaTriangle, 'click', function(event) {
                    infoWindow.setContent(this.html);
                    infoWindow.setPosition(event.latLng);
                    infoWindow.open(peta);
});
        @endforeach
        
        google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event) {
            var encodedPath = google.maps.geometry.encoding.encodePath(event.overlay.getPath());
            console.log(encodedPath);
            document.getElementById("koordinat").value =encodedPath; 
             xpath =event.overlay.getPath().getArray();          
             var coords = [];
            for (var i = 0; i < xpath.length; i++) {
            coords.push([
                xpath[i].lat(),
                xpath[i].lng()
            ]); 
            }
            coords.push([
                xpath[0].lat(),
                xpath[0].lng()
            ]); 
           // inisiasi polygon dengan turf.js
           var turf_polygon = turf.polygon([coords]);
           // hitung luas area pada polygon
           var turf_area = turf.area(turf_polygon);

            if ((turf_area / 10000).toFixed(2) <= 1) {
            alert('Luas Area : ' + (turf_area).toFixed(2) + ' m2')
            } else {
            alert('Luas  Area : ' + (turf_area / 10000).toFixed(2) + ' ha')
            }

            // Mereset Polygon
            $('#resetPolygon').click(function(){
            event.overlay.setMap(null);
                   
            document.getElementById("koordinat").value =""; 
            });
        });     

  }
 
  // event jendela di-load  
  google.maps.event.addDomListener(window, 'load', initialize(x,y,z));

</script>

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
                url: "{{url('/cekniktani')}}/" + kode,
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
                                $('#namalahan').val(z.namalahan);
                                $('#idkelompok').val(z.idkelompok);
                                $('#idlahan').val(z.idlahan);
                                $('#idstatus').val(z.idstatus);
                                $('#idkecamatan').val(z.idkecamatan);
                                $('#iddesa').val(z.iddesa);
                                $('#koordinat').val(z.koordinat);
                                $('#keterangan').val(z.keterangan);
                                
                                
                                $('#simpan').text("UPDATE");
                            });
                        }
                    });
                });

    </script>
@endpush
