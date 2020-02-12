<?php

namespace App\Http\Controllers\pertanian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class soppertanianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard');
    }

    public function tabelsoptani()
    {
        return DataTables::of(DB::table('soptanidetail')
            ->join('soppertanian', 'soppertanian.idversi', '=', 'soptanidetail.idversi')
            ->join('fasetanam', 'fasetanam.idfase', '=', 'soptanidetail.idfase')
            ->select('soptanidetail.*', 'fasetanam.namafase as fase','soppertanian.versisop as namasop')
            ->get())
            ->make(true);
    }
    public function tabelversisop()
    {
        return DataTables::of(DB::table('soppertanian') 
        ->join('jenistanaman','soppertanian.idjenis','=','jenistanaman.idjenis')
        ->select('soppertanian.*','jenistanaman.jenistanaman as jenis')
        ->get())
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jenis = DB::table('jenistanaman')->get();
        $fase = DB::table('fasetanam')->get();
        $versi = DB::table('soppertanian')->get();
        return view('pertanian.soppertanian', compact('fase','versi','jenis'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $idfase = $request->get('idfase');
        $idversi = $request->get('idversisop');
        $nama = $request->get('nama');
        $waktu = $request->get('waktu');
        $ket = $request->get('ket');
       
            DB::table('soptanidetail')->insert([
                    'idfase'      => $idfase,
                    'idversi'      => $idversi,
                    'kegiatan'     => $nama,
                    'waktu'     => $waktu,
                    'keterangan' => $ket,

                ]);
        
                \Session::flash("flash_notification", [
                    "level" => "success",
                    "message" => "Berhasil menambah data!"
                ]);
        
               return redirect('/soppertanian/create');
    }

    public function save(Request $request)
    {
        $nama = $request->get('versi');
        $pemilik = $request->get('pemilik');
        $idjenis = $request->get('idjenis');
        DB::table('soppertanian')->insert([
                    'versisop'     => $nama,
                    'pemiliksop'     => $pemilik,
                    'idjenis'  => $idjenis

                ]);
        
                \Session::flash("flash_notification", [
                    "level" => "success",
                    "message" => "Berhasil menambah data!"
                ]);
        
               return redirect('/soppertanian/create');
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
