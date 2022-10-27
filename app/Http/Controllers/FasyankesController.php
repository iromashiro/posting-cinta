<?php

namespace App\Http\Controllers;

use App\Models\Fasyankes;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class FasyankesController extends Controller
{
    public function fasyankes_tinymce(Request $request)
    {
        $file = $request->file('file');
        $path = url('storage/fasyankes/') . '/' . $file->getClientOriginalName();
        $imgpath = $file->move(public_path('storage/fasyankes/'), $file->getClientOriginalName());
        $fileNameToStore = $path;

        return json_encode(['location' => $fileNameToStore]);
    }

    public function create(Request $request)
    {
        $x = new Fasyankes();
        $x->nama_menu = $request->nama_menu;
        $x->isi_menu = $request->isi_menu;
        $x->slug = Str::slug($request->nama_menu);

        $x->save();

        Alert::success('Berhasil Tambah Menu Fasyankes', 'Anda Telah Menambahkan Menu Fasyankes Baru!');

        return \redirect()->route('fasyankes.index');
    }

    public function destroy($id)
    {
        Fasyankes::destroy($id);
        Alert::error('Berhasil Hapus Menu Fasyankes', 'Anda Telah Menghapus Menu Fasyankes!');
        return \redirect()->back();
    }
}
