<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Redirect,Response;
use Illuminate\Support\Facades\DB;

class chatController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::table('chat')->insert([
            'idpengirim' => $request->idpengirim,
            'idtujuan' => $request->idtujuan,
            'text' => $request->text,
            'img' => $request->img, 
            'waktu' => $request->waktu
            ]);
    $berhasil = 'Chat Terkirim!';
    return response()->json(['success'=>$berhasil], $this-> successStatus);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chat = DB::table('chat')->where('idpengirim','=',$id)->get();
        return response()->json(['success'=>$chat], $this-> successStatus);
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
    public function statusLogin($id)
    {
        DB::table('users')
        ->where('id','=',$id)
        ->update([
            'statuslogin' => 1
            ]);
    $berhasil = 'Status User: Online';
    return response()->json(['success'=>$berhasil], $this-> successStatus);
    }

    public function statusLogout($id)
    {
        DB::table('users')
        ->where('id','=',$id)
        ->update([
            'statuslogin' => 0
            ]);
    $berhasil = 'Status User: Offline';
    return response()->json(['success'=>$berhasil], $this-> successStatus);
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
       DB::table('chat')->where('idpengirim', '=', $id)->delete();
       $delete = 'Pesan Berhasil Dihapus!';
       return response()->json(['success'=>$delete], $this-> successStatus);
    }
}
