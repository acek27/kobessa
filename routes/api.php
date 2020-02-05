<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();

    
// });
//LOGIN-REGISTER
Route::post('login', 'API\UserController@login'); //sudah selesai
Route::post('register', 'API\UserController@register');
Route::get('userslist', 'API\UserController@list');
Route::get('details/{nik}', 'API\UserController@details');

//JADWAL TANAM
Route::get('jadwalair', 'API\jadwaltanamController@jadwalair'); 
Route::get('soppertanian', 'API\jadwaltanamController@soppertanian'); //sudah selesai
Route::get('lahan/{id}', 'API\jadwaltanamController@lahan'); // sudah selesai
Route::get('jenistanaman', 'API\jadwaltanamController@jenistanaman'); //sudah selesai
Route::post('simpanjadwal', 'API\jadwaltanamController@simpanjadwal');

//AKTIVITAS
Route::get('fasetanam', 'API\aktivitasController@fasetanam');
Route::post('simpanaktivitas', 'API\aktivitasController@simpanaktivitas');

//ORDER SAPRODI
Route::get('suplier', 'API\ordersaprodiController@suplier');
Route::get('suplierbyLogin/{nik}', 'API\ordersaprodiController@suplierbyLogin'); // Tampil Data Suplier By Login
Route::get('saprodi', 'API\ordersaprodiController@saprodi');
Route::post('simpanorder', 'API\ordersaprodiController@simpanorder'); // Simpan Pesanan Saprodi Petani [Menu Petani]
Route::post('simpanKS', 'API\ordersaprodiController@simpanKS');  // Simpan Kebutuhan Saprodi Tiap Lahan [Menu PPL]
Route::get('desa', 'API\ordersaprodiController@desa');
Route::get('kecamatan', 'API\ordersaprodiController@kecamatan');

//Filter Desa by Lahan
Route::get('desabyKecamatan/{id}', 'API\ordersaprodiController@desabyKecamatan');
Route::get('poktan', 'API\ordersaprodiController@poktan');
//Filter Kelompok By Desa
Route::get('poktanbyDesa/{id}', 'API\ordersaprodiController@poktanbyDesa');
Route::get('aktivitas', 'API\ordersaprodiController@aktivitas');
//Filter Aktivitas By FaseTanam
Route::get('aktivitasbyFase/{id}', 'API\ordersaprodiController@aktivitasbyFase');
//Filter Jadwal Tanam By Lahan
Route::get('scedulebyLahan/{id}', 'API\ordersaprodiController@scedulebyLahan');
//Pesanan Saprodi by ID Suplier login
Route::get('pesanansaprodibyID/{id}', 'API\ordersaprodiController@pesanansaprodibyID');
//Pesanan Saprodi by nomer PO
Route::get('pesanansaprodibyPO/{id}', 'API\ordersaprodiController@pesanansaprodibyPO');

//API CHAT
Route::post('statusLogin/{id}', 'API\chatController@statusLogin');
Route::post('statusLogout/{id}', 'API\chatController@statusLogout');
Route::post('store', 'API\chatController@store');
Route::get('show/{id}', 'API\chatController@show');
Route::delete('destroy/{id}', 'API\chatController@destroy');

//API SIMPAN LAHAN dan KEANGGOTAAN POKTAN [1 paket]
Route::post('simpanlahan', 'API\ordersaprodiController@simpanlahan');
Route::get('getIDlahan', 'API\ordersaprodiController@getIDlahan');
Route::post('simpanpoktan', 'API\ordersaprodiController@simpanpoktan');

