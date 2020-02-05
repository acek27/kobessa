<?php

namespace App\Http\Controllers\pertanian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class kebutuhanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function tabelsop()
    {
        return DataTables::of(DB::table('soppertanian') 
        ->join('jenistanaman','soppertanian.idjenis','=','jenistanaman.idjenis')
        ->select('soppertanian.*','jenistanaman.jenistanaman as jenis')
        ->get())
        ->addColumn('action', function ($data) {
                $pilih = "<a href=\"" . route('kebutuhansaprodi.show', $data->idversi) . "\"><i class=\"material-icons\" title=\"Data Kebutuhan Saprodi\">Pilih</i></a>";
                return $pilih;
            })
            ->make(true);
    }
    public function tabelkebutuhan($id)
    {
        return DataTables::of(DB::table('kebutuhansaprodi')
        ->join('saprodi', 'saprodi.idsaprodi', '=', 'kebutuhansaprodi.idsaprodi')
        ->select('kebutuhansaprodi.*','saprodi.namasaprodi as namasaprodi','saprodi.satuan as satuan')
        ->where('idsop',"=",$id)
        ->get())
        ->addColumn('action', function ($data) {
            $del = '<a href="#" data-id="' . $data->idkebutuhansaprodi . '" class="hapus-data"><i class="fas fa-trash"></i></a>';
            $edit = '<a href="#" data-id="' . $data->idkebutuhansaprodi . '" class="edit-modal"><i class="fas fa-edit"></i></a>';
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
        return view('pertanian.kebutuhansaprodi');
        
    }
    public function cari()
    {

        return view('pertanian.carisop');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $x = DB::table('saprodi')->get();
        $jum = count($x);
        for($i=1; $i<=$jum; $i++)
        {
     
            $idsop = $request->get('idsop');
            $idsaprodi = $request->get('idsaprodi'.$i);
            $kebutuhan = $request->get('kebutuhan'.$i);
            if ($kebutuhan != null){
                DB::table('kebutuhansaprodi')->insert([
                    'idsop' => $idsop,
                    'idsaprodi' => $idsaprodi,
                    'kebutuhan' => $kebutuhan,
                    ]);
            }
       
        }
        \Session::flash("flash_notification", [
            "level" => "success",
            "message" => "Berhasil menambah data petani : $request->nama"
        ]);
       
        return redirect('/kebutuhansaprodi'.'/'.$idsop);

    }
    
    public function hargasaprodi($id)
    {
        $x = DB::table('saprodi')->where('idsaprodi', '=', $id)
            ->get();
        return response()->json($x);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $idversi = $id;
         $saprodi = DB::table('saprodi')->get();
        return view('pertanian.kebutuhansaprodi', compact('saprodi','idversi'));
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
