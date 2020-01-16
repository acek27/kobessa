@extends('layouts.masterdashboard')
@section('css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{url('https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/css/gijgo.min.css')}}" rel="stylesheet"/>
@endsection

@section('isi')

<!-- Baris ke 1 -->
<div class="row">
<div class="col-lg-6 mb-4">
    <!-- Project Card Example -->
    @foreach($data as $value)
    <form method="POST" action="{{route('kebutuhan.store')}}" role="form"> 
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
                </div>
</div>

<!-- BARIS ke 2 -->
<div class="row">
<div class="col-lg-4 mb-4">
      <div class="card shadow mb-4">
      <div class="card-header py-3">          
                        <h6 class="m-0 font-weight-bold text-primary">DATA KEBUTUHAN SAPRODI UNTUK 1x PANEN</h6>
                        </div>
    <div class="card-body">
    <table>
    <tr>
    <th>Nama Saprodi</th>
    <!-- <th>Harga Satuan</th> -->
    <th>Kebutuhan</th>
    <!-- <th>Jumlah</th> -->
    
    </tr>
    @for($i = 1; $i <=15; $i++)
    <tr>
    <td><select class="form-control form-control-user" id="idsaprodi{{$i}}" name="idsaprodi{{$i}}" >
    <option value="">-- Please select --</option>
        @foreach($saprodi as $values)
        <option value="{{$values->idsaprodi}}">{{$values->namasaprodi}} ({{$values->satuan}})</option>
        @endforeach
    </select></td>
    <!-- <td><input type="text" class="form-control form-control-user" id="harga{{$i}}" name="harga{{$i}}" aria-describedby="emailHelp" ></td> -->
    <td><input type="text" class="form-control form-control-user" id="kebutuhan{{$i}}" name="kebutuhan{{$i}}" aria-describedby="emailHelp" ></td>
    <!-- <td><input type="text" class="form-control form-control-user" id="jumlah{{$i}}" name="jumlah{{$i}}" aria-describedby="emailHelp" ></td> -->
    </tr>
    @endfor
    </table>
    
    <br>
    <br>
    <button class="btn btn-sm btn-primary shadow-sm">
        SIMPAN</button>
    
    </form>
    @endforeach
    </div>
    </div>
    </div>

    <br>
    <div class="col-lg-8 mb-4">
    <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Daftar Kebutuhan Saprodi</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
        <table class="table table-bordered" id="tabelkebutuhan" width="100%" cellspacing="0">
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
</div>

    </div>


@endsection
@push('script')
  <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="{{asset('asetsba2/js/demo/datatables-demo.js')}}"></script>

<script>
    $(document).ready(function() {
        var dt = $('#tabelkebutuhan').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route('tabel.kebutuhan')}}',
            columns: [{
                    data: 'idkebutuhansaprodi',
                    name: 'idkebutuhansaprodi'
                },
                {
                    data: 'namasaprodi',
                    name: 'namasaprodi'
                },
                {
                    data: 'kebutuhan',
                    name: 'kebutuhan'
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
@endpush