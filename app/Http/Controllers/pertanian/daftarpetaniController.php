<?php

namespace App\Http\Controllers\pertanian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade as PDF;

class daftarpetaniController extends Controller
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


    public function tabelpetani()
    {
        return DataTables::of(DB::table('users')
            ->join('biodatauser', 'biodatauser.nik', '=', 'users.nik')
            ->join('desa', 'biodatauser.iddesa', '=', 'desa.iddesa')
            ->join('kecamatan', 'kecamatan.idkecamatan', '=', 'desa.idkecamatan')
            ->select('biodatauser.*', 'kecamatan.kecamatan as namakecamatan', 'desa.namadesa as namadesa')
            ->where('role_id', "=", '6')
            ->get())
            ->addColumn('action', function ($data) {
                $del = '<a href="#" data-id="' . $data->nik . '" class="hapus-data"><i class="fas fa-trash"></i></a>';
                $edit = '<a href="#" data-id="' . $data->nik . '" class="edit-modal"><i class="fas fa-edit"></i></a>';
                return $edit . '&nbsp' . '&nbsp' . $del;
            })
            ->make(true);
    }

    public function datakelompok($id)
    {
        $data = DB::table('kelompok')->where('sektor', '=', 'pertanian')->where('iddesa', '=', $id)
            ->get();
        return response()->json($data);
    }

    public function cekpetani($id)
    {
        $x = DB::table('biodatauser')
            ->join('desa', 'biodatauser.iddesa', '=', 'desa.iddesa')
            ->join('kecamatan', 'desa.idkecamatan', '=', 'kecamatan.idkecamatan')
            ->where('nik', $id)
            ->get();
        return response()->json($x);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelompok = DB::table('kelompok')->get();
        $desa = DB::table('desa')->get();
        $kecamatan = DB::table('kecamatan')->get();
        return view('pertanian.daftarpetani', compact('kecamatan', 'desa', 'kelompok'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
        $nikemail = $nik . '@kobessa.com';
        $telp = $request->get('telp');

        //lahan
        $namalahan = $request->get('namalahan');
        $luas = $request->get('luas');
        $iddesa2 = $request->get('iddesa2');
        $alamatlahan = $request->get('alamatlahan');
        $idkelompok = $request->get('idkelompok');

        $request->validate([
            'nik' => 'numeric|required'
        ]);

        $cekusers = DB::table('users')->select('*')
            ->where('nik', '=', $nik)
            ->where('role_id', '=', '6');
        if ($cekusers->exists()) {
            // DB::table('users')
            // ->where('nik', '=', $nik)
            // ->where('role_id', '=', '6')
            // ->update([
            //     'email' => $nikemail,
            //     'name' => $nama,
            //     'password' => Hash::make($nik),
            // ]);
            // \Session::flash("flash_notification", [
            //     "level" => "success",
            //     "message" => "Tidak Bisa Melakukan Pendaftaran, Karena NIK Petani Sudah Terdaftar! Silahkan cek di daftar petani"
            // ]);
        } else {
            DB::table('users')->insert([
                'nik' => $nik,
                'name' => $nama,
                'email' => $nikemail,
                'password' => Hash::make($nik),
                'role_id' => 6,
            ]);


            $pengecekan = DB::table('biodatauser')->select('*')
                ->where('nik', '=', $nik);

            if ($pengecekan->exists()) {
                DB::table('biodatauser')
                    ->where('nik', '=', $nik)
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
                    'telp' => $telp
                ]);
            }

            DB::table('lahan')->insert([
                'nik' => $nik,
                'namalahan' => $namalahan,
                'luaslahan' => $luas,
                'iddesa' => $iddesa2,
                'keterangan' => $alamatlahan
            ]);


            $idl = DB::table('lahan')->orderBy('idlahan', 'desc')->first();
            DB::table('keanggotaanpoktan')->insert([
                'idkelompok' => $idkelompok,
                'idlahan' => $idl->idlahan

            ]);


            \Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Berhasil menambah data petani. Silahkan gunakan Username : $nikemail, Password : $nik untuk login aplikasi!"
            ]);
        }
        return redirect('/daftarpetani/create');
    }

    public function print($id)
    {
        $tanggal = date('Y-m-d');
        $bulan = array(
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );

        $hari = date("D");

        switch ($hari) {
            case 'Sun':
                $hari_ini = "Minggu";
                break;

            case 'Mon':
                $hari_ini = "Senin";
                break;

            case 'Tue':
                $hari_ini = "Selasa";
                break;

            case 'Wed':
                $hari_ini = "Rabu";
                break;

            case 'Thu':
                $hari_ini = "Kamis";
                break;

            case 'Fri':
                $hari_ini = "Jumat";
                break;

            case 'Sat':
                $hari_ini = "Sabtu";
                break;

            default:
                $hari_ini = "Tidak di ketahui";
                break;
        }

        $pecahkan = explode('-', $tanggal);
        $bulanindo = $bulan[(int)$pecahkan[1]];
        $biodata = DB::table('keanggotaanpoktan')
            ->join('kelompok', 'kelompok.idkelompok', '=', 'keanggotaanpoktan.idkelompok')
            ->join('lahan', 'lahan.idlahan', '=', 'keanggotaanpoktan.idlahan')
            ->join('biodatauser', 'lahan.nik', '=', 'biodatauser.nik')
            ->join('desa', 'desa.iddesa', '=', 'kelompok.iddesa')
            ->join('kecamatan', 'desa.idkecamatan', '=', 'kecamatan.idkecamatan')
            ->where('lahan.idlahan', '=', $id)->first();
        $saprodi = DB::table('kebutuhansaprodi')
            ->join('saprodi', 'kebutuhansaprodi.idsaprodi', '=', 'saprodi.idsaprodi')
            ->where('idlahan', '=', $id)->get();
        $pdf = PDF::loadView('myPDF', compact('biodata', 'bulanindo', 'hari_ini', 'saprodi'))->setPaper('folio', 'potrait');
        return $pdf->stream('MoU Kobessa');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $id;
        return view('pertanian.cetaklahan', compact('data'));
    }

    public function cekuser($id)
    {

        $pengecekan = DB::table('users')->where('nik', '=', $id)->where('role_id', '=', '6');
        if ($pengecekan->exists()) {
            $x = DB::table('users')->where('nik', $id)->where('role_id', '=', '6')->get();
            return response()->json($x);
        } else {
            $value = array();
            $x = DB::table('biodatauser')->where('nik', $value)->get();
            return response()->json($x);
        }
    }


    public function mouLahan($id)
    {
        return DataTables::of(DB::table('keanggotaanpoktan')
            ->join('kelompok', 'kelompok.idkelompok', '=', 'keanggotaanpoktan.idkelompok')
            ->join('lahan', 'lahan.idlahan', '=', 'keanggotaanpoktan.idlahan')
            ->join('biodatauser', 'lahan.nik', '=', 'biodatauser.nik')
            ->join('desa', 'desa.iddesa', '=', 'kelompok.iddesa')
            ->select('keanggotaanpoktan.*', 'biodatauser.nama as nama', 'lahan.namalahan as namalahan', 'lahan.luaslahan as luaslahan', 'biodatauser.nik as nik', 'biodatauser.alamat as alamat', 'desa.namadesa as namadesa', 'kelompok.namakelompok as namakelompok')
            ->where('lahan.nik', '=', $id)
            ->get())
            ->addColumn('action', function ($data) {
                $print = '<a href="' . route('mou.print', $data->idlahan) . '" class="print-data" target="_blank"><i class="fa fa-print"></i></a>';
                return $print;
            })
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('biodatauser')->where('nik', '=', $id)->delete();
    }
}
