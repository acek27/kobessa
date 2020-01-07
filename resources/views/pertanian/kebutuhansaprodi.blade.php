@extends('layouts.masterdashboard')
@section('css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection

@section('isi')
<!-- Page Heading -->
<div class="col-lg-6 mb-4">
    <!-- Project Card Example -->
    @foreach($data as $value)
    <form method="POST" action="{{route('kebutuhansaprodi.store')}}" role="form"> 
    @csrf   
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">DATA PETANI</h6>
                    </div>
                       <div class="card-body">
                            
                                 <label style="color:black">Nama Petani : {{$value->nama}} </label> <br>
                                 <label style="color:black">Nama Lahan : {{$value->namalahan}} </label> <br>
                                 <label style="color:black">Luas Lahan : {{$value->luaslahan}} Ha </label> <br>
                                 <label style="color:black">Kelompok : {{$value->namakelompok}} </label> <br>
                                 <input type="text" class="form-control form-control-user" id="idlahan" value="{{$value->idlahan}}" name="idlahan" hidden>
                                 <input type="text" class="form-control form-control-user" id="idkeanggotaan" value="{{$value->idkeanggotaan}}" name="idkeanggotaan" hidden>
                         </div>
                </div>
      <div class="card shadow mb-4">
      <div class="card-header py-3">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">DATA KEBUTUHAN SAPRODI</h1>
                        </div>
    <table>
    <tr>
    <th>Nama Saprodi</th>
    <th>Harga Satuan</th>
    <th>Kebutuhan</th>
    <th>Jumlah</th>
    
    </tr>
    @for($i = 1; $i <=15; $i++)
    <tr>
    <td><select class="form-control form-control-user" id="idsaprodi{{$i}}" name="idsaprodi{{$i}}" >
    <option value="">-- Please select --</option>
        @foreach($saprodi as $values)
        <option value="{{$values->idsaprodi}}">{{$values->namasaprodi}} ({{$values->satuan}})</option>
        @endforeach
    </select></td>
    <td><input type="text" class="form-control form-control-user" id="harga{{$i}}" name="harga{{$i}}" aria-describedby="emailHelp" ></td>
    <td><input type="text" class="form-control form-control-user" id="kebutuhan{{$i}}" name="kebutuhan{{$i}}" aria-describedby="emailHelp" ></td>
    <td><input type="text" class="form-control form-control-user" id="jumlah{{$i}}" name="jumlah{{$i}}" aria-describedby="emailHelp" ></td>
    </tr>
    @endfor
        
    </table>
    <button class="add"> Tambah </button>
    <br>
    <br>
    <button class="btn btn-sm btn-primary shadow-sm">
        SIMPAN</button>
        </div>
        </div>
    </form>
    @endforeach
    </div>
@endsection
