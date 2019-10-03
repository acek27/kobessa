<?php

namespace App\Http\Controllers\peternakan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class peternakController extends Controller
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
   

    public function tabelpeternak (){
        return DataTables::of(DB::table('datapeternak')
                ->join('kecamatan', 'datapeternak.idkecamatan', '=', 'kecamatan.idkecamatan')
                ->select('datapeternak.*', 'kecamatan.kecamatan as namakecamatan')
                ->get())
                ->addColumn('action', function ($data) {
                    $del = '<a href="#" data-id="' . $data->idpeternak . '" class="hapus-data"><i class="material-icons">delete</i></a>';
                    $edit = '<a href="#"><i class="material-icons">edit</i></a>';
                    return $edit . '&nbsp' . $del;
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
        // $data = DB::table('datapeternak')->get();
        $kecamatan = DB::table('kecamatan')->get();
        return view('peternakan.datapeternak',compact('kecamatan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nama = $request->get('nama');
        $alamat = $request->get('alamat');
        $nik = $request->get('nik');
        $telp = $request->get('telp');
        $idkecamatan = $request->get('idkecamatan');
        DB::table('datapeternak')->insert([
            'nik'      => $nik,
            'nama'      => $nama,
            'alamat'      => $alamat,
            'telp'      => $telp,
            'idkecamatan'     => $idkecamatan
        ]);

        \Session::flash("flash_notification", [
            "level" => "success",
            "message" => "Berhasil menambah peternak : $request->nama"
        ]);

        return redirect('/datapeternak/create');
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
