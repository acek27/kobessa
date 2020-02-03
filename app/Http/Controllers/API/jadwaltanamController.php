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

    public function simpanjadwal(Request $req){
  
        DB::table('jadwaltanam')->insert([
                            'idlahan' => $req->idlahan,
                            'idversi' => $req->idversi,
                            'metode' => $req->metode,
                            'tgltanam' => $req->tgltanam,
                            'idjenis' => $req->idjenis,
                            'komoditas' => $req->komoditas,
            ]);
            $berhasil = 'Berhasil Menambahkan Jadwal Tanam';
            return response()->json(['success'=>$berhasil], $this-> successStatus); 

        }

        public function jadwalair(){
               $data = Event::all();
               return response()->json(['success' => $data], $this-> successStatus);
        }
      
        public function lahan($id){
        $lahan = DB::table('lahan')->where('nik','=', $id)->get();
        return response()->json(['success' => $lahan], $this-> successStatus);
        }
        public function soppertanian(){
        $sop = DB::table('soppertanian')->get();
        return response()->json(['success' => $sop], $this-> successStatus);
        }
        public function jenistanaman(){
        $jenis = DB::table('jenistanaman')->get();
        return response()->json(['success' => $jenis], $this-> successStatus);
        }
}
