@extends('layouts.masterdashboard')
@section('css')
    <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{url('https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/css/gijgo.min.css')}}" rel="stylesheet"/>
    <!-- Custom styles for this template-->

    @endsection
@section('isi')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Suplier</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Buat Laporan</a>
    </div>
    @if (session()->has('flash_notification.message'))
        <div class="alert alert-{{ session()->get('flash_notification.level') }}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! session()->get('flash_notification.message') !!}
        </div>
    @endif
    <form method="POST" action="{{route('datasuplier.store')}}" role="form">
        @csrf

  <div class="row">
  <!-- Content Column Ke 1-->
  <div class="col-lg-6 mb-4">
    <!-- Project Card Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">BIODATA SUPLIER</h6>
      </div>
      <div class="card-body">
        <label style="color:black">Nama Suplier</label>
        <input type="text" class="form-control form-control-user" value="{{old('nama')}}" id="nama" name="nama"
               aria-describedby="emailHelp" placeholder="" required>
        <label style="color:black">No Siup/TDP</label>
        <input type="text" class="form-control form-control-user" value="{{old('siup')}}" id="siup" name="siup"
               aria-describedby="emailHelp" placeholder="" required>
        <label style="color:black">Tanggal Pendirian</label>
        <input type="text" value="{{old('tgl')}}" class="form-control datepicker" id="datepicker" name="tgl"
               aria-describedby="emailHelp" placeholder="" required>
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
        <label style="color:black">Latitude</label>
        <input type="text" class="form-control form-control-user" id="latitude" name="latitude" aria-describedby="emailHelp" required> 
        <label style="color:black">Longitude</label>
        <input type="text" class="form-control form-control-user" id="longitude" name="longitude" aria-describedby="emailHelp" required> 
        <label style="color:black">Alamat Jelas</label>
        <input type="text" class="form-control form-control-user" value="{{old('alamat')}}" id="alamat" name="alamat"
               aria-describedby="emailHelp" placeholder="" required>
        <label style="color:black">No Telp</label>
        <input type="text" class="form-control form-control-user" id="telp" value="{{old('telp')}}" name="telp"
               aria-describedby="emailHelp" placeholder="" required>
        <label style="color:black">Email</label>
        <input type="text" class="form-control form-control-user" id="email" value="{{old('email')}}" name="email"
               aria-describedby="emailHelp" placeholder="" required>
        @if ($errors->any())
            {!! $errors->first('telp', '<p style="font-size: 12px; color:red">ERROR! input No Telp Harus Berupa Angka</p>') !!}
        @endif

        <br>
        <button id="simpan" type="submit" class="btn-sm btn-primary shadow-sm">
            SIMPAN
        </button>

        </form>

        </div>
        </div>
        </div>
        <!-- <div class="col-lg-6 d-none d-lg-block bg-pertanian"></div> -->
        <!-- Body Peta -->
    <div class="col-lg-6 mb-4">
    <div class="card shadow mb-4">
    <div class="card-body">
         <div class="card-body" id="googleMap" style="width:100%;height:500px;"></div>  
               <br> 
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
        
        
        
        
        <br>
        <div class="col-lg-12 mb-4">
        <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Suplier</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table style="text-align: center" id="datasuplier"
                       class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th style="width: 7%;text-align: center; vertical-align: middle">ID</th>
                        <th style="width: 20%; text-align: left; vertical-align: middle">Nama Suplier</th>
                        <th style="text-align: center; vertical-align: middle">No Siup/TDP</th>
                        <th style="text-align: center; vertical-align: middle">Kecamatan</th>
                        <th style="text-align: center; vertical-align: middle">Desa</th>
                        <th style="text-align: center; vertical-align: middle">Alamat</th>
                        <th style="text-align: center; vertical-align: middle">No Telp</th>
                        <!-- <th style="text-align: center; vertical-align: middle">Action</th> -->
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

<script>
var marker;
var  x = -7.70623;
var  y = 114.00976;
var z = 10;

