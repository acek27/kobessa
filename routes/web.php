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



Route::get('/', 'HomeController@index');
/* Pertanian */
//Route::post('/dataProvinsi/{id}', 'dataPengunjungController@dataProvinsi')->name('data.provinsi');
Route::resource('datatanaman', 'pertanian\datatanamanController');
Route::get('tabeltanaman', 'pertanian\datatanamanController@tabeltanaman')->name('tabel.tanaman');
Route::get('cektanaman/{id}', 'pertanian\datatanamanController@cektanaman');

Route::resource('datapetani', 'pertanian\petaniController');
Route::get('/download', 'pertanian\petaniController@download')->name('download');
Route::get('datapetani/export_excel', 'pertanian\petaniController@export_excel');
Route::resource('kebutuhansaprodi', 'pertanian\kebutuhanController');
Route::get('tabelpetani', 'pertanian\petaniController@tabelpetani')->name('tabel.petani');
Route::get('cekpetani/{id}', 'pertanian\petaniController@cekpetani');
// Route::post('getdesa/{id}', 'pertanian\petaniController@getdesa')->name('getdesa');

Route::resource('kelompokpetani', 'pertanian\kelompokpetaniController');
Route::get('tabelkelompokpetani', 'pertanian\kelompokpetaniController@tabelkelompokpetani')->name('tabel.kelompokpetani');
Route::get('cekkelompokpetani/{id}', 'pertanian\kelompokpetaniController@cekkelompokpetani');

Route::resource('kepemilikanlahan', 'pertanian\kepemilikanlahanController');
Route::get('tabelkepemilikan', 'pertanian\kepemilikanlahanController@tabelkepemilikan')->name('tabel.kepemilikan');
Route::get('cekniktani/{id}', 'pertanian\kepemilikanlahanController@cekniktani');
Route::get('cekuser/{id}', 'pertanian\daftarpetaniController@cekuser'); ///baru
Route::get('cekkepemilikan/{id}', 'pertanian\kepemilikanlahanController@cekkepemilikan');

Route::get('cekhasiltani/{id}/{no}', 'pertanian\hasilpertanianController@cekhasiltani');
Route::resource('hasilpertanian', 'pertanian\hasilpertanianController');
Route::get('tabelhasil', 'pertanian\hasilpertanianController@tabelhasil')->name('tabel.hasil');
Route::get('tabelhasilpertanian', 'pertanian\hasilpertanianController@tabelcaritani')->name('tabel.caritani');
Route::get('caripetani', 'pertanian\hasilpertanianController@cari')->name('hasilpertanian.cari');

Route::resource('ordersaprodi', 'pertanian\ordersaprodiController');
Route::get('tabelsuplier', 'pertanian\ordersaprodiController@tabelsuplier')->name('tabel.suplier');
Route::get('tabelpesanansaprodi/{id}', 'pertanian\ordersaprodiController@tabelpesanansaprodi')->name('tabel.pesanansaprodi');
Route::get('tabelhistory', 'pertanian\ordersaprodiController@tabelhistory')->name('tabel.history');
Route::get('carisuplier', 'pertanian\ordersaprodiController@cari')->name('ordersaprodi.cari');


Route::resource('kebutuhan', 'pertanian\kebutuhanController');
Route::get('tabelsop', 'pertanian\kebutuhanController@tabelsop')->name('tabel.sop');
Route::get('tabelkebutuhan/{id}', 'pertanian\kebutuhanController@tabelkebutuhan')->name('tabel.kebutuhan');
Route::get('carisop', 'pertanian\kebutuhanController@cari')->name('kebutuhan.cari');


//SOP PERTANIAN
Route::resource('soppertanian', 'pertanian\soppertanianController');
Route::get('tabelsoptani', 'pertanian\soppertanianController@tabelsoptani')->name('tabel.soptani');
Route::get('tabelversisop', 'pertanian\soppertanianController@tabelversisop')->name('tabel.versisop');
Route::post('saprodisave', 'pertanian\soppertanianController@save')->name('soppertanian.save');
Route::post('simpan', 'pertanian\soppertanianController@simpan')->name('soppertanian.simpan');

