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
Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::get('details/{id}', 'API\UserController@details');

Route::post('ubahpass', 'API\UserController@ubahpass');

//JADWAL TANAM
Route::get('jadwalair', 'API\jadwaltanamController@jadwalair');
Route::get('soppertanian/{id}', 'API\jadwaltanamController@soppertanian');
Route::get('soppertanian1', 'API\jadwaltanamController@soppertanian1');
 
Route::get('lahan/{id}', 'API\jadwaltanamController@lahan'); //belum
Route::get('lahanbyPPL/{id}', 'API\jadwaltanamController@lahanbyPPL'); //belum //ppl-data lahan

Route::get('jenistanaman', 'API\jadwaltanamController@jenistanaman');
Route::get('ambilPT/{id}', 'API\jadwaltanamController@ambilPT'); // belum
Route::post('metodebenih', 'API\jadwaltanamController@metodebenih'); // belum [bawa idfase dan aktivitas by idversisop] 
Route::post('metodetanam', 'API\jadwaltanamController@metodetanam'); // belum [bawa idfase dan aktivitas by idversisop] 
Route::post('simpanjadwaltanam', 'API\jadwaltanamController@simpanjadwaltanam');  //belum
Route::post('simpanjadwalbertani', 'API\jadwaltanamController@simpanjadwalbertani'); //belum

//AKTIVITAS
Route::get('fasetanam', 'API\aktivitasController@fasetanam');
Route::get('ambilIDbertani/{id}', 'API\aktivitasController@ambilIDbertani');
Route::post('simpanaktivitas', 'API\aktivitasController@simpanaktivitas'); // Menu Aktivitas Petani [tombol YES]
Route::get('loadaktivitas/{id}', 'API\aktivitasController@loadaktivitas'); //ppl-histori aktivitas // MONITORING aktivitas petani (lahan) by ID PPL hanya untuk petani yang terlambat melakukan aktivitas
Route::get('lahanbyJB/{nik}', 'API\aktivitasController@lahanbyJB'); //load lahan sebelum schedule,aktivitas petani
Route::get('aktivitasbylahanbyJB/{id}', 'API\aktivitasController@aktivitasbylahanbyJB'); //isi kalender [jadwal bertani petani selama 1x panen] berdasarkan periode terakhir yg sedang aktif
Route::get('aktivitasbySOP/{id}', 'API\aktivitasController@aktivitasbySOP'); //Load data AKTIVITAS Petani [1 Aktivitas yg harus dilakukan]

//ORDER SAPRODI
Route::get('suplier', 'API\ordersaprodiController@suplier'); //belum
Route::get('pilihsuplierbyID/{id}', 'API\ordersaprodiController@pilihsuplierbyID'); //belum // tampilkan data suplier berdasarkan idsuplier yg dipilih
Route::get('suplierbyLogin/{nik}', 'API\ordersaprodiController@suplierbyLogin'); // Tampil Data Suplier By Login [nik suplier = id suplier]
Route::get('saprodi', 'API\ordersaprodiController@saprodi'); //belum
Route::post('simpanorder', 'API\ordersaprodiController@simpanorder'); // Simpan Pesanan Saprodi Petani [Menu Petani]  //belum
//Route::post('simpanKS', 'API\ordersaprodiController@simpanKS');  // Simpan Kebutuhan Saprodi Tiap Lahan [Menu PPL]
Route::get('desa', 'API\ordersaprodiController@desa'); 
Route::get('kecamatan', 'API\ordersaprodiController@kecamatan');
Route::get('historypesanan/{nik}', 'API\ordersaprodiController@historypesanan'); // petani // tampil history pesanan petani berdasarkan nik petani
Route::get('pesananbysuplier/{id}', 'API\ordersaprodiController@pesananbysuplier'); //supplier // tampil semua pesanan berdasarkan idsuplier
Route::get('pesananbyPO/{po}', 'API\ordersaprodiController@pesananbyPO'); //suplier // tampilkan data pesanan berdasarkan PO
Route::get('statuspesananbyPO/{po}', 'API\ordersaprodiController@statuspesananbyPO'); // suplier // get status pesanan by no PO
Route::post('setujuipesanan/{po}', 'API\ordersaprodiController@setujuipesanan'); // suplier [tombol setuju harus mengisi jumlah saprodi yang disetujui]
Route::post('tolakpesanan/{po}', 'API\ordersaprodiController@tolakpesanan'); // suplier [tombol tolak pesanan]
Route::post('kirimpesanan/{po}', 'API\ordersaprodiController@kirimpesanan'); // suplier [tombol kirim pesanan]
Route::post('terimapesanan/{po}', 'API\ordersaprodiController@terimapesanan'); // petani [tombol terima pesanan] di history pesanan

//Filter Desa by Kecamatan
Route::get('desabyKecamatan/{id}', 'API\ordersaprodiController@desabyKecamatan'); // tampilkan desa sesuai kecamatan
Route::get('poktan', 'API\ordersaprodiController@poktan'); // tampilkan daftar semua poktan
//Filter Kelompok By Desa
Route::get('poktanbyDesa/{id}', 'API\ordersaprodiController@poktanbyDesa'); // tampilkan poktan berdasarkan desa

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

//API SIMPAN PETANI
Route::post('cekdatapetani', 'API\petaniController@cekdatapetani');
Route::post('simpanpetani', 'API\petaniController@simpanpetani');
Route::post('updatepetani', 'API\petaniController@updatepetani');

//API SIMPAN KELOMPOK TANI 
Route::post('cekkelompok', 'API\petaniController@cekkelompok');
Route::post('simpankelompok', 'API\petaniController@simpankelompok');
//Update Kelompok Petani melalui WEB dengan user Dinas Pertanian

//API SIMPAN LAHAN dan KEANGGOTAAN POKTAN [1 paket]
Route::post('simpanlahan', 'API\ordersaprodiController@simpanlahan');
Route::get('getIDlahan', 'API\ordersaprodiController@getIDlahan');
Route::post('simpanpoktan', 'API\ordersaprodiController@simpanpoktan');

