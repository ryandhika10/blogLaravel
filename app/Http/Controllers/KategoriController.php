<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class KategoriController extends Controller
{

    public function __construct()
    {
        $this->footer = Footer::select('konten')->first();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = '';
        $session = '';
        $footer = $this->footer;
        if (request()->search) {
            $kategori = Kategori::select('id', 'nama', 'slug')->where('nama', 'like', '%' . request()->search . '%')->latest()->paginate(10);
            $search = request()->search;
            if (count($kategori) == 0) {
                $session = session('sukses', 'Data yang anda cari tidak ada');
            }
        } else {
            $kategori = Kategori::select('id', 'nama', 'slug')->latest()->paginate(10);
        }

        return view('admin/kategori/index', compact('kategori', 'footer', 'session', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $footer = $this->footer;
        return view('admin/kategori/create', compact('footer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        Kategori::create([
            'nama' => Str::title($request->nama),
            'slug' => Str::slug($request->nama, '-'),
        ]);

        return redirect('/kategori')->with('sukses', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $footer = $this->footer;
        $kategori = Kategori::select('id', 'nama')->where('id', $id)->first();
        return view('admin/kategori/edit', compact('kategori', 'footer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        Kategori::whereId($id)->update([
            'nama' => Str::title($request->nama),
            'slug' => Str::slug($request->nama, '-'),
        ]);

        return redirect('/kategori')->with('sukses', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Kategori::whereId($id)->delete();

        return redirect('/kategori')->with('sukses', 'Data berhasil dihapus');
    }
}
