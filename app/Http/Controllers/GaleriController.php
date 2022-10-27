<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class GaleriController extends Controller
{
    public function create(Request $request)
    {
        $thumbnail = $request->file('path');
        $extension_thumbnail = $thumbnail->getClientOriginalExtension();

        $path_thumbnail = $thumbnail->storeAs('public/arsip', \time() . '.' . $extension_thumbnail);

        $x = new Galeri();
        $x->nama_menu = $request->nama_menu;
        $x->path = $path_thumbnail;
        $x->slug = Str::slug($request->nama_menu);

        $x->save();

        Alert::success('Berhasil Tambah Galeri', 'Anda Telah Menambahkan Galeri Baru!');

        return \redirect()->route('galeri.index');
    }

    public function destroy($id)
    {
        Galeri::destroy($id);
        Alert::error('Berhasil Hapus Galeri', 'Anda Telah Menghapus Galeri!');
        return \redirect()->back();
    }
}
