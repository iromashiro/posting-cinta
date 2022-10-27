<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PengumumanController extends Controller
{
    public function pengumuman_tinymce(Request $request)
    {
        $file = $request->file('file');
        $path = url('storage/pengumuman/') . '/' . $file->getClientOriginalName();
        $imgpath = $file->move(public_path('storage/pengumuman/'), $file->getClientOriginalName());
        $fileNameToStore = $path;

        return json_encode(['location' => $fileNameToStore]);
    }

    public function create(Request $request)
    {
        $a = $request->file('thumbnail');
        $b = $request->file('thumbnail')->getClientOriginalName();

        $c = Image::make($a->getRealPath())->resize(852, 480);
        $d = '/storage/thumbnail_pengumuman' . $b;
        $c = Image::make($c)->save(\public_path() . $d);

        $x = new Pengumuman();
        $x->judul = $request->judul;
        $x->isi_pengumuman = $request->isi_pengumuman;
        $x->thumbnail = $d;
        $x->slug = Str::slug($request->judul);

        $x->save();

        Alert::success('Pengumuman Sudah Diinput ke Sistem!', 'Anda Telah Menginput Pengumuman!');

        return \redirect()->route('pengumuman.index');
    }

    public function destroy($id)
    {
        Pengumuman::destroy($id);
        Alert::error('Berhasil Hapus Pengumuman', 'Anda Telah Menghapus Pengumuman!');
        return \redirect()->back();
    }
}
