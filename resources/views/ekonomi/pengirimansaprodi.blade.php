@extends('layouts.masterdashboard')
@section('css')
    <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{url('https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/css/gijgo.min.css')}}"
          rel="stylesheet"/>
@endsection

@section('isi')
    <!-- Page Heading -->
    <div class="col-lg-6 mb-4">
        <!-- Project Card Example -->

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DATA PEMESAN SAPRODI</h6>
            </div>
            <div class="card-body">

                <label style="color:black">Nama Pemesan : {{$pesanan2->namapemesan}} </label> <br>
                <label style="color:black">Alamat Pemesan : {{$pesanan2->alamat}} </label> <br>
                <label style="color:black">No Telp Pemesan : {{$pesanan2->telp}} </label> <br>
                <label style="color:black">Tgl Pesan Saprodi : {{$pesanan2->tglpesan}} </label> <br>
                <label style="color:black">Tgl Permintaan dikirim : {{$pesanan2->tglkirim}} </label> <br>

            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">DATA KEBUTUHAN SAPRODI</h1>
                </div>
                <br>
                <form method="POST" action="{{route('order.saprodi',$pesanan2->PO)}}" role="form">
                    @csrf
                    <table>
                        <tr>
                            <th>Nama Saprodi</th>
                            <th>Kebutuhan</th>
                            <th>Jumlah Dikirim</th>

                        </tr>
                        @php($i = 0)
                        @foreach($pesanan as $value)
                            <tr>
                                <td><input type="text" class="form-control form-control-user" id="idpesanan"
                                           value="{{$value->idpesanan}}" name="idpesanan{{$i+1}}"
                                           aria-describedby="emailHelp" hidden>
                                    <input type="text" class="form-control form-control-user" id="nama"
                                           value="{{$value->nama}}" name="nama{{$i+1}}" aria-describedby="emailHelp"
                                           disabled>
                                </td>
                                <td><input type="text" class="form-control form-control-user" id="kebutuhan"
                                           value="{{$value->jumlah}}" name="kebutuhan{{$i+1}}"
                                           aria-describedby="emailHelp"
                                           disabled></td>
                                <td><input type="text" class="form-control form-control-user" id="jumlahkirim{{$i+1}}"
                                           value="{{$value->jumlahkirim}}" name="jumlahkirim{{$i+1}}"
                                           aria-describedby="emailHelp" @if($value->status > 1) disabled @endif>
                                </td>
                            </tr>
                            @php($i++)
                        @endforeach
                    </table>
                    <br>
                    <br>
                    <input type="text" class="form-control form-control-user" id="status"
                           name="status" value="{{$pesanan2->status}}" hidden>
                    @if($pesanan2->status == 1)
                        <button class="btn btn-sm btn-primary shadow-sm"><i class="fa fa-check"> SETUJUI</i></button>
                        <a class="btn btn-sm btn-danger" href="{{route('tolak.saprodi',$pesanan2->PO)}}"><i
                                class="fa fa-ban" style="color: white"> TOLAK</i></a>
                    @elseif($pesanan2->status == 2)
                        <button class="btn btn-sm btn-primary shadow-sm"><i class="fa fa-truck"> KIRIM SEKARANG</i>
                        </button>
                    @elseif($pesanan2->status == 3)
                        <p style="color: darkblue">Menunggu diterima oleh petani</p>
                    @elseif($pesanan2->status == 4)
                        <p style="color: green">Saprodi telah diterima oleh petani</p>
                    @elseif($pesanan2->status == 9)
                        <p style="color: darkred">Pesanan Ditolak</p>
                    @endif

                </form>
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
        $(function () {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
            });
        });

    </script>
@endpush
