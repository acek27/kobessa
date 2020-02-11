<?php

namespace App\Http\Controllers\pertanian;

use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect, Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Barryvdh\DomPDF\Facade as PDF;


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
        if (request()->ajax()) {

            $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
            $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');

            $data = Event::whereDate('start', '>=', $start)->whereDate('end', '<=', $end)->get(['id', 'title', 'start', 'end']);
            return Response::json($data);
        }


        $lahan = DB::table('lahan')->where('nik', '=', $nikuser)->where(function ($status) {
            $status->where('idstatus', '=', 4)
                ->orWhere('idstatus', '=', 5)
                ->orWhere('idstatus', '=', 6);
        })->get();
        $sop = DB::table('soppertanian')->get();
        $jenis = DB::table('jenistanaman')->get();

        return view('pertanian.rencanatanam', compact('lahan', 'sop', 'jenis'));
    }

    public function tabelhistori()
    {
        $nikuser = Auth::User()->nik;
        return DataTables::of(DB::table('jadwaltanam')
            ->join('soppertanian', 'soppertanian.idversi', '=', 'jadwaltanam.idversi')
            ->join('lahan', 'lahan.idlahan', '=', 'jadwaltanam.idlahan')
            ->join('jenistanaman', 'jenistanaman.idjenis', '=', 'jadwaltanam.idjenis')
            ->select('jadwaltanam.*', 'soppertanian.versisop as versisop', 'lahan.nik as nik', 'lahan.namalahan as namalahan', 'jenistanaman.jenistanaman as jenis')
            ->where('nik', '=', $nikuser)
            ->get())
            ->addColumn('action', function ($data) {
                $print = '<a href="' . route('jadwal.print', $data->idlahan) . '" class="print-data" target="_blank"><i class="fa fa-print">Jadwal</i></a>';
                return $print;
            })
            ->addColumn('metode', function ($data) {
                if ($data->idmetode == 1) {
                    return "Pembenihan";
                } else {
                    return "Pembibitan/Tanam";
                }
            })
            ->make(true);
    }

    public function tabelhistoritanamSP()
    {
        return DataTables::of(DB::table('jadwaltanam')
            ->join('soppertanian', 'soppertanian.idversi', '=', 'jadwaltanam.idversi')
            ->join('lahan', 'lahan.idlahan', '=', 'jadwaltanam.idlahan')
            ->join('biodatauser', 'lahan.nik', '=', 'biodatauser.nik')
            ->join('desa', 'lahan.iddesa', '=', 'desa.iddesa')
            ->join('kecamatan', 'kecamatan.idkecamatan', '=', 'desa.idkecamatan')
            ->join('jenistanaman', 'jenistanaman.idjenis', '=', 'jadwaltanam.idjenis')
            ->select('jadwaltanam.*', 'soppertanian.versisop as versisop', 'lahan.namalahan as namalahan', 'jenistanaman.jenistanaman as jenis',
                'biodatauser.nama as namapetani', 'lahan.nik as nik', 'desa.namadesa as namadesa', 'kecamatan.kecamatan as kecamatan')
            ->get())
            ->make(true);
    }

    public function datasop($id)
    {
        $data = DB::table('soppertanian')->where('idjenis', '=', $id)
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
        return view('pertanian.rencanatanamSP');
    }

    public function print($id)
    {
        $biodata = DB::table('keanggotaanpoktan')
            ->join('kelompok', 'kelompok.idkelompok', '=', 'keanggotaanpoktan.idkelompok')
            ->join('lahan', 'lahan.idlahan', '=', 'keanggotaanpoktan.idlahan')
            ->join('biodatauser', 'lahan.nik', '=', 'biodatauser.nik')
            ->join('desa', 'lahan.iddesa', '=', 'desa.iddesa')
            ->join('kecamatan', 'desa.idkecamatan', '=', 'kecamatan.idkecamatan')
            ->where('keanggotaanpoktan.idlahan', '=', $id)->first();


        $jadwal = DB::table('jadwalbertani')
            ->join('fasetanam', 'fasetanam.idfase', "=", 'jadwalbertani.idfase')
            ->select('jadwalbertani.*', 'fasetanam.namafase as fase')
            ->where('jadwalbertani.idlahan', '=', $id)->get();


        $pdf = PDF::loadView('jadwalbertani', compact('jadwal', 'biodata'))->setPaper('folio', 'potrait');
        return $pdf->stream('Jadwal Budidaya');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
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

        $pengecekan = DB::table('jadwaltanam')->where('idlahan', "=", $idlahan)->orderBy('periode', 'DESC');
        if ($pengecekan->exists()) {
            $ambil = DB::table('jadwaltanam')->where('idlahan', "=", $idlahan)->orderBy('periode', 'DESC')->first();
            $pt = $ambil->periode;
            $periodeKe = $pt + 1;
            DB::table('jadwaltanam')->insert([
                'idlahan' => $idlahan,
                'idversi' => $idversi,
                'idmetode' => $metode,
                'tgltanam' => $tgltanam,
                'idjenis' => $idjenis,
                'komoditas' => $komoditas,
                'periode' => $periodeKe,
            ]);

            \Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Berhasil menambah data!"
            ]);

            //membuat jadwalbertani
            $benih = DB::table('soptanidetail')->where('idversi', '=', $idversi)->get();
            $tanam = DB::table('soptanidetail')->where('idversi', '=', $idversi)->where('idfase', '>', 1)->get();

            if ($metode == 1) {
                foreach ($benih as $wak) {
                    $tglbertani = date('Y-m-d', strtotime($wak->waktu . ' days', strtotime($tgltanam)));
                    DB::table('jadwalbertani')->insert([
                        'idlahan' => $idlahan,
                        'tglaktivitas' => $tglbertani,
                        'idfase' => $wak->idfase,
                        'aktivitas' => $wak->kegiatan,
                        'periode' => $periodeKe,
                    ]);
                }
            } else {
                foreach ($tanam as $wok) {
                    $tglbertani = date('Y-m-d', strtotime($wok->waktu . ' days', strtotime($tgltanam)));
                    DB::table('jadwalbertani')->insert([
                        'idlahan' => $idlahan,
                        'tglaktivitas' => $tglbertani,
                        'idfase' => $wok->idfase,
                        'aktivitas' => $wok->kegiatan,
                        'periode' => $periodeKe,
                    ]);
                }

            }
        } else {
            DB::table('jadwaltanam')->insert([
                'idlahan' => $idlahan,
                'idversi' => $idversi,
                'idmetode' => $metode,
                'tgltanam' => $tgltanam,
                'idjenis' => $idjenis,
                'komoditas' => $komoditas,
                'periode' => 1,
            ]);

            \Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Berhasil menambah data!"
            ]);

            //membuat jadwalbertani
            $benih = DB::table('soptanidetail')->where('idversi', '=', $idversi)->get();
            $tanam = DB::table('soptanidetail')->where('idversi', '=', $idversi)->where('idfase', '>', 1)->get();

            if ($metode == 1) {
                foreach ($benih as $wak) {
                    $tglbertani = date('Y-m-d', strtotime($wak->waktu . ' days', strtotime($tgltanam)));
                    DB::table('jadwalbertani')->insert([
                        'idlahan' => $idlahan,
                        'tglaktivitas' => $tglbertani,
                        'idfase' => $wak->idfase,
                        'aktivitas' => $wak->kegiatan,
                        'periode' => 1,
                    ]);
                }
            } else {
                foreach ($tanam as $wok) {
                    $tglbertani = date('Y-m-d', strtotime($wok->waktu . ' days', strtotime($tgltanam)));
                    DB::table('jadwalbertani')->insert([
                        'idlahan' => $idlahan,
                        'tglaktivitas' => $tglbertani,
                        'idfase' => $wok->idfase,
                        'aktivitas' => $wok->kegiatan,
                        'periode' => 1,
                    ]);
                }

            }
            DB::table('lahan')->where('idlahan', "=", $idlahan)->update([
                'idstatus' => 5,
            ]);
        }

        return redirect('rencanatanam');
        //return response()->json($tglbertani);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }
}
