<?php

namespace App\Http\Controllers\pertanian;

use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect,Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;


class rencanatanamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nikuser = Auth::User()->nik;
        if(request()->ajax()) 
        {
 
         $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
         $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');
 
         $data = Event::whereDate('start', '>=', $start)->whereDate('end',   '<=', $end)->get(['id','title','start', 'end']);
         return Response::json($data);
        }

        
        $lahan = DB::table('lahan')->where('nik','=', $nikuser)->get();
        $sop = DB::table('soppertanian')->get();
        $jenis = DB::table('jenistanaman')->get();
        
        return view('pertanian.rencanatanam',compact('lahan','sop','jenis'));
    }

    public function tabelhistori()
    {
        return DataTables::of(DB::table('jadwaltanam')
            ->join('soppertanian', 'soppertanian.idversi', '=', 'jadwaltanam.idversi')
            ->join('lahan', 'lahan.idlahan', '=', 'jadwaltanam.idlahan')
            ->join('jenistanaman', 'jenistanaman.idjenis', '=', 'jadwaltanam.idjenis')
            ->select('jadwaltanam.*','soppertanian.versisop as versisop','lahan.namalahan as namalahan','jenistanaman.jenistanaman as jenis')
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
        $idversi = $request->get('idversi');
        $metode = $request->get('metode');
        $tgltanam = $request->get('tgltanam');
        $idjenis = $request->get('idjenis');
        $komoditas = $request->get('komoditas');

        DB::table('jadwaltanam')->insert([
            'idlahan' => $idlahan,
            'idversi' => $idversi,
            'metode' => $metode,
            'tgltanam' => $tgltanam,
            'idjenis' => $idjenis,
            'komoditas' => $komoditas
            ]);
    
    \Session::flash("flash_notification", [
    "level" => "success",
    "message" => "Berhasil menambah data!"
    ]);

    return redirect('rencanatanam');
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
