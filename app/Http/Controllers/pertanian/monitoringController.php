<?php

namespace App\Http\Controllers\pertanian;

use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect, Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;


class monitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
              return view('pertanian.monitoring');
    }

    public function tabelaktivitas()
    {
        $idppl = Auth::User()->id;
        return DataTables::of(DB::table('jadwalbertani')
            ->join('lahan','lahan.idlahan',"=",'jadwalbertani.idlahan')
            ->join('desappl','desappl.iddesa',"=",'lahan.iddesa')
            ->join('biodatauser','biodatauser.nik',"=",'lahan.nik')
            ->where('desappl.idppl', '=', $idppl)
            ->select('jadwalbertani.keterangan as keterangan1','jadwalbertani.tglaktivitas as tglaktivitas','jadwalbertani.status as status','jadwalbertani.aktivitas as aktivitas','jadwalbertani.tglpelaksanaan as tglpelaksanaan','lahan.namalahan as namalahan','biodatauser.nama as namapetani')
            ->where('jadwalbertani.keterangan','like', '%Terlambat%')
            ->get())
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return "Sudah dilaksanakan";
                }
                
            })
            ->make(true);
      
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
       
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\ResponsStoree
     */
   
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
