@extends('layouts.masterdashboard')
@section('css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{url('https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/css/gijgo.min.css')}}" rel="stylesheet"/>
@endsection

@section('isi')
<!-- Page Heading -->
<div class="row">

 <div class="col-lg-6 mb-4">
    <!-- Project Card Example -->
    @foreach($suplier as $value)
    <form method="POST" action="{{route('ordersaprodi.store')}}" role="form"> 
    @csrf   
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">DATA PESANAN</h6>
                    </div>
                       <div class="card-body">
                            <div class="form-group row">
                                 <label style="color:black" class="col-sm-3 col-form-label">     Nama Suplier </label>
                                 <input type="text" class="form-control form-control-user && col-sm-8" value="{{$value->namasuplier}}" disabled>
                            </div>
                            <div class="form-group row">
                                 <label style="color:black" class="col-sm-3 col-form-label">Alamat Suplier  </label> <br>
                                 <input type="text" class="form-control form-control-user && col-sm-8" value="{{$value->alamatsuplier}}" disabled>
                            </div>
                            <div class="form-group row">
                                 <label style="color:black" class="col-sm-3 col-form-label">No SIUP  </label> <br>
                                 <input type="text" class="form-control form-control-user && col-sm-8" value="{{$value->siup}}" disabled>
                            </div>
                            <div class="form-group row">
                                 <label style="color:black" class="col-sm-3 col-form-label">Telp Suplier  </label> <br>
                                 <input type="text" class="form-control form-control-user && col-sm-8" value="{{$value->telpsuplier}}" disabled>
                            </div>
                            <div class="form-group row">
                                 <label style="color:black" class="col-sm-3 col-form-label">No Pesanan (PO) </label> <br>
                                 <input type="text" class="form-control form-control-user && col-sm-8" id="po" name="po" value="@if($nopo == null){{1}}@else{{$nopo+1}}@endif" disabled>
                            </div>
                            <div class="form-group row">
                                 <label style="color:black" class="col-sm-3 col-form-label">Permintaan Dikirim  </label> <br>
                                 <input type="text" class="form-control datepicker && col-sm-8 && form-control form-control-user " id="datepicker" name="tglkirim" required >
                            </div>
                                 
                                 <input type="text" class="form-control form-control-user" id="idsuplier" value="{{$value->idsuplier}}" name="idsuplier" hidden>
                                 <input type="text" class="form-control form-control-user" id="nik" value="{{Auth::User()->nik}}" name="nik" hidden>
                        <!-- <label style="color:black">No PO </label> <br> -->
                        <!-- <input type="text" class="form-control form-control-user" id="po" value="@if($nopo == null){{1}}@else{{$nopo+1}}@endif" name="po" disabled> -->
                        <input type="text" class="form-control form-control-user" id="po1" value="@if($nopo == null){{1}}@else{{$nopo+1}}@endif" name="po1" hidden>
                        <!-- <label style="color:black">Permintaan dikirim </label> <br> -->
                        <!-- <input type="text" class="form-control datepicker" id="datepicker"  name="tglkirim"> -->
                                 </div>
                </div>
                </div>

      <div class="col-lg-6 mb-4">
      <div class="card shadow mb-4">
                      <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">SAPRODI YANG INGIN DIPESAN</h6>
                      </div>
    <div class="card-body">
   
    <table>
    <tr>
    <th>Nama Saprodi</th>
    <th>Harga Satuan</th>
    <th>Kebutuhan</th>
    <th>Jumlah</th>
    
    </tr>
    @for($i = 1; $i <=6; $i++)
    <tr>
    <td><select class="form-control form-control-user" id="idsaprodi{{$i}}" name="idsaprodi{{$i}}" >
    <option value="">-- Please select --</option>
        @foreach($saprodi as $values)
        <option value="{{$values->idsaprodi}}">{{$values->namasaprodi}} ({{$values->satuan}})</option>
        @endforeach
    </select></td>
    <td><input type="text" class="form-control form-control-user only-numeric" id="harga{{$i}}" name="harga{{$i}}" aria-describedby="emailHelp" ></td>
    <td><input type="text" class="form-control form-control-user only-numeric" id="kebutuhan{{$i}}" name="kebutuhan{{$i}}" aria-describedby="emailHelp" ></td>
    <td><input type="text" class="form-control form-control-user only-numeric" id="jumlah{{$i}}" name="jumlah{{$i}}" aria-describedby="emailHelp" ></td>
    </tr>
    @endfor
        
    </table>
    
    <br>
    <button class="btn btn-sm btn-primary shadow-sm">
        SIMPAN</button>
        
      
    </form>
    @endforeach
    </div>
    </div>
    </div>
    </div>

<!-- TAMPIL TABEL -->
<div class="row">
<div class="col-lg-12 mb-4"> 
<div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">DAFTAR PESANAN SAPRODI</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
        <table class="table table-bordered" id="tabelpesanan" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th style="width: 50%; text-align: left; vertical-align: middle" >Nama Saprodi</th>
                    <th style="width: 40%; text-align: left; vertical-align: middle" >Kebutuhan</th>
                    <th style="width: 40%; text-align: left; vertical-align: middle" >Satuan</th>
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
    <script src="{{url('https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/js/gijgo.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('asetsba2/js/demo/datatables-demo.js')}}"></script>

    <script>
    $(document).ready(function() {
        var dt = $('#tabelpesanan').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route('tabel.pesanansaprodi')}}',
            columns: [{
                    data: 'idpesanan',
                    name: 'idpesanan'
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
    @for($i = 1; $i <=15; $i++)
            $('#idsaprodi{{$i}}').change(function () {
                var id = $(this).val();
                $.ajax({
                    url: "/hargasaprodi/" + id,
                    method: "POST",
                    data: {id: id},
                    async: true,
                    dataType: 'json',
                    success: function (x) {  
                        $.each(x, function (index, z) {        
                            
                            $('#harga{{$i}}').val(z.hargasatuan);
                            var kode = $("#kebutuhan{{$i}}").val();
                            var harga = $("#harga{{$i}}").val();
                            var jumlah = harga * kode;
                            $("#jumlah{{$i}}").val(jumlah);
                    });
                    }
                });
                return false;
                
            });
    @endfor
    $(".only-numeric").bind("keypress", function (e) {
          var keyCode = e.which ? e.which : e.keyCode
               
          if (!(keyCode >= 48 && keyCode <= 57)) {
            $(".error").css("display", "inline");
            return false;
          }else{
            $(".error").css("display", "none");
          }
      });
    });

    @for($i = 1; $i <=15; $i++)
    $('#kebutuhan{{$i}}').keyup(function () {
            var kode = $("#kebutuhan{{$i}}").val();
            var harga = $("#harga{{$i}}").val();
            var jumlah = harga * kode;
            $("#jumlah{{$i}}").val(jumlah);
        });
        @endfor
</script>
@endpush
