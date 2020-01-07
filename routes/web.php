<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});
/*Peternakan*/
Route::resource('dataternak', 'peternakan\dataTernakController');
Route::get('tabelternak', 'peternakan\dataTernakController@tabelternak')->name('tabel.ternak');
Route::get('cekternak/{id}', 'peternakan\dataTernakController@cekternak');

Route::resource('datapeternak', 'peternakan\peternakController');
Route::get('tabelpeternak', 'peternakan\peternakController@tabelpeternak')->name('tabel.peternak');
Route::get('cekpeternak/{id}', 'peternakan\peternakController@cekpeternak');

Route::resource('kelompokpeternak', 'peternakan\kelompokpeternakController');
Route::get('tabelkelompokpeternak', 'peternakan\kelompokpeternakController@tabelkelompokpeternak')->name('tabel.kelompokpeternak');
Route::get('cekkelompokpeternak/{id}', 'peternakan\kelompokpeternakController@cekkelompokpeternak');

Route::resource('keanggotaanpeternak', 'peternakan\keanggotaanpeternakController');
Route::get('tabelkeanggotaanpeternak', 'peternakan\keanggotaanpeternakController@tabelpokter')->name('tabel.pokter');
Route::get('ceknik/{id}', 'peternakan\keanggotaanpeternakController@ceknik');
Route::get('cekkeanggotaanpeternak/{id}', 'peternakan\keanggotaanpeternakController@cekkeanggotaanpeternak');

Route::get('cekhasil/{id}/{no}', 'peternakan\hasilpeternakanController@cekhasil');
Route::get('penjualan/', 'peternakan\hasilpeternakanController@penjualan')->name('hasilpeternakan.penjualan');
// Route::resource('kepemilikan', 'peternakan\kepemilikanController');
// Route::get('tabelkepemilikan', 'peternakan\kepemilikanController@tabelkepemilikan')->name('tabel.kepemilikan');
// Route::get('ceknik/{id}', 'peternakan\kepemilikanController@ceknik');

// Route::resource('kotoranternak', 'peternakan\kotoraternakController');
Route::resource('hasilpeternakan', 'peternakan\hasilpeternakanController');
Route::get('tabelhasil', 'peternakan\hasilpeternakanController@tabelhasil')->name('tabel.hasil');
Route::get('tabelhasilpeternakan', 'peternakan\hasilpeternakanController@tabelcaripeternak')->name('tabel.caripeternak');
Route::get('caripeternak', 'peternakan\hasilpeternakanController@cari')->name('hasilpeternakan.cari');



/* Pertanian */
//Route::post('/dataProvinsi/{id}', 'dataPengunjungController@dataProvinsi')->name('data.provinsi');
Route::resource('datatanaman', 'pertanian\datatanamanController');
Route::get('tabeltanaman', 'pertanian\datatanamanController@tabeltanaman')->name('tabel.tanaman');
Route::get('cektanaman/{id}', 'pertanian\datatanamanController@cektanaman');

Route::resource('datapetani', 'pertanian\petaniController');
Route::resource('kebutuhansaprodi', 'pertanian\kebutuhanController');
Route::get('tabelpetani', 'pertanian\petaniController@tabelpetani')->name('tabel.petani');
Route::get('mouprint/{id}', 'pertanian\daftarpetaniController@print')->name('mou.print');
Route::get('cekpetani/{id}', 'pertanian\petaniController@cekpetani');
// Route::post('getdesa/{id}', 'pertanian\petaniController@getdesa')->name('getdesa');

Route::resource('kelompokpetani', 'pertanian\kelompokpetaniController');
Route::get('tabelkelompokpetani', 'pertanian\kelompokpetaniController@tabelkelompokpetani')->name('tabel.kelompokpetani');
Route::get('cekkelompokpetani/{id}', 'pertanian\kelompokpetaniController@cekkelompokpetani');

Route::resource('kepemilikanlahan', 'pertanian\kepemilikanlahanController');
Route::get('tabelkepemilikan', 'pertanian\kepemilikanlahanController@tabelkepemilikan')->name('tabel.kepemilikan');
Route::get('cekniktani/{id}', 'pertanian\kepemilikanlahanController@cekniktani');
Route::get('cekkepemilikan/{id}', 'pertanian\kepemilikanlahanController@cekkepemilikan');

Route::get('cekhasiltani/{id}/{no}', 'pertanian\hasilpertanianController@cekhasiltani');
Route::resource('hasilpertanian', 'pertanian\hasilpertanianController');
Route::get('tabelhasil', 'pertanian\hasilpertanianController@tabelhasil')->name('tabel.hasil');
Route::get('tabelhasilpertanian', 'pertanian\hasilpertanianController@tabelcaritani')->name('tabel.caritani');
Route::get('caripetani', 'pertanian\hasilpertanianController@cari')->name('hasilpertanian.cari');

Route::resource('kebutuhan', 'pertanian\kebutuhanController');
Route::get('tabellahan', 'pertanian\kebutuhanController@tabellahan')->name('tabel.lahan');
Route::get('carilahan', 'pertanian\kebutuhanController@cari')->name('kebutuhan.cari');

Route::resource('soppertanian', 'pertanian\soppertanianController');
Route::get('tabelsoptani', 'pertanian\soppertanianController@tabelsoptani')->name('tabel.soptani');

Route::resource('daftarpetani', 'pertanian\daftarpetaniController');


Route::resource('datasaprodi', 'pertanian\saprodiController');
Route::get('tabelsaprodi', 'pertanian\saprodiController@tabelsaprodi')->name('tabel.saprodi');


//dependency
Route::post('/datadesa/{id}', 'peternakan\kelompokpeternakController@datadesa');
Route::post('/datakelompok/{id}', 'pertanian\daftarpetaniController@datakelompok');

//fullcalender
Route::get('fullcalendar','FullCalendarController@index');
Route::post('fullcalendar/create','FullCalendarController@create');
Route::post('fullcalendar/update','FullCalendarController@update');
Route::post('fullcalendar/delete','FullCalendarController@destroy');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
