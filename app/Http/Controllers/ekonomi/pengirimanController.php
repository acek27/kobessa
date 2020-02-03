<?php

namespace App\Http\Controllers\ekonomi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use App\order;


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
        $idsuplier = Auth::User()->nik;
        return DataTables::of(DB::table('pesanansaprodi')
            ->select('PO', 'tglpesan', 'status', 'tglkirim', 'biodatauser.nama as nama', 'desa.namadesa as namadesa', 'kecamatan.kecamatan as namakecamatan', DB::raw('count(PO) as user_count'))
            ->join('biodatauser', 'pesanansaprodi.nik', '=', 'biodatauser.nik')
            ->join('desa', 'desa.iddesa', '=', 'biodatauser.iddesa')
            ->join('kecamatan', 'kecamatan.idkecamatan', '=', 'desa.idkecamatan')
            ->where('idsuplier','=',$idsuplier)
            ->groupBy('PO', 'tglpesan', 'status', 'tglkirim', 'biodatauser.nama', 'desa.namadesa', 'kecamatan.kecamatan')
            ->get())
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return "Belum Disetujui";
                } elseif ($data->status == 2) {
                    return "Disetujui";
                } elseif ($data->status == 3) {
                    return "Dalam Pengiriman";
                } elseif ($data->status == 4) {
                    return "Telah Diterima Petani";
                } elseif ($data->status == 9) {
                    return "Pesanan Ditolak";
                }
            })
            ->addColumn('action', function ($data) {
                $pilih = "<a href=\"" . route('pengiriman.show', $data->PO) . "\"><i class=\"fa fa-search\" title=\"Data Pesanan\"></i></a>";
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

    public function order($id, Request $request)
    {
        $status = $request->get('status');
        if ($status == 1) {
            order::where('PO', $id)->update(
                ['status' => 2]
            );
            $count = order::where('PO', $id)->count('*');
            for ($i = 1; $i <= $count; $i++) {
                order::where('PO', $id)->where('idpesanan', $request->get('idpesanan' . $i))->update([
                        'jumlahkirim' => $request->get('jumlahkirim' . $i),
                        'DO' => $id,
                        'tglpengiriman' => date('yy-m-d')
                    ]
                );
            }
        } elseif ($status == 2) {
            order::where('PO', $id)->update(
                ['status' => 3]
            );
        }
//        $order = order::where('PO', $id)->findOrFail();
//        if ($order->status == 1) {
//            $order->status = 2;
//            $order->update();
//        } elseif ($order->status == 2){
//            $order->status = 3;
//            $order->update();
//        }
        return redirect()->route('pesanan.cari');
    }

    public function tolaksaprodi($id)
    {
        order::where('PO', $id)->update(
            ['status' => 9]
        );
        return redirect()->route('pesanan.cari');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $saprodi = DB::table('saprodi')->get();
        $pesanan = DB::table('pesanansaprodi')
            ->join('suplier', 'suplier.idsuplier', '=', 'pesanansaprodi.idsuplier')
            ->join('biodatauser', 'biodatauser.nik', '=', 'pesanansaprodi.nik')
            ->join('saprodi', 'saprodi.idsaprodi', '=', 'pesanansaprodi.idsaprodi')
            ->select('jumlahkirim', 'idpesanan', 'biodatauser.nama as namapemesan', 'biodatauser.alamat as alamat', 'biodatauser.telp as telp', 'pesanansaprodi.jumlah as jumlah', 'saprodi.namasaprodi as nama', 'pesanansaprodi.tglpesan as tglpesan', 'pesanansaprodi.tglkirim as tglkirim','status')
            ->where('PO', '=', $id)->get();

        $pesanan2 = DB::table('pesanansaprodi')
            ->join('suplier', 'suplier.idsuplier', '=', 'pesanansaprodi.idsuplier')
            ->join('biodatauser', 'biodatauser.nik', '=', 'pesanansaprodi.nik')
            ->join('saprodi', 'saprodi.idsaprodi', '=', 'pesanansaprodi.idsaprodi')
            ->select('biodatauser.nama as namapemesan', 'PO', 'status', 'biodatauser.alamat as alamat', 'biodatauser.telp as telp', 'pesanansaprodi.jumlah as jumlah', 'saprodi.namasaprodi as nama', 'pesanansaprodi.tglpesan as tglpesan', 'pesanansaprodi.tglkirim as tglkirim')
            ->where('PO', '=', $id)->first();
        return view('ekonomi.pengirimansaprodi', compact('pesanan', 'saprodi', 'pesanan2'));
    }

    public function cari()
    {

        return view('ekonomi.caripesanan');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
