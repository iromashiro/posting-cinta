<?php

namespace App\Http\Controllers;

use App\Models\data_informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class DataInformasiController extends Controller
{

    public function create(Request $request)
    {
        $thumbnail = $request->file('path');
        $extension_thumbnail = $thumbnail->getClientOriginalExtension();

        $path_thumbnail = $thumbnail->storeAs('public/arsip', \time() . '.' . $extension_thumbnail);

        $x = new data_informasi();
        $x->nama_menu = $request->nama_menu;
        $x->path = $path_thumbnail;
        $x->slug = Str::slug($request->nama_menu);

        $x->save();

        Alert::success('Berhasil Tambah Menu Profil', 'Anda Telah Menambahkan Menu Profil Baru!');

        return \redirect()->route('data_informasi.index');
    }

    public function destroy($id)
    {
        data_informasi::destroy($id);
        Alert::error('Berhasil Hapus Menu Profil', 'Anda Telah Menghapus Menu Profil!');
        return \redirect()->back();
    }
}
