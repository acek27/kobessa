@extends('layouts.masterdashboard')
@section('css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{url('https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/css/gijgo.min.css')}}" rel="stylesheet"/>
@endsection

@section('isi')

<!-- Baris ke 1 -->
<div class="row">
<div class="col-lg-5 mb-4">
    <!-- Project Card Example -->
    <form method="POST" action="{{route('kebutuhan.store')}}" role="form"> 
    @csrf   
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">DATA KEBUTUHAN SAPRODI UNTUK LUAS LAHAN 1Ha</h6>
                    </div>
                       <div class="card-body">
                       <input type="text" class="form-control form-control-user" id="idsop" value="{{$idversi}}" name="idsop" hidden>
                       <table>
                        <tr>
                        <th>Nama Saprodi</th>
                        <th>Kebutuhan</th>
                        <th>Satuan</th>
                        @php($i = 1)
                        @foreach($saprodi as $values)
                            <tr>
                            <td><input type="text" class="form-control form-control-user" id="tampil{{$i}}" name="tampil{{$i}}" value="{{$values->namasaprodi}}" aria-describedby="emailHelp" ></td>
                            <td><input type="text" class="form-control form-control-user" id="kebutuhan{{$i}}" name="kebutuhan{{$i}}" aria-describedby="emailHelp" ></td>
                            <td><label style="color:black">{{$values->satuan}}</label></td>
                            <td><input type="text" class="form-control form-control-user" id="idsaprodi{{$i}}" name="idsaprodi{{$i}}" value="{{$values->idsaprodi}}" aria-describedby="emailHelp" hidden ></td>
                        </tr>
                        @php($i++)
                            @endforeach
                        </tr>

                        </table>
                        
                        <br>
                        <br>
                        <button class="btn btn-sm btn-primary shadow-sm">
                            SIMPAN</button> 
                        </form>   
                         </div>
                </div>
                </div>

    <div class="col-lg-7 mb-4">
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
            ajax: '{{route('tabel.kebutuhan',$idversi)}}',
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