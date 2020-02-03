<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Redirect,Response;
use Illuminate\Support\Facades\DB;

class ordersaprodiController extends Controller
{
    public $successStatus = 200;

    public function suplier(){
        $sup = DB::table('suplier')->get();
        return response()->json(['success' => $sup], $this-> successStatus);
        }
    public function suplierbyLogin($nik){
        $sup = DB::table('suplier')->where('idsuplier','=',$nik)->get();
        return response()->json($sup);
        }
    public function saprodi(){
        $sap = DB::table('saprodi')->get();
        return response()->json(['success' => $sap], $this-> successStatus);
        }
    public function desa(){
        $desa = DB::table('desa')->get();
        return response()->json(['success' => $desa], $this-> successStatus);
        }
    public function desabyKecamatan($id){
        $desaBK = DB::table('desa')->where('idkecamatan','=', $id)->get();
        return response()->json(['success' => $desaBK], $this-> successStatus);
        }
    public function kecamatan(){
        $kec = DB::table('kecamatan')->get();
        return response()->json(['success' => $kec], $this-> successStatus);
        }
    public function poktan(){
        $poktan = DB::table('kelompok')->get();
        return response()->json(['success' => $poktan], $this-> successStatus);
        }
    public function poktanbyDesa($id){
        $poktanBD = DB::table('kelompok')->where('iddesa','=', $id)->get();
        return response()->json(['success' => $poktanBD], $this-> successStatus);
        }
    public function aktivitas(){
        $aktiv = DB::table('soptanidetail')->get();
        return response()->json(['success' => $aktiv], $this-> successStatus);
        }
    public function aktivitasbyFase($id){
        $aktivBF = DB::table('soptanidetail')->where('idfase','=', $id)->get();
        return response()->json(['success' => $aktivBF], $this-> successStatus);
        }
    public function scedulebyLahan($id){
        $sceduleBL = DB::table('jadwalbertani')->where('idlahan','=', $id)->get();
        return response()->json(['success' => $sceduleBL], $this-> successStatus);
        }
    public function pesanansaprodibyID($id){
        $pesananbyID = DB::table('pesanansaprodi')
                ->select('PO', 'tglpesan', 'status', 'tglkirim', 'biodatauser.nama as nama', 'desa.namadesa as namadesa', 'kecamatan.kecamatan as namakecamatan', DB::raw('count(PO) as user_count'))
                ->join('biodatauser', 'pesanansaprodi.nik', '=', 'biodatauser.nik')
                ->join('desa', 'desa.iddesa', '=', 'biodatauser.iddesa')
                ->join('kecamatan', 'kecamatan.idkecamatan', '=', 'desa.idkecamatan')
                ->where('idsuplier','=',$id)
                ->groupBy('PO', 'tglpesan', 'status', 'tglkirim', 'biodatauser.nama', 'desa.namadesa', 'kecamatan.kecamatan')
                ->get();
        return response()->json($pesananbyID);
        }
    public function pesanansaprodibyPO($id){
        $pesananbyPO = DB::table('pesanansaprodi')
                ->select('PO', 'tglpesan', 'status', 'tglkirim', 'biodatauser.nama as nama', 'desa.namadesa as namadesa', 'kecamatan.kecamatan as namakecamatan')
                ->join('biodatauser', 'pesanansaprodi.nik', '=', 'biodatauser.nik')
                ->join('desa', 'desa.iddesa', '=', 'biodatauser.iddesa')
                ->join('kecamatan', 'kecamatan.idkecamatan', '=', 'desa.idkecamatan')
                ->where('PO','=',$id)
                ->get();
        return response()->json($pesananbyPO);
        }


    public function simpanorder(Request $req){
          // return response()->json(['success' => $saprodi], $this-> successStatus);
                  
                DB::table('pesanansaprodi')->insert([
                    'idsuplier' => $req->idsuplier,
                    'nik' => $req->nik,
                    'PO' => $req->PO,
                    'idsaprodi' => $req->idsaprodi, 
                    'jumlah' => $req->jumlah,
                    'tglpesan' => $req->tglpesan,
                    'tglkirim' => $req->tglkirim,
                    'status' => 1
                    ]);
            $berhasil = 'Pesan Saprodi Berhasil';
            return response()->json(['success'=>$berhasil], $this-> successStatus);
            
    }

    public function simpanKS(Request $req){
                  
                DB::table('kebutuhansaprodi')->insert([
                    'idlahan' => $req->idlahan,
                    'idsaprodi' => $req->idsaprodi,
                    'kebutuhan' => $req->kebutuhan,
                    'id' => $req->id, 
                   ]);
            $berhasil = 'Kebutuhan Saprodi Berhasil Disimpan';
            return response()->json(['success'=>$berhasil], $this-> successStatus);
            
    }

    public function simpanlahan(Request $req){
                  
        DB::table('lahan')->insert([
            'nik' => $nik,
            'namalahan' => $req->namalahan,
            'luaslahan' => $req->luaslahan,
            'iddesa' => $req->iddesa,
            'keterangan' => $req->keterangan
        ]);
            $berhasil = 'Kebutuhan Saprodi Berhasil Disimpan';
            return response()->json(['success'=>$berhasil], $this-> successStatus);
            
    }
    public function getIDlahan(){
        $idl = DB::table('lahan')->orderBy ('idlahan','desc')->first();
        return response()->json(['success' => $idl], $this-> successStatus);
        }
    public function simpanpoktan(Request $req){
        DB::table('keanggotaanpoktan')->insert([
            'idkelompok' => $req->idkelompok,
            'idlahan' => $req->idlahan   
        ]);
        $berhasil = 'Keanggotaan POKTAN Berhasil Disimpan';
        return response()->json(['success' => $berhasil], $this-> successStatus);
        }


}
