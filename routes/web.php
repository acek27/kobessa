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


/* Pertanian */
//Route::post('/dataProvinsi/{id}', 'dataPengunjungController@dataProvinsi')->name('data.provinsi');
Route::resource('datatanaman', 'pertanian\datatanamanController');
Route::get('tabeltanaman', 'pertanian\datatanamanController@tabeltanaman')->name('tabel.tanaman');
Route::get('cektanaman/{id}', 'pertanian\datatanamanController@cektanaman');

Route::resource('datapetani', 'pertanian\petaniController');
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


Route::post('/datakelompok/{id}', 'pertanian\daftarpetaniController@datakelompok');

//fullcalender
Route::get('fullcalendar','FullCalendarController@index');
Route::post('fullcalendar/create','FullCalendarController@create');
Route::post('fullcalendar/update','FullCalendarController@update');
Route::post('fullcalendar/delete','FullCalendarController@destroy');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//razak
Route::get('tabelmoulahan/{id}', 'pertanian\daftarpetaniController@mouLahan')->name('mou.lahan');
Route::get('mouprint/{id}', 'pertanian\daftarpetaniController@print')->name('mou.print');
