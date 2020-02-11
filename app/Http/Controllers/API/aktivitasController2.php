<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Redirect,Response;
use Illuminate\Support\Facades\DB;

class aktivitasController extends Controller
{
    public $successStatus = 200;

    public function fasetanam(){
    $fase = DB::table('fasetanam')->get();
    return response()->json(['success' => $fase], $this-> successStatus);
    }

  
    public function ambilIDbertani($id){
        $ambil = DB::table('jadwalbertani')->where('idlahan',"=",$id)->orderBy('periode','DESC')->first();
        // $ambil = DB::table('jadwalbertani')->where('idlahan',"=",$id)->orderBy('periode','DESC')->value('idbertani');
        return response()->json(['success' => $ambil], $this-> successStatus);
    }
    
    public function simpanaktivitas(Request $req){
        DB::table('jadwalbertani')->where('idbertani', $req->idbertani)->update([
            'status' => 1,
            'tglpelaksanaan' => $req->tglpelaksanaan,
            'keterangan' => $req->keterangan
        ]);
            $berhasil = 'Berhasil Menyimpan Aktivitas';
            return response()->json(['success'=>$berhasil], $this-> successStatus);
    }

    public function loadaktivitas($id){
        $data = DB::table('jadwalbertani')
            ->join('lahan','lahan.idlahan',"=",'jadwalbertani.idlahan')
            ->join('desappl','desappl.iddesa',"=",'lahan.iddesa')
            ->join('biodatauser','biodatauser.nik',"=",'lahan.nik')
            ->where('desappl.idppl', '=', $id)
            ->select('jadwalbertani.keterangan as keterangan','jadwalbertani.tglaktivitas as tglaktivitas','jadwalbertani.status as status','jadwalbertani.aktivitas as aktivitas','jadwalbertani.tglpelaksanaan as tglpelaksanaan','lahan.namalahan as namalahan','biodatauser.nama as namapetani')
            ->where('jadwalbertani.keterangan','like', '%Terlambat%')
            ->get();

        return response()->json($data);
    }

    public function lahanbyJB($nik){
        $data = DB::table('jadwalbertani')
            ->join('lahan','lahan.idlahan',"=",'jadwalbertani.idlahan')
            ->where('lahan.nik', '=', $nik)
            ->where('jadwalbertani.status',NULL)
            ->select(DB::raw('lahan.idlahan'),'lahan.namalahan')
            ->groupBy('lahan.idlahan','lahan.namalahan')
            ->get();

        return response()->json($data);
    }
    public function aktivitasbylahanbyJB($id){
        $ambil = DB::table('jadwalbertani')->where('idlahan',"=",$id)->orderBy('periode','DESC')->value('periode');
        $data = DB::table('jadwalbertani')
        ->join('fasetanam','fasetanam.idfase',"=",'jadwalbertani.idfase')
        ->where("idlahan", $id)->where("periode", $ambil)
        ->select('jadwalbertani.idlahan','jadwalbertani.tglaktivitas','fasetanam.namafase','jadwalbertani.aktivitas','jadwalbertani.status','jadwalbertani.keterangan')
            ->get();

        return response()->json($data);
    }
    public function aktivitasbySOP($id){
        $ambil = DB::table('jadwalbertani')->where('idlahan',"=",$id)->orderBy('periode','DESC')->value('periode');
        $data = DB::table('jadwalbertani')
        ->where("idlahan", $id)->where("periode", $ambil)->orderBy("tglaktivitas", 'ASC')
            ->first();

        return response()->json($data);
    }


}
