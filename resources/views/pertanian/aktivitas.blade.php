@extends('layouts.masterdashboard')
@section('css')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"/>
    <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css"/>
    <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{url('https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/css/gijgo.min.css')}}"
          rel="stylesheet"/>

@endsection

@section('isi')
    <!-- Page Heading -->
    <div class="row">
        <!-- Content Column Ke 1-->
        <div class="col-lg-4 mb-4">
            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aktivitas Petani</h6>
                </div>
                <div class="card-body">
                    @if (session()->has('flash_notification.message'))
                        <div class="alert alert-{{ session()->get('flash_notification.level') }}">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {!! session()->get('flash_notification.message') !!}
                        </div>
                    @endif
                    <form method="POST" action="{{route('aktivitas.store')}}" role="form">
                        @csrf
                        <label style="color:red ">Tanggal Hari Ini : {{date("d M Y")}}</label>
                        <br>
                        <label style="color:black">Nama Lahan</label>
                        <select class="form-control show-tick" id="idlahan" name="idlahan" required>
                            <option value="">-- Please select --</option>
                            @foreach($lahan as $values)
                                <option value="{{$values->idlahan}}">{{$values->namalahan}}</option>
                            @endforeach
                        </select>
                        <br>
                        <label style="color:black">Aktivitas</label>
                        <input type="text" class="form-control uang" id="idbertani" name="idbertani"
                               aria-describedby="emailHelp" hidden>
                        <p style="color: green" id="aktivitas">-</p>
                        <label style="color:black">Keterangan</label>
                        <p id="keterangan">-</p>
                        <div class="row card-body divaktivitas" style="display: none">
                            <label style="color:black">Sudah Dilakukan?</label>
                            <button type="submit" class="btn btn-sm btn-success shadow-sm" style="margin-left: 10px">
                                YA
                            </button>
                            <a href="#" class="btn btn-sm btn-danger shadow-sm hapus-data" style="margin-left: 10px">
                                TIDAK
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="col-lg-8 mb-4">
            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Histori Aktivitas Petani</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tabelaktivitas">
                            <thead style="text-align: center">
                            <tr>
                                <th style="width: 15%">Tanggal Aktivitas</th>
                                <th>Aktivitas</th>
                                <th style="width: 15%">Tanggal Pelaksanaan</th>
                                <th>Status</th>
                                <th style="width: 20%">Keterangan</th>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"
            integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    <script src="{{url('https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/js/gijgo.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('asetsba2/js/demo/datatables-demo.js')}}"></script>


    <script>
        $(document).ready(function () {
            var dt = $('#tabelaktivitas').DataTable({
                processing: true,
                serverSide: true,
                ajax: 'tabelaktivitas/0',
                columns: [{
                    data: 'tglaktivitas',
                    name: 'tglaktivitas'
                },
                    {
                        data: 'aktivitas',
                        name: 'aktivitas'
                    },
                    {
                        data: 'tglpelaksanaan',
                        name: 'tglpelaksanaan'
                    },
                    {data: 'status', name: 'status', orderable: false, searchable: false, align: 'center'},
                    {data: 'keterangan', name: 'keterangan', orderable: false, searchable: false, align: 'center'},
                ]
            });

            $('#idlahan').change(function () {
                var id = $(this).val();
                $.ajax({
                    url: "/aktivitasdetail/" + id,
                    method: "POST",
                    data: {id: id},
                    async: true,
                    dataType: 'json',
                    success: function (data) {
                        dt.ajax.url('tabelaktivitas/' + id).load();
                        $('#idbertani').val(data.idbertani);
                        $('#aktivitas').text(data.aktivitas);
                        var current = new Date();
                        var date = new Date(data.tglaktivitas);
                        var selisih = new Date(current - date);
                        var days = selisih / 1000 / 60 / 60 / 24;
                        if (data.aktivitas != null) {
                            if (Math.round(days) <= 0) {
                                var num = Math.round(days);
                                $('#keterangan').text("Aktivitas yang harus dilakukan adalah "
                                    + data.aktivitas + ". Waktu pelaksanaan kurang dari " +
                                    Math.abs(num) + " hari.");
                            } else {
                                $('#keterangan').text("PERHATIAN!! Aktivitas yang harus dilakukan adalah "
                                    + data.aktivitas + ". anda telah melewati " +
                                    Math.round(days) + " dari tanggal pelaksanaan.");
                            }
                        }
                        $('.divaktivitas').show('true');
                    }
                });
                return false;
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
                            url: "tolakaktivitas/" + id,
                            method: "POST",
                        }).done(function (msg) {
                            dt.ajax.reload();
                            // swal("Deleted!", "Data sudah terhapus.", "success");
                        }).fail(function (textStatus) {
                            alert("Request failed: " + textStatus);
                        });
                    }, function (dismiss) {
                        // dismiss can be 'cancel', 'overlay', 'esc' or 'timer'
                        // swal("Cancelled", "Data batal dihapus", "error");
                    });
            };
            $('body').on('click', '.hapus-data', function () {
                del($("#idbertani").val());
            });
        });

        $(function () {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
            });
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>


@endpush
