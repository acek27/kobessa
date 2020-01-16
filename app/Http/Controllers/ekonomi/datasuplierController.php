<?php

namespace App\Http\Controllers\ekonomi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;


class datasuplierController extends Controller
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

  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $desa = DB::table('desa')->get();
        $kecamatan = DB::table('kecamatan')->get();
        return view('ekonomi.datasuplier', compact('kecamatan', 'desa'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'telp' => 'numeric|required'
        ]);
        $nama = $request->get('nama');
        $siup = $request->get('siup');
        $tgl = $request->get('tgl');
        $alamat = $request->get('alamat');
        $iddesa = $request->get('iddesa');
        $telp = $request->get('telp');
 
        $pengecekan = DB::table('suplier')->select('*')
            ->where('siup', '=', $siup);

        if ($pengecekan->exists()) {
            DB::table('suplier')
                ->where('siup','=',$siup)
                ->update([
                'namasuplier' => $nama,
                'tglpendirian' => $tgl,
                'iddesa' => $iddesa,
                'alamatsuplier' => $alamat,
                'telpsuplier' => $telp

            ]);
            
            \Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Data Suplier $request->nama Berhasil diupdate!"
            ]);
        } else {
           DB::table('suplier')->insert([
                'namasuplier' => $nama,
                'siup' => $siup,
                'tglpendirian' => $tgl,
                'iddesa' => $iddesa,
                'alamatsuplier' => $alamat,
                'telpsuplier' => $telp
            ]);

            \Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Berhasil menambah data Suplier : $request->nama"
            ]);
        }

        return redirect('/datasuplier/create');
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
        DB::table('suplier')->where('idsuplier', '=', $id)->delete();
    }
}
