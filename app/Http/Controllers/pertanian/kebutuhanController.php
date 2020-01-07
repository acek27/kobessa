<?php

namespace App\Http\Controllers\pertanian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class kebutuhanController extends Controller
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

    public function tabellahan()
    {
        return DataTables::of(DB::table('keanggotaanpoktan')
        ->join('kelompok', 'kelompok.idkelompok', '=', 'keanggotaanpoktan.idkelompok')
        ->join('lahan', 'lahan.idlahan', '=', 'keanggotaanpoktan.idlahan')
        ->join('biodatauser', 'lahan.nik', '=', 'biodatauser.nik')
        ->join('desa', 'desa.iddesa', '=', 'kelompok.iddesa')

            ->select('keanggotaanpoktan.*','biodatauser.nama as nama','lahan.namalahan as namalahan','lahan.luaslahan as luaslahan','biodatauser.nik as nik','biodatauser.alamat as alamat', 'desa.namadesa as namadesa', 'kelompok.namakelompok as namakelompok')
            ->get())
            ->addColumn('action', function ($data) {
                $pilih = "<a href=\"" . route('kebutuhansaprodi.show', $data->idkeanggotaan) . "\"><i class=\"material-icons\" title=\"Data Kebutuhan Saprodi\">Pilih</i></a>";
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
        return view('pertanian.kebutuhansaprodi');
        
    }
    public function cari()
    {

        return view('pertanian.carilahan');
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
            $id = $request->get('idkeanggotaan');
            $idlahan = $request->get('idlahan');
            $idsaprodi = $request->get('idsaprodi'.$i);
            $kebutuhan = $request->get('kebutuhan'.$i);
            if ($idsaprodi != null || $kebutuhan != null){
                DB::table('kebutuhansaprodi')->insert([
                    'idlahan' => $idlahan,
                    'idsaprodi' => $idsaprodi,
                    'kebutuhan' => $kebutuhan
                    ]);
            }
       
        }
        \Session::flash("flash_notification", [
            "level" => "success",
            "message" => "Berhasil menambah data petani : $request->nama"
        ]);
        
        return redirect('/kebutuhansaprodi'.'/'.$id);

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
         $data = DB::table('keanggotaanpoktan')
         ->join('kelompok', 'kelompok.idkelompok', '=', 'keanggotaanpoktan.idkelompok')
         ->join('lahan', 'lahan.idlahan', '=', 'keanggotaanpoktan.idlahan')
         ->join('biodatauser', 'lahan.nik', '=', 'biodatauser.nik')
         ->join('desa', 'desa.iddesa', '=', 'kelompok.iddesa')
            ->where('idkeanggotaan', '=', $id)->get();
        return view('pertanian.kebutuhansaprodi', compact('data', 'saprodi'));
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
