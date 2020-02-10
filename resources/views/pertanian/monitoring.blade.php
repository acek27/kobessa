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
        <div class="col-lg-12 mb-4">
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
                                <th style="width: 15%">Nama Petani</th>
                                <th style="width: 15%">Nama Lahan</th>
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
                ajax: 'tabelaktivitas',
                columns: [
                    {
                    data: 'namapetani',
                    name: 'namapetani'
                    },
                    {
                    data: 'namalahan',
                    name: 'namalahan'
                    },
                    {
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
                    {data: 'keterangan1', name: 'keterangan1', orderable: false, searchable: false, align: 'center'},
                ]
            });

        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>


@endpush
