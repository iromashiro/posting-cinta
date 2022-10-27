<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class BeritaController extends Controller
{
    public function berita_tinymce(Request $request)
    {
        $file = $request->file('file');
        $path = url('storage/berita/') . '/' . $file->getClientOriginalName();
        $imgpath = $file->move(public_path('storage/berita/'), $file->getClientOriginalName());
        $fileNameToStore = $path;

        return json_encode(['location' => $fileNameToStore]);
    }

    public function create(Request $request)
    {
        $a = $request->file('thumbnail');
        $b = $request->file('thumbnail')->getClientOriginalName();

        $c = Image::make($a->getRealPath())->resize(852, 480);
        $d = '/storage/thumbnail_berita' . $b;
        $c = Image::make($c)->save(\public_path() . $d);

        $x = new Berita();
        $x->judul = $request->judul;
        $x->isi_berita = $request->isi_berita;
        $x->thumbnail = $d;
        $x->slug = Str::slug($request->judul);

        $x->save();

        Alert::success('Berita Sudah Diinput ke Sistem!', 'Anda Telah Menginput Berita!');

        return \redirect()->route('berita.index');
    }

    public function destroy($id)
    {
        Berita::destroy($id);
        Alert::error('Berhasil Hapus Berita', 'Anda Telah Menghapus Berita!');
        return \redirect()->back();
    }
}
