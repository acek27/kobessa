<?php

namespace App\Http\Controllers\pertanian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class saprodiController extends Controller
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

    public function tabelsaprodi()
    {
        return DataTables::of(DB::table('saprodi')->get())
            ->addColumn('action', function ($data) {
                $del = '<a href="#" data-id="' . $data->idsaprodi . '" class="hapus-data"><i class="fas fa-trash"></i></a>';
                $edit = '<a href="#" data-id="' . $data->idsaprodi . '" class="edit-modal"><i class="fas fa-edit"></i></a>';
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
         return view('pertanian.datasaprodi');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $namasaprodi = $request->get('namasaprodi');
        $satuan = $request->get('satuan');
        $hargasatuan = $request->get('hargasatuan');
        $fungsi = $request->get('fungsi');
        $pengecekan = DB::table('saprodi')->select('*')
            ->where('namasaprodi', '=', $namasaprodi)
            ->where('satuan', '=', $satuan);

        if ($pengecekan->exists()) {
            DB::table('saprodi')
                ->where('namasaprodi',$namasaprodi)
                ->update([
                'hargasatuan' => $hargasatuan,
                'fungsi' => $fungsi
            ]);

            \Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Data Berhasil Diupdate!"
            ]);
        } else {
            DB::table('saprodi')->insert([
                    'namasaprodi'      => $namasaprodi,
                    'satuan'     => $satuan,
                    'hargasatuan'     => $hargasatuan,
                    'fungsi'     => $fungsi

                ]);
        
                \Session::flash("flash_notification", [
                    "level" => "success",
                    "message" => "Berhasil menambah data!"
                ]);
        }
               return redirect('/datasaprodi/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
