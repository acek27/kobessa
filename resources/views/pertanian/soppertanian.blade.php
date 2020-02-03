@extends('layouts.masterdashboard')
@section('css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection

@section('isi')
<ul class="nav nav-tabs" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" href="#saprodi-tab1" role="tab" aria-selected="false" data-toggle="tab">SOP PERTANIAN</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#saprodi-tab2" role="tab" data-toggle="tab">DETAIL SOP PERTANIAN</a>
  </li>
 </ul>

<!-- Tab panes -->
<div class="tab-content">
  <div role="tabpanel" class="tab-pane fade in active show" id="saprodi-tab1">
  <br>
            <div class="row">
                        <div class="col-lg-12 mb-4">
                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">DAFTAR SOP PERTANIAN</h6>
                            </div>
                            <div class="card-body">
                               
                                @if (session()->has('flash_notification.message'))
                                <div class="alert alert-{{ session()->get('flash_notification.level') }}">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {!! session()->get('flash_notification.message') !!}
                                </div>
                                @endif
                            
                                <form method="POST" action="{{route('soppertanian.save')}}" role="form">
                                @csrf
                                    <label style="color:black">Nama SOP Pertanian</label>
                                    <input type="text" class="form-control form-control-user" id="versi" name="versi" aria-describedby="emailHelp" required>
                                    <label style="color:black">Pemilik SOP</label>
                                    <input type="text" class="form-control form-control-user" id="pemilik" name="pemilik" aria-describedby="emailHelp" required>
                                    <label style="color:black">Untuk Jenis Tanaman</label>
                                    <select class="form-control show-tick" id="idjenis" name="idjenis" required>
                                    <option value="">-- Please select --</option>
                                    @foreach($jenis as $values)
                                    <option value="{{$values->idjenis}}">{{$values->jenistanaman}}</option>
                                    @endforeach
                                    </select>
                                    <br>
                                <button type="submit" style="align-center" class="btn-sm btn-primary shadow-sm">
                                    SIMPAN</button>
                                
                                </form>
                            </div>
                            </div>
                        </div>
                        </div>

             <div class="row">
                        <div class="col-lg-12 mb-4">
                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">SOP PERTANIAN TERDAFTAR</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table class="table table-striped table-bordered table-condensed" id="saprodi-tab1-dt" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th style="width: 40%; text-align: left; vertical-align: middle" >Nama SOP</th>
                                            <th style="width: 40%; text-align: left; vertical-align: middle" >Pemilik SOP</th>
                                            <th style="width: 40%; text-align: left; vertical-align: middle" >Untuk Tanaman</th>
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
  
  </div>
  <div role="tabpanel" class="tab-pane fade" id="saprodi-tab2">
  <br>
                            <div class="col-lg-12 mb-4">
                            <div class="card shadow mb-4">
                            <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Detail SOP Pertanian</h6>  
                            </div>
                            <div class="card-body">
                            @if (session()->has('flash_notification.message'))
                                    <div class="alert alert-{{ session()->get('flash_notification.level') }}">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        {!! session()->get('flash_notification.message') !!}
                                    </div>
                                @endif
                            <form method="POST" action="{{route('soppertanian.store')}}" role="form">
                                @csrf
                                <label style="color:black">Nama SOP</label>
                                <select class="form-control show-tick" id="idversisop" name="idversisop" required>
                                    <option value="">-- Please select --</option>
                                    @foreach($versi as $values)
                                    <option value="{{$values->idversi}}">{{$values->versisop}}</option>
                                    @endforeach
                                </select>
                                <label style="color:black">Fase</label>
                                <select class="form-control show-tick" id="idfase" name="idfase" required>
                                    <option value="">-- Please select --</option>
                                    @foreach($fase as $values)
                                    <option value="{{$values->idfase}}">{{$values->namafase}}</option>
                                    @endforeach
                                </select>
                                <label style="color:black">Nama Kegiatan</label>
                                <input type="text" class="form-control form-control-user" id="nama" name="nama" aria-describedby="emailHelp" required>
                                <label style="color:black">Waktu Kegiatan (Hst)</label>
                                <input type="text" class="form-control form-control-user" id="waktu" name="waktu" aria-describedby="emailHelp" required>
                                <br>
                                <button class="btn btn-sm btn-primary shadow-sm">
                                    SIMPAN</button>
                            </form>
                            </div>
                            </div>
                            </div>

                            <br>
                            <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Data Detail SOP Pertanian</h6>
                                        </div>
                                        <div class="card-body">
                                        <div class="table-responsive">
                                    <table class="table table-bordered" id="saprodi-tab2-dt" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th style="width: 50%; text-align: left; vertical-align: middle" >Nama SOP</th>
                                                <th style="width: 50%; text-align: left; vertical-align: middle" >Fase Tanam</th>
                                                <th style="width: 40%; text-align: left; vertical-align: middle" >Kegiatan</th>
                                                <th style="width: 40%; text-align: left; vertical-align: middle" >Waktu</th>
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
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script> -->
  
<script>
    $(document).ready(function() {
       var tab1 = $('#saprodi-tab1-dt').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route('tabel.versisop')}}',
            columns: [{
                    data: 'idversi',
                    name: 'idversi'
                },
                {
                    data: 'versisop',
                    name: 'versisop'
                },
                {
                    data: 'pemiliksop',
                    name: 'pemiliksop'
                },
                {
                    data: 'jenis',
                    name: 'jenis'
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


        var tab2 = $('#saprodi-tab2-dt').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route('tabel.soptani')}}',
            columns: [{
                    data: 'idsop',
                    name: 'idsop'
                },
                {
                    data: 'namasop',
                    name: 'namasop'
                },
                {
                    data: 'fase',
                    name: 'fase'
                },
                {
                    data: 'kegiatan',
                    name: 'kegiatan'
                },
                {
                    data: 'waktu',
                    name: 'waktu'
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
$(document).ready(function() {
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
                            url: "{{route('soppertanian.index')}}/" + id,
                            method: "DELETE",
                        }).done(function (msg) {
                         dt.ajax.reload();
                            $('#nama').val("");
                            $('#waktu').val("");
                            $('#idsop').val("");
                            $('#idfase').val("");
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

            $('body').on("click", '.edit-modal', function () {
                var idjenis = $(this).attr('data-id');
                $.ajax({
                    url: "/soppertanian/"+ idsop+"/edit",
                    type: 'GET',
                    datatype: 'json',
                    success: function (x) {
                        $.each(x, function (index, z) {
                            $('#nama').val(z.kegiatan);
                            $('#waktu').val(z.waktu);
                            $('#id').val(z.idsop);
                            $('#idfase').val(z.idfase);
                            $('#simpan').text("UPDATE");
                        });

                    }
                });
            });
});
</script>

@endpush