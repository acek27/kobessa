@extends('layouts.masterdashboard')
@section('css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{url('https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/css/gijgo.min.css')}}" rel="stylesheet"/>
@endsection

@section('isi')
<!-- Page Heading -->
<div class="col-lg-6 mb-4">
    <!-- Project Card Example -->
    <form method="POST" action="{{route('ordersaprodi.store')}}" role="form"> 
    @csrf   
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">DATA PEMESAN SAPRODI</h6>
                    </div>
                       <div class="card-body">
                            
                                 <label style="color:black">Nama Pemesan : {{$pesanan2->namapemesan}} </label> <br>
                                 <label style="color:black">Alamat Pemesan : {{$pesanan2->alamat}} </label> <br>
                                 <label style="color:black">No Telp Pemesan  : {{$pesanan2->telp}} </label> <br>
                                 <label style="color:black">Tgl Pesan Saprodi : {{$pesanan2->tglpesan}} </label> <br>
                                 <label style="color:black">Tgl Permintaan dikirim : {{$pesanan2->tglkirim}} </label> <br>
                                
                                 </div>
                </div>
      <div class="card shadow mb-4">
      <div class="card-header py-3">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">DATA KEBUTUHAN SAPRODI</h1>
                        </div>
    <label style="color:black">Tanggal Pengiriman </label> <br>
    <input type="text" class="form-control datepicker" id="datepicker"  name="tglkirim">
    <br>
    <table>
    <tr>
    <th>Nama Saprodi</th>
    <th>Kebutuhan</th>
    <th>Jumlah Dikirim</th>
    
    
    </tr>
    @foreach($pesanan as $value)
    <tr>
    <td><input type="text" class="form-control form-control-user" id="nama" value="{{$value->nama}}" name="nama" aria-describedby="emailHelp" disabled></td>
    <td><input type="text" class="form-control form-control-user" id="kebutuhan" value="{{$value->jumlah}}" name="kebutuhan" aria-describedby="emailHelp" disabled ></td>
    <td><input type="text" class="form-control form-control-user" id="jumlahkirim" name="jumlahkirim" aria-describedby="emailHelp" ></td>
   
    </tr>
        @endforeach
    </table>
    <br>
    <br>
    <button class="btn btn-sm btn-primary shadow-sm">
        SIMPAN</button>
        </div>
        </div>
    </form>
    </div>
@endsection

@push('script')
    <script src="{{url('https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/js/gijgo.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('asetsba2/js/demo/datatables-demo.js')}}"></script>

<script>
$(function () {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                });
            });

</script>
@endpush
