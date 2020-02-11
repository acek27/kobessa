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
        return response()->json($sup);
        }
    public function pilihsuplierbyID($id){
        $sup = DB::table('suplier')->where('idsuplier',"=",$id)->get();
        return response()->json($sup);
        }
    public function suplierbyLogin($nik){
        $sup = DB::table('suplier')->where('idsuplier','=',$nik)->get();
        return response()->json($sup);
        }
    public function saprodi(){
        $sap = DB::table('saprodi')->get();
        return response()->json($sap);
        }
    public function desa(){
        $desa = DB::table('desa')->get();
        return response()->json($desa);
        }
    public function desabyKecamatan($id){
        $desaBK = DB::table('desa')->where('idkecamatan','=', $id)->get();
        return response()->json($desaBK);
        }
    public function kecamatan(){
        $kec = DB::table('kecamatan')->get();
        return response()->json($kec);
        }
    public function poktan(){
        $poktan = DB::table('kelompok')->get();
        return response()->json($poktan);
        }
    public function poktanbyDesa($id){
        $poktanBD = DB::table('kelompok')->where('iddesa','=', $id)->get();
        return response()->json($poktanBD);
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
            'nik' => $req->nik,
            'namalahan' => $req->namalahan,
            'luaslahan' => $req->luaslahan,
            'iddesa' => $req->iddesa,
            'keterangan' => $req->keterangan,
            'idstatus' => 6
        ]);
            $berhasil = 'Kebutuhan Saprodi Berhasil Disimpan';
            return response()->json($berhasil);
            
    }
    public function getIDlahan(){
        $idl = DB::table('lahan')->orderBy ('idlahan','desc')->first();
        return response()->json([$idl]);
        }
   
    public function simpanpoktan(Request $req){
        DB::table('keanggotaanpoktan')->insert([
            'idkelompok' => $req->idkelompok,
            'idlahan' => $req->idlahan   
        ]);
        $berhasil = 'Keanggotaan POKTAN Berhasil Disimpan';
        return response()->json(['success' => $berhasil], $this-> successStatus);
        }

    public function historypesanan($nik){
            $history = DB::table('pesanansaprodi')
            ->join('saprodi', 'saprodi.idsaprodi', '=', 'pesanansaprodi.idsaprodi')
            ->join('suplier', 'suplier.idsuplier', '=', 'pesanansaprodi.idsuplier')
            ->select('pesanansaprodi.*', 'saprodi.namasaprodi as namasaprodi', 'saprodi.satuan as satuan', 'suplier.namasuplier as namasuplier')
            ->where('nik', '=', $nik)
            ->get();
            return response()->json($history);
            }
    public function pesananbysuplier($id){
            $pesanan = DB::table('pesanansaprodi')
            ->select('PO', 'tglpesan', 'status', 'tglkirim', 'biodatauser.nama as nama', 'desa.namadesa as namadesa', 'kecamatan.kecamatan as namakecamatan', DB::raw('count(PO) as user_count'))
            ->join('biodatauser', 'pesanansaprodi.nik', '=', 'biodatauser.nik')
            ->join('desa', 'desa.iddesa', '=', 'biodatauser.iddesa')
            ->join('kecamatan', 'kecamatan.idkecamatan', '=', 'desa.idkecamatan')
            ->where('idsuplier','=',$id)
            ->groupBy('PO', 'tglpesan', 'status', 'tglkirim', 'biodatauser.nama', 'desa.namadesa', 'kecamatan.kecamatan')
            ->get();
            return response()->json($pesanan);
            }
    public function pesananbyPO($po){
            $pesanan = DB::table('pesanansaprodi')
            ->join('suplier', 'suplier.idsuplier', '=', 'pesanansaprodi.idsuplier')
            ->join('biodatauser', 'biodatauser.nik', '=', 'pesanansaprodi.nik')
            ->join('saprodi', 'saprodi.idsaprodi', '=', 'pesanansaprodi.idsaprodi')
            ->select('jumlahkirim', 'idpesanan', 'biodatauser.nama as namapemesan', 'biodatauser.alamat as alamat', 'biodatauser.telp as telp', 'pesanansaprodi.jumlah as jumlah', 'saprodi.namasaprodi as nama', 'pesanansaprodi.tglpesan as tglpesan', 'pesanansaprodi.tglkirim as tglkirim','status')
            ->where('PO', '=', $po)->get();
            return response()->json($pesanan);
            }
    public function statuspesananbyPO($po){
            $pesanan = DB::table('pesanansaprodi')
            ->join('suplier', 'suplier.idsuplier', '=', 'pesanansaprodi.idsuplier')
            ->join('biodatauser', 'biodatauser.nik', '=', 'pesanansaprodi.nik')
            ->join('saprodi', 'saprodi.idsaprodi', '=', 'pesanansaprodi.idsaprodi')
            ->select('biodatauser.nama as namapemesan', 'PO', 'status', 'biodatauser.alamat as alamat', 'biodatauser.telp as telp', 'pesanansaprodi.jumlah as jumlah', 'saprodi.namasaprodi as nama', 'pesanansaprodi.tglpesan as tglpesan', 'pesanansaprodi.tglkirim as tglkirim')
            ->where('PO', '=', $po)->first();
            return response()->json($pesanan);
            }
    public function setujuipesanan($po, Request $req){
            $count = DB::table('pesanansaprodi')->where('PO', $po)->count('*');
            for ($i = 1; $i <= $count; $i++) {
            $pesanan = DB::table('pesanansaprodi')->where('PO', $po)->where('idpesanan', $req->idpesanan.$i)
            ->update([
                'jumlahkirim' => $req->jumlahkirim.$i,
                'DO' => $req->po,
                'tglpengiriman' => $req->datetoday,
                'status' => 2,
            ]);
            }
            return response()->json($pesanan);
            }
    public function tolakpesanan($po){
            $pesanan = DB::table('pesanansaprodi')->where('PO', $po)->update([
                'status' => 9
            ]);
            return response()->json($pesanan);
            }
    public function kirimpesanan($po){
            $pesanan = DB::table('pesanansaprodi')->where('PO', $po)->update([

                'status' => 3
            ]);
            return response()->json($pesanan);
            }
    public function terimapesanan($po){
            $pesanan = DB::table('pesanansaprodi')->where('PO', $po)->update([
                'status' => 4
            ]);
            return response()->json($pesanan);
            }

}
