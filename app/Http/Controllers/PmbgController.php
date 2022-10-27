<?php

namespace App\Http\Controllers;

use App\Models\Pmbg;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class PmbgController extends Controller
{
    public function create(Request $request)
    {
        $thumbnail = $request->file('path');
        $extension_thumbnail = $thumbnail->getClientOriginalExtension();

        $path_thumbnail = $thumbnail->storeAs('public/arsip', \time() . '.' . $extension_thumbnail);

        $x = new Pmbg();
        $x->nama_menu = $request->nama_menu;
        $x->path = $path_thumbnail;
        $x->slug = Str::slug($request->nama_menu);

        $x->save();

        Alert::success('Berhasil Tambah Menu Profil', 'Anda Telah Menambahkan Menu Profil Baru!');

        return \redirect()->route('pmbg.index');
    }

    public function destroy($id)
    {
        Pmbg::destroy($id);
        Alert::error('Berhasil Hapus Menu Profil', 'Anda Telah Menghapus Menu Profil!');
        return \redirect()->back();
    }
}
