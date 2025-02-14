<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Footer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class BannerController extends Controller
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
            $banner = Banner::select('id', 'judul', 'slug', 'sampul')->where('judul', 'like', '%' . request()->search . '%')->latest()->paginate(10);
            $search = request()->search;
            if (count($banner) == 0) {
                $session = session('sukses', 'Data yang anda cari tidak ada');
            }
        } else {
            $banner = Banner::select('judul', 'id', 'slug', 'sampul')->latest()->paginate(10);
        }
        return view('admin/banner/index', compact('banner', 'footer', 'search', 'session'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $footer = $this->footer;
        return view('admin/banner/create', compact('footer'));
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
            'judul' => 'required',
            'sampul' => 'required|mimes:jpg,jpeg,png',
            'konten' => 'required',
        ]);

        $sampul = time() . '-' . $request->sampul->getClientOriginalName();
        $request->sampul->move('upload/banner', $sampul);

        Banner::create([
            'sampul' => $sampul,
            'judul' => $request->judul,
            'konten' => $request->konten,
            'slug' => Str::slug($request->judul, '-'),
        ]);

        Alert::success('Sukses', 'Data berhasil ditambahkan');
        return redirect('/banner');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $footer = $this->footer;
        $banner = Banner::select('id', 'sampul', 'konten', 'judul', 'created_at')->whereId($id)->firstOrFail();
        return view('admin/banner/show', compact('banner', 'footer'));
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
        $banner = Banner::select('id', 'sampul', 'konten', 'judul')->whereId($id)->firstOrFail();
        return view('admin/banner/edit', compact('banner', 'footer'));
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
            'judul' => 'required',
            'sampul' => 'mimes:jpg,jpeg,png',
            'konten' => 'required',
        ]);

        $data = [
            'judul' => $request->judul,
            'konten' => $request->konten,
            'slug' => Str::slug($request->judul, '-'),
        ];

        $banner = Banner::select('sampul', 'id')->whereId($id)->first();
        if ($request->sampul) {
            File::delete('upload/banner/' . $banner->sampul);

            $sampul = time() . '-' . $request->sampul->getClientOriginalName();
            $request->sampul->move('upload/banner', $sampul);

            $data['sampul'] = $sampul;
        }

        $banner->update($data);

        Alert::success('Sukses', 'Data berhasil diubah');
        return redirect('/banner');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function konfirmasi($id)
    {
        // example:
        alert()->question('Peringatan !', 'Anda yakin akan menghapus data ?')
            ->showConfirmButton('<a href="/banner/' . $id . '/delete" class="text-white" style="text-decoration: none"> Hapus</a>', '#3085d6')->toHtml()
            ->showCancelButton('Batal', '#aaa')->reverseButtons();

        return redirect('/banner');
    }

    public function delete($id)
    {
        $banner = Banner::select('sampul', 'id')->whereId($id)->firstOrFail();
        File::delete('upload/banner/' . $banner->sampul);
        $banner->delete();

        Alert::success('Sukses', 'Data berhasil dihapus');
        return redirect('/banner');
    }
}
