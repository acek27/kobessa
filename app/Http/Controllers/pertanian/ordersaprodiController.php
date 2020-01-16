<?php

namespace App\Http\Controllers\pertanian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class ordersaprodiController extends Controller
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

    public function tabelsuplier()
    {
        return DataTables::of(DB::table('suplier')
            ->join('desa', 'desa.iddesa', '=', 'suplier.iddesa')
            ->join('kecamatan', 'desa.idkecamatan', '=', 'kecamatan.idkecamatan')
            ->select('suplier.*','desa.namadesa as namadesa','kecamatan.kecamatan as namakecamatan')
            ->get())
            ->addColumn('action', function ($data) {
                $pilih = "<a href=\"" . route('ordersaprodi.show', $data->idsuplier) . "\"><i class=\"material-icons\" title=\"Data Kebutuhan Saprodi\">Pilih</i></a>";
                return $pilih;
            })
            ->make(true);
    }
    public function tabelpesanansaprodi()
    {
        return DataTables::of(DB::table('pesanansaprodi')
        ->join('saprodi', 'saprodi.idsaprodi', '=', 'pesanansaprodi.idsaprodi')
        ->select('pesanansaprodi.*','saprodi.namasaprodi as namasaprodi','saprodi.satuan as satuan')
        ->get())
        ->addColumn('action', function ($data) {
            $del = '<a href="#" data-id="' . $data->idpesanan . '" class="hapus-data"><i class="fas fa-trash"></i></a>';
            $edit = '<a href="#" data-id="' . $data->idpesanan . '" class="edit-modal"><i class="fas fa-edit"></i></a>';
            return $edit . '&nbsp' . '&nbsp' . $del;
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
        return view('pertanian.ordersaprodi');
        
    }
    public function cari()
    {

        return view('pertanian.carisuplier');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
       
        for($i=1; $i<=15; $i++)
        {
            $idsuplier = $request->get('idsuplier');
            $tglkirim = $request->get('tglkirim');
            $po = $request->get('po1');
            $nik = $request->get('nik');
            $todayDate = date("Y-m-d");
            $idsaprodi = $request->get('idsaprodi'.$i);
            $kebutuhan = $request->get('kebutuhan'.$i);
            if ($idsaprodi != null || $kebutuhan != null){
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
        
        return redirect('/ordersaprodi'.'/'.$idsuplier);
    

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
          
            $nopo = DB::table('pesanansaprodi')->orderBy ('PO','desc')->value('PO');

         $saprodi = DB::table('saprodi')->get();
         $suplier = DB::table('suplier')
         ->where('idsuplier', '=', $id)->get();
        
        // return $nopo;
        return view('pertanian.ordersaprodi', compact('suplier', 'saprodi','nopo'));
        
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
