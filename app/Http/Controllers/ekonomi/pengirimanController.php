<?php

namespace App\Http\Controllers\ekonomi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;


class pengirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    public function tabelpesanan()
    {
        return DataTables::of(DB::table('pesanansaprodi')
            ->select('PO','tglpesan','tglkirim','biodatauser.nama as nama','desa.namadesa as namadesa','kecamatan.kecamatan as namakecamatan',DB::raw('count(PO) as user_count'))
            ->join('biodatauser','pesanansaprodi.nik','=','biodatauser.nik')
            ->join('desa','desa.iddesa','=','biodatauser.iddesa')
            ->join('kecamatan','kecamatan.idkecamatan','=','desa.idkecamatan')
            ->groupBy('PO','tglpesan','tglkirim','biodatauser.nama','desa.namadesa','kecamatan.kecamatan')
            ->get())
            ->addColumn('action', function ($data) {
                $pilih = "<a href=\"" . route('pengiriman.show', $data->PO) . "\"><i class=\"material-icons\" title=\"Data Pesanan\">Pilih</i></a>";
                return $pilih;
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $saprodi = DB::table('saprodi')->get();
         $pesanan = DB::table('pesanansaprodi')
         ->join('suplier','suplier.idsuplier', '=', 'pesanansaprodi.idsuplier')
         ->join('biodatauser','biodatauser.nik', '=', 'pesanansaprodi.nik')
         ->join('saprodi','saprodi.idsaprodi', '=', 'pesanansaprodi.idsaprodi')
         ->select('biodatauser.nama as namapemesan','biodatauser.alamat as alamat','biodatauser.telp as telp','pesanansaprodi.jumlah as jumlah','saprodi.namasaprodi as nama','pesanansaprodi.tglpesan as tglpesan','pesanansaprodi.tglkirim as tglkirim')
         ->where('PO', '=', $id)->get();

         $pesanan2 = DB::table('pesanansaprodi')
         ->join('suplier','suplier.idsuplier', '=', 'pesanansaprodi.idsuplier')
         ->join('biodatauser','biodatauser.nik', '=', 'pesanansaprodi.nik')
         ->join('saprodi','saprodi.idsaprodi', '=', 'pesanansaprodi.idsaprodi')
         ->select('biodatauser.nama as namapemesan','biodatauser.alamat as alamat','biodatauser.telp as telp','pesanansaprodi.jumlah as jumlah','saprodi.namasaprodi as nama','pesanansaprodi.tglpesan as tglpesan','pesanansaprodi.tglkirim as tglkirim')

         ->where('PO', '=', $id)->first();

        return view('ekonomi.pengirimansaprodi', compact('pesanan', 'saprodi','pesanan2'));
    }

    public function cari()
    {

        return view('ekonomi.caripesanan');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
