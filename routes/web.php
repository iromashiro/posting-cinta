<?php

use App\Http\Controllers\AllController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Models\Berita;
use App\Models\data_informasi;
use App\Models\Fasyankes;
use App\Models\Galeri;
use App\Models\layanan_publik;
use App\Models\Pai;
use App\Models\Profil;
use App\Models\Pengumuman;
use App\Models\Pmbg;
use App\Models\Ppi;
use Illuminate\Support\Facades\Route;

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

#PROFIL
Route::get('/admin/profil', function () {
    $get_all = Profil::all();
    return view('admin.profil.index', compact('get_all'));
})->name('profil.index');

Route::get('/admin/profil/tambah', function () {
    return view('admin.profil.tambah');
})->name('profil.tambah');

Route::post('/admin/profil/post', 'ProfilController@create')->name('profil.create');
Route::post('/profil-tinymce', 'ProfilController@profil_tinymce');
Route::delete('/admin/profil/delete/{id}', 'ProfilController@destroy')->name('profil.destroy');

#FASYANKES
Route::get('/admin/fasyankes', function () {
    $get_all = Fasyankes::all();
    return view('admin.fasyankes.index', compact('get_all'));
})->name('fasyankes.index');

Route::get('/admin/fasyankes/tambah', function () {
    return view('admin.fasyankes.tambah');
})->name('fasyankes.tambah');

Route::post('/admin/fasyankes/post', 'FasyankesController@create')->name('fasyankes.create');
Route::post('/fasyankes-tinymce', 'FasyankesController@fasyankes_tinymce');
Route::delete('/admin/fasyankes/delete/{id}', 'FasyankesController@destroy')->name('fasyankes.destroy');

#BERITA
Route::get('/admin/berita', function () {
    $get_all = Berita::all();
    return view('admin.berita.index', compact('get_all'));
})->name('berita.index');

Route::get('/admin/berita/tambah', function () {
    return view('admin.berita.tambah');
})->name('berita.tambah');

Route::post('/admin/berita/post', 'BeritaController@create')->name('berita.create');
Route::post('/berita-tinymce', 'BeritaController@berita_tinymce');
Route::delete('/admin/berita/delete/{id}', 'BeritaController@destroy')->name('berita.destroy');

#PENGUMUMAN
Route::get('/admin/pengumuman', function () {
    $get_all = Pengumuman::all();
    return view('admin.pengumuman.index', compact('get_all'));
})->name('pengumuman.index');

Route::get('/admin/pengumuman/tambah', function () {
    return view('admin.pengumuman.tambah');
})->name('pengumuman.tambah');

Route::post('/admin/pengumuman/post', 'PengumumanController@create')->name('pengumuman.create');
Route::post('/pengumuman-tinymce', 'PengumumanController@pengumuman_tinymce');
Route::delete('/admin/pengumuman/delete/{id}', 'PengumumanController@destroy')->name('pengumuman.destroy');

#PAI
Route::get('/admin/pai', function () {
    $get_all = Pai::all();
    return view('admin.pai.index', compact('get_all'));
})->name('pai.index');

Route::get('/admin/pai/tambah', function () {
    return view('admin.pai.tambah');
})->name('pai.tambah');

Route::post('/admin/pai/post', 'PpiController@create')->name('pai.create');
Route::post('/pai-tinymce', 'PpiController@pai_tinymce');
Route::delete('/admin/pai/delete/{id}', 'PpiController@destroy')->name('pai.destroy');

#PMBG
Route::get('/admin/pmbg', function () {
    $get_all = Pmbg::all();
    return view('admin.pmbg.index', compact('get_all'));
})->name('pmbg.index');

Route::get('/admin/pmbg/tambah', function () {
    return view('admin.pmbg.tambah');
})->name('pmbg.tambah');

Route::post('/admin/pmbg/post', 'PmbgController@create')->name('pmbg.create');
Route::post('/pmbg-tinymce', 'PmbgController@pmbg_tinymce');
Route::delete('/admin/pmbg/delete/{id}', 'PmbgController@destroy')->name('pmbg.destroy');

#PPI
Route::get('/admin/ppi', function () {
    $get_all = Ppi::all();
    return view('admin.ppi.index', compact('get_all'));
})->name('ppi.index');

Route::get('/admin/ppi/tambah', function () {
    return view('admin.ppi.tambah');
})->name('ppi.tambah');

Route::post('/admin/ppi/post', 'PpiController@create')->name('ppi.create');
Route::post('/ppi-tinymce', 'PpiController@ppi_tinymce');
Route::delete('/admin/ppi/delete/{id}', 'PpiController@destroy')->name('ppi.destroy');

#galeri
Route::get('/admin/galeri', function () {
    $get_all = Galeri::all();
    return view('admin.galeri.index', compact('get_all'));
})->name('galeri.index');

Route::get('/admin/galeri/tambah', function () {
    return view('admin.galeri.tambah');
})->name('galeri.tambah');

Route::post('/admin/galeri/post', 'GaleriController@create')->name('galeri.create');
Route::post('/galeri-tinymce', 'GaleriController@galeri_tinymce');
Route::delete('/admin/galeri/delete/{id}', 'GaleriController@destroy')->name('galeri.destroy');

#INFORMASI PUBLIK
Route::get('/admin/layanan_publik', function () {
    $get_all = layanan_publik::all();
    return view('admin.layanan_publik.index', compact('get_all'));
})->name('layanan_publik.index');

Route::get('/admin/layanan_publik/tambah', function () {
    return view('admin.layanan_publik.tambah');
})->name('layanan_publik.tambah');

Route::post('/admin/layanan_publik/post', 'layanan_publikController@create')->name('layanan_publik.create');
Route::post('/layanan_publik-tinymce', 'layanan_publikController@layanan_publik_tinymce');
Route::delete('/admin/layanan_publik/delete/{id}', 'layanan_publikController@destroy')->name('layanan_publik.destroy');

/////////////////////////// GUEST ////////////////////////////
Route::get('/', [AllController::class, 'index'])->name('index');
Route::get('/data-informasi', [AllController::class, 'index_data_informasi'])->name('id.guest');
Route::get('/profil/{slug}', [AllController::class, 'profil'])->name('profil');
Route::get('/berita/{slug}', [AllController::class, 'berita'])->name('berita.guest');
Route::get('/galeri', [AllController::class, 'galeri'])->name('galeri.guest');
Route::get('/berita', [AllController::class, 'index_berita'])->name('index_berita.guest');
Route::get('/pmbg', [AllController::class, 'pmbg'])->name('index_pmbg.guest');
Route::get('/pai', [AllController::class, 'pai'])->name('index_pai.guest');
Route::get('/ppi', [AllController::class, 'ppi'])->name('index_ppi.guest');
Route::get('/pmbg/{slug}', [AllController::class, 'pmbg_single'])->name('pmbg.guest');
Route::get('/pai/{slug}', [AllController::class, 'pai_single'])->name('pai.guest');
Route::get('/ppi/{slug}', [AllController::class, 'ppi_single'])->name('ppi.guest');
