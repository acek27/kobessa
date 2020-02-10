<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use Illuminate\Support\Facades\DB;

class petaniController extends Controller
{
   
    public $successStatus = 200;

/** 
     * Petani api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function cekdatapetani(Request $req) {
        $cek = DB::table('biodatauser')->where('nik', '=', $req->nik)->get();
        return response()->json($cek);
    
        
    }
    public function simpanpetani(Request $req) {
        $data =  DB::table('biodatauser')->insert([
                            'nik' => $req->nik,
                            'nama' => $req->nama,
                            'tempatlahir' => $req->tempatlahir,
                            'tgllahir' => $req->tgllahir,
                            'jeniskelamin' => $req->jeniskelamin,
                            'iddesa' => $req->iddesa,
                            'alamat' => $req->alamat,
                            'telp' => $req->telp
        ]);
        return response()->json($data);
    
        
    }
    public function updatepetani(Request $req) {
        $data =  DB::table('biodatauser')->where('nik','=',$req->nik)
                            ->update([
                                'nama' => $req->nama,
                                'tempatlahir' => $req->tempatlahir,
                                'tgllahir' => $req->tgllahir,
                                'jeniskelamin' => $req->jeniskelamin,
                                'iddesa' => $req->iddesa,
                                'alamat' => $req->alamat,
                                'telp' => $req->telp
    ]);
        return response()->json($data);
    
        
    }
/** 
     * Kelompok api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    
    public function cekkelompok(Request $req){
        $data = DB::table('kelompok')->where('namakelompok', '=', $req->namakelompok)
        ->where('iddesa', '=', $req->iddesa)->where('sektor', '=', 'pertanian')->get();
        return response()->json($data);
        }

    public function simpankelompok(Request $req){
        $data = DB::table('kelompok')->insert([
                'namakelompok' => $req->namakelompok,
                'iddesa' => $req->iddesa,
                'alamatsekretariat' => $req->alamatsekretariat,
                'tahunpembentukan' => $req->tahunpembuatan,
                'jeniskelompok' => $req->jeniskelompok,
                'sektor' => 'pertanian',
                'status' => '1'
        ]);
        return response()->json($data);
      
        }    
    
}
