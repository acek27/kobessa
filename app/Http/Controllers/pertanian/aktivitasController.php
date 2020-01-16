<?php

namespace App\Http\Controllers\pertanian;

use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect,Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;


class aktivitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nikuser = Auth::User()->nik;
        $lahan = DB::table('lahan')->where('nik','=', $nikuser)->get();

        $fase = DB::table('fasetanam')->get();
               
        return view('pertanian.aktivitas',compact('lahan','fase'));
    }

    public function tabelaktivitas()
    {
        return DataTables::of(DB::table('aktivitaspetani')
            ->join('soptanidetail', 'soptanidetail.idsop', '=', 'aktivitaspetani.idsop')
            ->join('lahan', 'lahan.idlahan', '=', 'aktivitaspetani.idlahan')
            ->join('fasetanam', 'fasetanam.idfase', '=', 'soptanidetail.idfase')
            ->select('aktivitaspetani.*','soptanidetail.kegiatan as aktivitas','lahan.namalahan as namalahan','fasetanam.namafase as namafase')
            ->get())
                        ->make(true);
    }

    public function sopdetail($id)
    {
        $data = DB::table('soptanidetail')->where('idfase', '=', $id)
            ->get();
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $idlahan = $request->get('idlahan');
        $idsop = $request->get('idsop');
        $biaya = $request->get('biaya');
        $biayaisi = str_replace(".","",$biaya);
        $keterangan = $request->get('keterangan');
        $foto = $request->get('foto');
      

        DB::table('aktivitaspetani')->insert([
            'idlahan' => $idlahan,
            'idsop' => $idsop,
            'biaya' => $biayaisi,
            'keterangan' => $keterangan,
            'foto' => $foto
           
            ]);
    
    \Session::flash("flash_notification", [
    "level" => "success",
    "message" => "Berhasil menambah data!"
    ]);

    return redirect('aktivitas');
    }

 

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
