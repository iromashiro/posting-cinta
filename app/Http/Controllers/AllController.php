<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Berita;
use App\Models\data_informasi;
use App\Models\Galeri;
use App\Models\Pai;
use App\Models\Pengumuman;
use App\Models\Pmbg;
use App\Models\Ppi;
use App\Models\Profil;
use Illuminate\Http\Request;

class AllController extends Controller
{
    public function index()
    {
        $profil = Profil::all();
        $berita_header = Berita::orderBy('created_at', 'desc')->take(3)->get();
        $berita = Berita::orderBy('created_at', 'desc')->take(3)->get();
        $pengumuman = Pengumuman::limit(5)->get();
        return view('index', compact('profil', 'berita_header', 'berita', 'pengumuman'));
    }

    public function profil($slug)
    {
        $profil = Profil::all();
        $profils = Profil::where('slug', $slug)->first();
        $pn = Berita::orderBy('created_at', 'desc')->take(5)->get();
        $rn = Berita::orderBy('created_at', 'asc')->take(4)->get();
        $pengumuman = Pengumuman::limit(5)->get();

        return view('profil', compact('profil', 'profils', 'pengumuman', 'rn', 'pn'));
    }

    public function berita($slug)
    {
        $berita = Berita::where('slug', '=', $slug)->first();
        $pn = Berita::orderBy('created_at', 'desc')->take(5)->get();
        $rn = Berita::orderBy('created_at', 'asc')->take(4)->get();
        $profil = Profil::all();
        return view('berita-single', compact('berita', 'profil', 'rn', 'pn'));
    }

    public function index_data_informasi()
    {
        $di = data_informasi::paginate(5);
        $profil = Profil::all();
        return view('data-informasi', compact('di', 'profil'));
    }

    public function galeri()
    {
        $galeri = Galeri::all();
        $profil = Profil::all();
        return view('galeri', compact('galeri', 'profil'));
    }

    public function index_berita()
    {
        $berita = Berita::paginate(5);
        $galeri = Galeri::all();
        $profil = Profil::all();
        $berita_side = Berita::paginate(3);
        $artikel_side = Pengumuman::paginate(3);
        return view('berita', compact('galeri', 'profil', 'berita', 'berita_side', 'artikel_side'));
    }

    public function pmbg()
    {
        $berita = Pmbg::paginate(5);
        $galeri = Galeri::all();
        $profil = Profil::all();
        $berita_side = Berita::paginate(3);
        $artikel_side = Pengumuman::paginate(3);
        return view('pmbg', compact('galeri', 'profil', 'berita', 'berita_side', 'artikel_side'));
    }

    public function pai()
    {
        $berita = Pai::paginate(5);
        $galeri = Galeri::all();
        $profil = Profil::all();
        $berita_side = Berita::paginate(3);
        $artikel_side = Pengumuman::paginate(3);
        return view('pai', compact('galeri', 'profil', 'berita', 'berita_side', 'artikel_side'));
    }

    public function ppi()
    {
        $berita = Ppi::paginate(5);
        $galeri = Galeri::all();
        $profil = Profil::all();
        $berita_side = Berita::paginate(3);
        $artikel_side = Pengumuman::paginate(3);
        return view('ppi', compact('galeri', 'profil', 'berita', 'berita_side', 'artikel_side'));
    }

    public function pmbg_single($slug)
    {
        $berita = Pmbg::where('slug', '=', $slug)->first();
        $pn = Berita::orderBy('created_at', 'desc')->take(5)->get();
        $rn = Berita::orderBy('created_at', 'asc')->take(4)->get();
        $profil = Profil::all();
        return view('pmbg-single', compact('berita', 'profil', 'rn', 'pn'));
    }

    public function pai_single($slug)
    {
        $berita = Pai::where('slug', '=', $slug)->first();
        $pn = Berita::orderBy('created_at', 'desc')->take(5)->get();
        $rn = Berita::orderBy('created_at', 'asc')->take(4)->get();
        $profil = Profil::all();
        return view('pai-single', compact('berita', 'profil', 'rn', 'pn'));
    }

    public function ppi_single($slug)
    {
        $berita = Ppi::where('slug', '=', $slug)->first();
        $pn = Berita::orderBy('created_at', 'desc')->take(5)->get();
        $rn = Berita::orderBy('created_at', 'asc')->take(4)->get();
        $profil = Profil::all();
        return view('ppi-single', compact('berita', 'profil', 'rn', 'pn'));
    }
}