Route::resource('daftarpetani', 'pertanian\daftarpetaniController');
Route::get('datanik/{kode}', 'pertanian\daftarpetaniController@data_dasar')->name('data.dasar');


Route::resource('datasaprodi', 'pertanian\saprodiController');
Route::get('tabelsaprodi', 'pertanian\saprodiController@tabelsaprodi')->name('tabel.saprodi');

Route::resource('rencanatanam', 'pertanian\rencanatanamController');
Route::get('tabelhistori', 'pertanian\rencanatanamController@tabelhistori')->name('tabel.histori');

Route::resource('aktivitas', 'pertanian\aktivitasController');
Route::get('tabelaktivitas/{id}', 'pertanian\aktivitasController@tabelaktivitas')->name('tabel.aktivitas');

//dependency
Route::post('/aktivitasdetail/{id}', 'pertanian\aktivitasController@aktivitasdetail');
Route::post('/datadesa/{id}', 'pertanian\kelompokpetaniController@datadesa');
Route::post('/hargasaprodi/{id}', 'pertanian\kebutuhanController@hargasaprodi');
Route::post('/datakelompok/{id}', 'pertanian\daftarpetaniController@datakelompok');

//fullcalender
Route::get('fullcalendar', 'FullCalendarController@index');
Route::post('fullcalendar/create', 'FullCalendarController@create');
Route::post('fullcalendar/update', 'FullCalendarController@update');
Route::post('fullcalendar/delete', 'FullCalendarController@destroy');


//EKONOMI
Route::resource('datasuplier', 'ekonomi\datasuplierController');


Route::resource('pengiriman', 'ekonomi\pengirimanController');
Route::get('caripesanan', 'ekonomi\pengirimanController@cari')->name('pesanan.cari');
Route::get('tabelpesanan', 'ekonomi\pengirimanController@tabelpesanan')->name('tabel.pesanan');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('tabelmoulahan/{id}', 'pertanian\daftarpetaniController@mouLahan')->name('mou.lahan');
Route::get('daftarpetani/print/{sop}/{id}', 'pertanian\daftarpetaniController@print')->name('mou.print'); //baru
Route::POST('ordersaprodi/{id}', 'ekonomi\pengirimanController@order')->name('order.saprodi');
Route::get('tolaksaprodi/{id}', 'ekonomi\pengirimanController@tolaksaprodi')->name('tolak.saprodi');
Route::get('terimasaprodi/{id}', 'pertanian\ordersaprodiController@terimasaprodi')->name('terima.saprodi');
Route::get('tabelhistoritanamSP', 'pertanian\rencanatanamController@tabelhistoritanamSP')->name('tabel.historitanamSP');
Route::post('/datasop/{id}', 'pertanian\rencanatanamController@datasop');
Route::resource('peta', 'pertanian\petaController');
Route::get('/ambilkoordinat/{id}', 'pertanian\kepemilikanlahanController@ambilkoordinat');
Route::get('jadwalprint/{id}', 'pertanian\rencanatanamController@print')->name('jadwal.print');

Route::resource('daftarppl', 'pertanian\pplController');
Route::get('tabelppl', 'pertanian\pplController@tabelppl')->name('tabel.ppl');

Route::post('tolakaktivitas/{id}', 'pertanian\aktivitasController@tolakaktivitas');


Route::resource('monitoring', 'pertanian\monitoringController');
Route::get('tabelaktivitas', 'pertanian\monitoringController@tabelaktivitas')->name('tabel.aktivitas');

Route::resource('petasuplier', 'pertanian\petasuplierController');
Route::get('getsop', 'pertanian\daftarpetaniController@getsop')->name('getsop'); //baru
