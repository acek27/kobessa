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

  
    public function simpanaktivitas(Request $req){
       
        DB::table('aktivitaspetani')->insert([
            'idlahan' => $req->idlahan,
            'idsop' => $req->idsop,
            'biaya' => $req->biaya,
            'keterangan' => $req->keterangan,
            'foto' => $req->foto
           
            ]);
            $berhasil = 'Berhasil Menyimpan Aktivitas';
            return response()->json(['success'=>$berhasil], $this-> successStatus);
    }
}