var geocoder;

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

  function taruhMarker(peta, posisiTitik){  
      if( marker ){
        // pindahkan marker
        marker.setPosition(posisiTitik);
      } else {
        // buat marker baru
        marker = new google.maps.Marker({
          position: posisiTitik,
          map: peta,
          icon:"{{asset('images/suplier.png')}}"
        });
      } 
      document.getElementById("latitude").value = posisiTitik.lat();
      document.getElementById("longitude").value = posisiTitik.lng();
  }
    
  function initialize(x,y,z) {
    
    geocoder = new google.maps.Geocoder();
    var situbondo = new google.maps.LatLng(x,y)
    var propertiPeta = {
      center:situbondo,
      zoom:z,
      mapTypeId:google.maps.MapTypeId.HYBRID
    };   
    peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);
    //even listner ketika peta diklik
    google.maps.event.addListener(peta, 'click', function(event) {
      taruhMarker(this, event.latLng);
      geocoder.geocode({
            'latLng': event.latLng
        }, function (results, status) {
            if (status ==
                google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                    document.getElementById("alamat").value = results[0].formatted_address;   
                } else {
                    alert('Tidak Ada Alamat! Silahkan Pilih Lokasi Lain');
                    document.getElementById("alamat").value = "";   
                }
            } else {
                alert('Geocoder failed due to: ' + status);
            }
        });
    });

    @foreach($suplier as $values)
         x{{$values->idsuplier}} = "{{$values->latitude}}";
         y{{$values->idsuplier}} = "{{$values->longitude}}";
        var nama{{$values->idsuplier}} ="{{$values->namasuplier}}";
        var alamat{{$values->idsuplier}} ="{{$values->alamatsuplier}}";
        var telp{{$values->idsuplier}} ="{{$values->telpsuplier}}";
    
        var keterangan =         'Nama Suplier : '+nama{{$values->idsuplier}}+'<br>'+
                                    'Alamat Suplier : '+ alamat{{$values->idsuplier}}+ '<br>' +
                                    'Telp Suplier : '+ telp{{$values->idsuplier}} +'<br>';
         
        var toko =new google.maps.Marker({
        position: new google.maps.LatLng(x{{$values->idsuplier}}, y{{$values->idsuplier}}),
        map: peta,
        icon: "{{asset('images/suplier.png')}}",
        html:keterangan
        });
        var infowindow = new google.maps.InfoWindow();
            google.maps.event.addListener(toko, 'click', function(event) {
                        infowindow.setContent(this.html);
                        infowindow.setPosition(event.latLng);
                        infowindow.open(peta);
            });
        @endforeach
    // Mereset Polygon
    $('#resetPolygon').click(function(){
            marker.setPosition(null);  
            document.getElementById("latitude").value ="";
            document.getElementById("longitude").value = ""; 
            document.getElementById("alamat").value = ""; 
            });

  } 
  // event jendela di-load  
  google.maps.event.addDomListener(window, 'load', initialize(x,y,z));

</script>
    
<script>
        $(function () {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                });
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
    <script>
        $(document).ready(function () {
            var dt = $('#datasuplier').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{route('tabel.suplier')}}',
                columns: [{
                    data: 'idsuplier',
                    name: 'idsuplier'
                },
                   
                    {
                        data: 'namasuplier',
                        name: 'namasuplier'
                    },
                    {
                        data: 'siup',
                        name: 'siup'
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
                        data: 'alamatsuplier',
                        name: 'alamatsuplier'
                    },
                    {
                        data: 'telpsuplier',
                        name: 'telpsuplier'
                    },
                    // {data: 'action', name: 'action', orderable: false, searchable: false, align: 'center'},
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
                            url: "{{route('datapetani.index')}}/" + id,
                            method: "DELETE",
                        }).done(function (msg) {
                            dt.ajax.reload();
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
                var idpetani = $(this).attr('data-id');
                $.ajax({
                    url: "{{url('/cekpetani')}}/" + idpetani,
                    type: 'GET',
                    datatype: 'json',
                    success: function (x) {
                        $.each(x, function (index, z) {
                            $('#nik').val(z.nik);
                            document.getElementById("nik").readOnly =true;
                            $('#id').val(z.idpetani);
                            $('#nama').val(z.nama);
                            $('#tl').val(z.tempatlahir);
                            $('#datepicker').val(z.tgllahir);
                            $('#jk').val(z.jeniskelamin);
                            $('#alamat').val(z.alamat);
                            $('#telp').val(z.telp);
                            $('#simpan').text("UPDATE");
                            
                        });
                    }
                });
            });
        });
    </script>
@endpush
