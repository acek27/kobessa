@extends('layouts.masterdashboard')
@section('css')
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCyz35pK5Ccrp8a58PJSEO9vhLC6WU3FvU&sensor=false&libraries=drawing,geometry"></script>
@endsection

@section('isi')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12 mb-4">
      <div class="card shadow mb-4">
      <form method="POST" action="{{route('peta.store')}}" role="form">
      @csrf

      </form>
        <div class="card-body" id="googleMap" style="width:100%;height:720px;">
        
      </div>

</div>
</div>
</div>


@endsection
@push('script')

<script>
var peta;
var x;
var path;

  // function taruhMarker(peta, posisiTitik){
      
  //     if( marker ){
  //       // pindahkan marker
  //       marker.setPosition(posisiTitik);
  //     } else {
  //       // buat marker baru
  //       marker = new google.maps.Marker({
  //         position: posisiTitik,
  //         map: peta,
  //         icon:"{{asset('images/padi.png')}}"
  //       });
  //     }
      
  // }
    
  function initialize() {
    var situbondo = new google.maps.LatLng(-7.70623,114.00976)
    var propertiPeta = {
      center:situbondo,
      zoom:11,
      mapTypeId:google.maps.MapTypeId.HYBRID
    };
        
    peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);
    
        var drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: null,
            drawingControl: true,
            drawingControlOptions: {
              position: google.maps.ControlPosition.TOP_CENTER,
              drawingModes: [ 'marker','polygon']
            },
            markerOptions: {
                icon: "{{asset('images/padi2.png')}}"},
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
        var contentString = 'Nama Lahan : '+namalahan{{$values->idlahan}}+'<br>'+
                                    'Luas Lahan : '+ luaslahan{{$values->idlahan}} +' Ha' + '<br>' +
                                    'Pemilik Lahan : '+ pemiliklahan{{$values->idlahan}} +'<br>' +
                                    'Lokasi Lahan : '+ lokasilahan{{$values->idlahan}} +'<br>' +
                                    'Keterangan : '+ keterangan{{$values->idlahan}} +'<br>' +
                                    'Status Lahan : '+'<font color=#ff0000>'+ status{{$values->idlahan}} +'</font>';
       // menghilangkan tool draw
       // drawingManager.setMap(null);
                    bermudaTriangle = new google.maps.Polygon({
                        paths: path,
                        strokeColor: y{{$values->idlahan}},
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: y{{$values->idlahan}},
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
            if (event.type != google.maps.drawing.OverlayType.MARKER) {
                     drawingManager.setDrawingMode(null);
                     //drawingManager.setOptions({
                     //    drawingControl: false
                     //});
                 }
            document.getElementById("koordinat").value =encodedPath; 
        });

     // even listner ketika peta diklik
    // google.maps.event.addListener(peta, 'click', function(event) {
    //   taruhMarker(this, event.latLng);
    // });
  
  }

 
  // event jendela di-load  
  google.maps.event.addDomListener(window, 'load', initialize);

</script>

@endpush