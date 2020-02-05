<?php

namespace App\Http\Controllers\pertanian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade as PDF;

class pplController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $desa = DB::table('desa')->get();
        $kecamatan = DB::table('kecamatan')->get();
        return view('pertanian.daftarppl', compact('kecamatan', 'desa'));
    
    }

    public function tabelppl()
    {
        return DataTables::of(DB::table('users')
            ->join('biodatauser', 'biodatauser.nik', '=', 'users.nik')
            ->join('desa', 'biodatauser.iddesa', '=', 'desa.iddesa')
            ->join('kecamatan', 'kecamatan.idkecamatan', '=', 'desa.idkecamatan')
            ->where('role_id',"=",'5')
            ->select('biodatauser.*', 'kecamatan.kecamatan as namakecamatan', 'desa.namadesa as namadesa')
            ->get())
            ->addColumn('action', function ($data) {
                $del = '<a href="#" data-id="' . $data->nik . '" class="hapus-data"><i class="fas fa-trash"></i></a>';
                $edit = '<a href="#" data-id="' . $data->nik . '" class="edit-modal"><i class="fas fa-edit"></i></a>';
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->get('isi');
        $desbin = explode(",",$data);
        $jumlah= count($desbin);
        $request->validate([
            'telp' => 'numeric|required'
        ]);
        $nama = $request->get('nama');
        $tl = $request->get('tl');
        $tgl = $request->get('tgl');
        $alamat = $request->get('alamat');
        $jk = $request->get('jk');
        $iddesa = $request->get('iddesa');
        $nik = $request->get('nik');
        $email = $request->get('email');
        $pass = $request->get('pass');
        $telp = $request->get('telp');
 
                   
            $request->validate([
                'nik' => 'numeric|required'
            ]);
            $cekusers = DB::table('users')->select('*')
            ->where('nik', '=', $nik)
            ->where('role_id', '=', '5');

        if ($cekusers->exists()) {
            DB::table('users')
            ->where('nik', '=', $nik)
            ->where('role_id', '=', '5')
            ->update([
                'email' => $email,
                'name' => $nama,
                'password' => Hash::make($pass),
            ]);
        } else { 
            DB::table('users')->insert([
                'nik' => $nik,
                'name' => $nama,
                'email' => $email,
                'password' => Hash::make($pass),
                'role_id' => 5,
            ]);
        }
            
            $pengecekan = DB::table('biodatauser')->select('*')
            ->where('nik', '=', $nik);

        if ($pengecekan->exists()) {
            DB::table('biodatauser')
                ->where('nik','=',$nik)
                ->update([
                'nama' => $nama,
                'tempatlahir' => $tl,
                'tgllahir' => $tgl,
                'jeniskelamin' => $jk,
                'iddesa' => $iddesa,
                'alamat' => $alamat,
                'telp' => $telp

            ]);
        } else {
            DB::table('biodatauser')->insert([
                'nik' => $nik,
                'nama' => $nama,
                'tempatlahir' => $tl,
                'tgllahir' => $tgl,
                'jeniskelamin' => $jk,
                'iddesa' => $iddesa,
                'alamat' => $alamat,
                'telp' => $telp,
            ]); 
        }
        $idppl = DB::table('users')->where('nik','=',$nik)->where('role_id','=',5)->first();
        $cekbinaan = DB::table('desappl')->select('*')
        ->where('idppl', '=', $idppl->id);
        if ($cekbinaan->exists()) {
            DB::table('desappl')->where('idppl', '=', $idppl->id)->delete();
        }
            for($i=0;$i<$jumlah;$i++){
                DB::table('desappl')->insert([
                    'idppl' => $idppl->id,
                    'iddesa' => $desbin[$i]
                ]);
        }
            \Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Data PPL $nama Berhasil disimpan!, Gunakan Email : $email dan Password : $pass untuk Login Aplikasi"
            ]);
        

     return redirect('daftarppl');
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
