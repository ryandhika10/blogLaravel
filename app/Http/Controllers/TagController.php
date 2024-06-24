<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Footer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TagController extends Controller
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
        $footer = $this->footer;
        $search = '';
        $session = '';

        if (request()->search) {
            $tag = Tag::select('id', 'nama', 'slug')->where('nama', 'like', '%' . request()->search . '%')->latest()->paginate(10);
            $search = request()->search;
            if (count($tag) == 0) {
                $session = session('sukses', 'Data yang anda cari tidak ada');
            }
        } else {
            $tag = Tag::select('nama', 'slug', 'id')->latest()->paginate(10);
        }

        return view('admin/tag/index', compact('tag', 'footer', 'session', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $footer = $this->footer;
        return view('admin/tag/create', compact('footer'));
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
            'nama' => 'required',
        ]);

        Tag::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama, '-'),
        ]);
        return redirect('/tag')->with('sukses', 'Data berhasil ditambahkan');
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
        $tag = Tag::select('nama', 'id')->whereId($id)->firstOrFail();
        return view('admin/tag/edit', compact('tag', 'footer'));
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
            'nama' => 'required',
        ]);

        Tag::whereId($id)->update([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama, '-'),
        ]);
        return redirect('/tag')->with('sukses', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tag::whereId($id)->delete();

        return redirect('/tag')->with('sukses', 'Data berhasil dihapus');
    }
}
