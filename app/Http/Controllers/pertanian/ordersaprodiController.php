<?php

namespace App\Http\Controllers\pertanian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use App\order;


class ordersaprodiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pertanian/historypesanan');
    }

    public function create()
    {
        return view('pertanian.ordersaprodi');

    }

    public function show($id)
    {

        $nopo = DB::table('pesanansaprodi')->orderBy('PO', 'desc')->value('PO');

        $saprodi = DB::table('saprodi')->get();
        $suplier = DB::table('suplier')
            ->where('idsuplier', '=', $id)->get();

        // return $nopo;
        return view('pertanian.ordersaprodi', compact('suplier', 'saprodi', 'nopo'));

    }

    public function tabelsuplier()
    {
        return DataTables::of(DB::table('suplier')
            ->join('desa', 'desa.iddesa', '=', 'suplier.iddesa')
            ->join('kecamatan', 'desa.idkecamatan', '=', 'kecamatan.idkecamatan')
            ->select('suplier.*', 'desa.namadesa as namadesa', 'kecamatan.kecamatan as namakecamatan')
            ->get())
            ->addColumn('action', function ($data) {
                $pilih = "<a href=\"" . route('ordersaprodi.show', $data->idsuplier) . "\"><i class=\"material-icons\" title=\"Data Kebutuhan Saprodi\">Pilih</i></a>";
                return $pilih;
            })
            ->make(true);
    }

    public function tabelpesanansaprodi($id)
    {
        $nikuser = Auth::User()->nik;
        return DataTables::of(DB::table('pesanansaprodi')
            ->join('saprodi', 'saprodi.idsaprodi', '=', 'pesanansaprodi.idsaprodi')
            ->select('pesanansaprodi.*', 'saprodi.namasaprodi as namasaprodi', 'saprodi.satuan as satuan')
            ->where('nik', '=', $nikuser)
            ->where('idsuplier', '=', $id)
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
                $del = '<a href="#" data-id="' . $data->idpesanan . '" class="hapus-data"><i class="fas fa-trash"></i></a>';
                return $del;
            })
            ->make(true);
    }

    public function tabelhistory()
    {
        $nikuser = Auth::User()->nik;
        return DataTables::of(DB::table('pesanansaprodi')
            ->join('saprodi', 'saprodi.idsaprodi', '=', 'pesanansaprodi.idsaprodi')
            ->join('suplier', 'suplier.idsuplier', '=', 'pesanansaprodi.idsuplier')
            ->select('pesanansaprodi.*', 'saprodi.namasaprodi as namasaprodi', 'saprodi.satuan as satuan', 'suplier.namasuplier as namasuplier')
            ->where('nik', '=', $nikuser)
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
                if ($data->status == 3) {
                    $terima = '<a href="' . route('terima.saprodi', $data->PO) . '" class="terima-data"><i class="far fa-check-circle">Diterima</i></a>';
                    return $terima;
                }
            })
            ->make(true);
    }


    public function terimasaprodi($id)
    {
        order::where('PO', $id)->update(
            ['status' => 4]
        );
        return redirect()->route('ordersaprodi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function cari()
    {

        return view('pertanian.carisuplier');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        for ($i = 1; $i <= 15; $i++) {
            $idsuplier = $request->get('idsuplier');
            $tglkirim = $request->get('tglkirim');
//            $po = $request->get('po1');
            $nik = $request->get('nik');
            $todayDate = date("Y-m-d");
            $idsaprodi = $request->get('idsaprodi' . $i);
            $kebutuhan = $request->get('kebutuhan' . $i);
            date_default_timezone_set('Asia/Jakarta');
            $po = date('dmyHi').Auth::user()->id;
            if ($idsaprodi != null || $kebutuhan != null) {
                DB::table('pesanansaprodi')->insert([
                    'idsuplier' => $idsuplier,
                    'nik' => $nik,
                    'PO' => $po,
                    'idsaprodi' => $idsaprodi,
                    'jumlah' => $kebutuhan,
                    'tglpesan' => $todayDate,
                    'tglkirim' => $tglkirim,
                    'status' => 1
                ]);
            }

        }
        \Session::flash("flash_notification", [
            "level" => "success",
            "message" => "Berhasil menambah data petani : $request->nama"
        ]);

        return redirect('/ordersaprodi' . '/' . $idsuplier);


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */


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
