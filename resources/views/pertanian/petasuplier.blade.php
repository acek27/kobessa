@extends('layouts.masterdashboard')
@section('css')
    <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{url('https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/css/gijgo.min.css')}}" rel="stylesheet"/>
    <!-- Custom styles for this template-->

    @endsection
@section('isi')
    <!-- Page Heading -->
    <!-- Body Peta -->
    <div class="row">
    <div class="col-lg-12 mb-4">
    <div class="card shadow mb-4">
    <div class="card-body">
         <div class="card-body" id="googleMap" style="width:100%;height:700px;"></div>  
               <br>     
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
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCyz35pK5Ccrp8a58PJSEO9vhLC6WU3FvU&sensor=false&libraries=drawing,geometry"></script>

<script>
var marker;
var  x = -7.70623;
var  y = 114.00976;
var z = 10;

var geocoder;

// $(document).ready(function () {
//     $('#iddesa').change(function () {
//                 var id = $(this).val();
//                 $.ajax({
//                     url: "/ambilkoordinat/" + id,
//                     method: "GET",
//                     data: {id: id},
//                     async: true,
//                     dataType: 'json',
//                     success: function (data) {
//                          x = data.latitude;
//                          y = data.longitude;
//                          z = 15;
//                        // alert(y);
//                         initialize(x,y,z);
                        

//                     }
//                 });

//                 return false;
//             });

//         });

    
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
    

    <!-- <script>
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
    </script> -->
@endpush
