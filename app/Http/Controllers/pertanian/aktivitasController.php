<?php

namespace App\Http\Controllers\pertanian;

use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect, Response;
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
        $lahan = DB::table('lahan')->where('nik', '=', $nikuser)->get();

        return view('pertanian.aktivitas', compact('lahan'));
    }

    public function tabelaktivitas($id)
    {
        $nikuser = Auth::User()->nik;
        return DataTables::of(DB::table('jadwalbertani')
            ->where("idlahan", $id))
            ->addColumn('keterangan', function ($data) {
                $tglaktivitas = strtotime($data->tglaktivitas);
                $tglpelaksanaan = strtotime($data->tglpelaksanaan);
                $selisih = ($tglpelaksanaan - $tglaktivitas) / 60 / 60 / 24;
                if ($data->tglpelaksanaan != null) {
                    if ($selisih > 0) {
                        return "Telat " . abs($selisih) . " hari";
                    }elseif ($selisih == 0){
                        return "Tepat waktu";
                    }
                    else {
                        return "lebih awal " . abs($selisih) . " hari";
                    }
                }
            })
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return "Sudah dilaksanakan";
                }
            })
            ->make(true);
    }

    public
    function aktivitasdetail($id)
    {
        $data = DB::table('jadwalbertani')
            ->where('idlahan', '=', $id)
            ->where('status', '=', null)
            ->orderBy("tglaktivitas", "asc")
            ->first();
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public
    function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public
    function store(Request $request)
    {
        $idbertani = $request->get('idbertani');
        $lahan = $request->get('idlahan');
        $date = date('yy-m-d');

        DB::table('jadwalbertani')->where('idbertani', $idbertani)
            ->where('idlahan', $lahan)->update([
                'status' => 1,
                'tglpelaksanaan' => $date
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
     * @param int $id
     * @return \Illuminate\Http\ResponsStoree
     */
    public
    function tolakaktivitas($id)
    {
        DB::table('jadwalbertani')->where('idbertani', $id)->update([
            'status' => null,
            'tglpelaksanaan' => null
        ]);
    }

    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
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
    public
    function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        //
    }
}
