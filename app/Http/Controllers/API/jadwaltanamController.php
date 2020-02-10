<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Event;
use Redirect,Response;
use Illuminate\Support\Facades\DB;

class jadwaltanamController extends Controller
{

    public $successStatus = 200;

    public function ambilPT($id){
        $ambil = DB::table('jadwaltanam')->where('idlahan',"=",$id)->orderBy('periode','DESC')->first();
        return response()->json($ambil);
    }
    public function metodebenih(Request $req){
        $benih = DB::table('soptanidetail')->where('idversi','=',$req->idversi)->get();
        return response()->json($benih);
    }
    public function metodetanam(Request $req){
        $tanam = DB::table('soptanidetail')->where('idversi','=',$req->idversi)->where('idfase','>',1)->get();
        return response()->json($tanam);
    }

    public function simpanjadwaltanam(Request $req){
            DB::table('jadwaltanam')->insert([
                            'idlahan' => $req->idlahan,
                            'idversi' => $req->idversi,
                            'idmetode' => $req->idmetode,
                            'tgltanam' => $req->tgltanam,
                            'idjenis' => $req->idjenis,
                            'komoditas' => $req->komoditas,
                            'periode' => $req->periode,
            ]);
            $berhasil = 'Berhasil Menambahkan Jadwal Tanam';
            return response()->json($berhasil); 

            }

    public function simpanjadwalbertani(Request $req){
        
            DB::table('jadwalbertani')->insert([
                            'idlahan' => $req->idlahan,
                            'tglaktivitas' => $req->tglaktivitas,
                            'idfase' =>$req->idfase,
                            'aktivitas' => $req->aktivitas,
                            'periode' => $req->periode,              
            ]);
            $berhasil = 'Berhasil Menambahkan Jadwal Tanam';
            return response()->json($berhasil); 
        
            DB::table('lahan')->where('idlahan',"=",$req->idlahan)->update(['idstatus' => 5]);
}
    
        public function jadwalair(){
               $data = Event::all();
               return response()->json(['success' => $data], $this-> successStatus);
        }
      
        public function lahan($id){
        $lahan = DB::table('lahan')->where('nik','=', $id)->get();
        return response()->json($lahan);
        }
        public function lahanbyPPL($id){
        $lahan = DB::table('lahan')
        ->join('desappl','desappl.iddesa',"=",'lahan.iddesa')
        ->where('desappl.idppl','=', $id)->get();
        return response()->json($lahan);
        }
        public function soppertanian1(){
        $sop = DB::table('soppertanian')->get();
        return response()->json($sop);
        }
         public function soppertanian($id){
        $sop = DB::table('soppertanian')->where('idjenis','=', $id)->get();
        return response()->json($sop);
        }
        public function jenistanaman(){
        $jenis = DB::table('jenistanaman')->get();
        return response()->json($jenis);
        }
}
