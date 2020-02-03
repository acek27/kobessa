<?php

namespace App\Http\Controllers\pertanian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class kepemilikanlahanController extends Controller
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

    public function tabelkepemilikan()
    {
        return DataTables::of(DB::table('keanggotaanpoktan')
            ->join('kelompok', 'kelompok.idkelompok', '=', 'keanggotaanpoktan.idkelompok')
            ->join('lahan', 'lahan.idlahan', '=', 'keanggotaanpoktan.idlahan')
            ->join('biodatauser', 'lahan.nik', '=', 'biodatauser.nik')
            ->join('desa', 'desa.iddesa', '=', 'lahan.iddesa')
            ->select('keanggotaanpoktan.*','biodatauser.nama as nama','lahan.namalahan as namalahan','lahan.luaslahan as luaslahan','biodatauser.nik as nik','biodatauser.alamat as alamat', 'desa.namadesa as namadesa', 'kelompok.namakelompok as namakelompok')
            ->get())
            ->addColumn('action', function ($data) {
                $del = '<a href="#" data-id="' . $data->idkeanggotaan . '" class="hapus-data"><i class="fas fa-trash"></i></a>';
                $edit = '<a href="#" data-id="' . $data->idkeanggotaan . '" class="edit-modal"><i class="fas fa-edit"></i></a>';
                return $edit . '&nbsp' . '&nbsp' . $del;
            })
            ->make(true);
    }



    public function cekniktani ($id){
        $pengecekan = DB::table('biodatauser')->where('nik','=',$id);
        if ($pengecekan->exists()){
            $x = DB::table('biodatauser')->where('nik',$id)->get();
            return response()->json($x);
        } else {
            $value = array();
            $x = DB::table('biodatauser')->where('nik',$value)->get();
        return response()->json($x);
        }
        
    }
 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $polygon = DB::table('lahan')
        ->join('statuslahan','statuslahan.idstatus','=','lahan.idstatus')
        ->join('biodatauser','biodatauser.nik','=','lahan.nik')
        ->join('desa','desa.iddesa','=','lahan.iddesa')
        ->get();
        $jumlah = DB::table('lahan')->count();
        $kecamatan = DB::table('kecamatan')->get();
        $kelompok = DB::table('kelompok')
        ->where('sektor','=','pertanian')
        ->get();
        $desa = DB::table('desa')->get();
        $date = date('d-m-Y');
        return view('pertanian.kepemilikanlahan',compact('date','kelompok','kecamatan','polygon','jumlah','desa'));
    }

    public function cekkepemilikan($id)
    {
        $x = DB::table('keanggotaanpoktan')
            ->join('lahan','lahan.idlahan','=','keanggotaanpoktan.idlahan')
            ->join('biodatauser','biodatauser.nik','=','lahan.nik')
            ->join('desa','desa.iddesa','=','lahan.iddesa')
            ->join('kelompok','kelompok.idkelompok','=','keanggotaanpoktan.idkelompok')
            ->where('idkeanggotaan', $id)
            ->get();
        return response()->json($x);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nik = $request->get('nik');
        $namalahan = $request->get('namalahan');
        $luas = $request->get('luas');
        $iddesa = $request->get('iddesa');
        $keterangan = $request->get('keterangan');
        $idkelompok = $request->get('idkelompok');
        $koordinat = $request->get('koordinat');
        $idlahan = $request->get('idlahan');
        $idstatus = $request->get('idstatus');

        $pengecekan = DB::table('lahan')->select('*')
        ->where('idlahan', '=', $idlahan);

    if ($pengecekan->exists()) {
        DB::table('lahan')
            ->where('idlahan','=',$idlahan)
            ->update([
                'namalahan' => $namalahan,
                'luaslahan' => $luas,
                'iddesa' => $iddesa,
                'keterangan' => $keterangan,
                'idstatus' => $idstatus,
                'koordinat' => $koordinat,
        ]);
       
        DB::table('keanggotaanpoktan')->where('idlahan','=',$idlahan)->update([
            'idkelompok'  => $idkelompok,
        ]);

        \Session::flash("flash_notification", [
            "level" => "success",
            "message" => "Data petani $request->nama Berhasil diupdate!"
        ]);
    } else {
        DB::table('lahan')->insert([
                'nik' => $nik,
                'namalahan' => $namalahan,
                'luaslahan' => $luas,
                'iddesa' => $iddesa,
                'keterangan' => $keterangan,
                'idstatus' => $idstatus,
                'koordinat' => $koordinat,
            ]);

        $idl = DB::table('lahan')->orderBy ('idlahan','desc')->first();
        DB::table('keanggotaanpoktan')->insert([
            'idkelompok'      => $idkelompok,
            'idlahan'      => $idl->idlahan
        ]);

        \Session::flash("flash_notification", [
            "level" => "success",
            "message" => "Berhasil menambah data!"
        ]);
    }
        return redirect('/kepemilikanlahan/create');
    }

    public function ambilkoordinat($id)
    {
        $data = DB::table('desa')->where('iddesa', '=', $id)
            ->first();
        return response()->json($data);
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
        DB::table('keanggotaanpoktan')->where('idkeanggotaan', '=', $id)->delete();
    }
}
