<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Like;
use App\Models\Logo;
use App\Models\Post;
use App\Models\User;
use App\Models\Banner;
use App\Models\Footer;
use App\Models\Tentang;
use App\Models\Kategori;
use App\Models\Rekomendasi;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class ArtikelController extends Controller
{
    public function __construct()
    {
        $this->footer = Footer::select('konten')->first();
    }

    public function index()
    {
        $footer = $this->footer;
        $logo = Logo::select('gambar')->first();
        $banner = Banner::select('slug', 'sampul', 'judul')->latest()->get();
        $session = '';

        if (request()->search) {
            $search = request()->search;
            $artikel = Post::select('sampul', 'judul', 'slug', 'created_at')->where('judul', 'like', '%' . request()->search . '%')->latest()->paginate(6);
            if (count($artikel) == 0) {
                $session = session('sukses', 'Post yang anda cari tidak ada');
            }
        } else {
            $artikel = Post::select('sampul', 'judul', 'slug', 'created_at')->latest()->paginate(6);
            $search = '';
        }

        $kategori = Kategori::select('slug', 'nama')->orderBy('nama', 'asc')->get();
        $home = true;
        $author = User::getAdminPenulis();
        $rekomendasi = Rekomendasi::select('id_post')->latest()->paginate(3);
        return view('artikel/index', compact('artikel', 'kategori', 'banner', 'logo', 'footer', 'home', 'author', 'session', 'search', 'rekomendasi'));
    }

    public function artikel($slug)
    {
        $footer = $this->footer;
        $logo = Logo::select('gambar')->first();
        $artikel = Post::select('id', 'sampul', 'judul', 'konten', 'id_kategori', 'created_at', 'id_user')->where('slug', $slug)->firstOrFail();
        $kategori = Kategori::select('slug', 'nama')->orderBy('nama', 'asc')->get();
        $author = User::getAdminPenulis();
        $like = Like::where('id_post', $artikel->id)->count();
        return view('artikel/artikel', compact('artikel', 'kategori', 'logo', 'footer', 'author', 'like'));
    }

    public function kategori($slug)
    {
        $footer = $this->footer;
        $logo = Logo::select('gambar')->first();
        $kategori = Kategori::select('id')->where('slug', $slug)->firstOrFail();
        $session = '';

        if (request()->search) {
            $search = request()->search;
            $artikel = Post::select('sampul', 'judul', 'slug', 'created_at')->where('id_kategori', $kategori->id)->where('judul', 'like', '%' . request()->search . '%')->latest()->paginate(6);
            if (count($artikel) == 0) {
                $session = session('sukses', 'Post yang anda cari tidak ada');
            }
        } else {
            $artikel = Post::select('sampul', 'judul', 'slug', 'created_at')->where('id_kategori', $kategori->id)->latest()->paginate(6);
            $search = '';
        }

        $kategori = Kategori::select('slug', 'nama')->orderBy('nama', 'asc')->get();
        $kategori_dipilih = Kategori::select('nama', 'slug')->where('slug', $slug)->firstOrFail();
        $author = User::getAdminPenulis();
        return view('artikel/index', compact('artikel', 'kategori', 'logo', 'footer', 'kategori_dipilih', 'author', 'session', 'search'));
    }

    public function tag($slug)
    {
        $footer = $this->footer;
        $logo = Logo::select('gambar')->first();
        $artikel = Tag::select('id')->where('slug', $slug)->latest()->firstOrFail();
        $artikel = $this->paginate($artikel->post);
        $artikel->withPath(request()->url());
        $kategori = Kategori::select('slug', 'nama')->orderBy('nama', 'asc')->get();
        $session = '';
        $search = '';

        if (request()->search) {
            $search = request()->search;
            $filter = $artikel->filter(function ($item) use ($search) {
                if (stripos($item->judul, $search) !== false) {
                    return true;
                }
            });
            $artikel = $this->paginate($filter);

            if (count($artikel) == 0) {
                $session = session('sukses', 'Post yang anda cari tidak ada');
            }
        }

        $tag_dipilih = Tag::select('nama')->where('slug', $slug)->firstOrFail();
        $author = User::getAdminPenulis();
        $rekomendasi = Rekomendasi::select('id_post')->latest()->paginate(3);
        return view('artikel/index', compact('artikel', 'kategori', 'logo', 'footer', 'tag_dipilih', 'author', 'search', 'session'));
    }

    public function paginate($items, $perPage = 6, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function banner($slug)
    {
        $footer = $this->footer;
        $logo = Logo::select('gambar')->first();
        $banner = Banner::select('id', 'judul', 'konten', 'sampul', 'created_at')->where('slug', $slug)->firstOrFail();
        $kategori = Kategori::select('slug', 'nama')->orderBy('nama', 'asc')->get();
        $author = User::getAdminPenulis();
        return view('artikel/banner', compact('banner', 'kategori', 'logo', 'footer', 'author'));
    }
    public function tentang()
    {
        $footer = $this->footer;
        $logo = Logo::select('gambar')->first();
        $kategori = Kategori::select('slug', 'nama')->orderBy('nama', 'asc')->get();
        $tentang = Tentang::select('konten', 'facebook', 'twitter', 'instagram')->first();
        $author = User::getAdminPenulis();
        return view('artikel/tentang', compact('kategori', 'logo', 'footer', 'tentang', 'author'));
    }

    public function author($id)
    {
        $footer = $this->footer;
        $logo = Logo::select('gambar')->first();
        $session = '';

        if (request()->search) {
            $search = request()->search;
            $artikel = Post::select('sampul', 'judul', 'slug', 'created_at')->where('id_user', $id)->where('judul', 'like', '%' . request()->search . '%')->latest()->paginate(6);
            if (count($artikel) == 0) {
                $session = session('sukses', 'Post yang anda cari tidak ada');
            }
        } else {
            $artikel = Post::select('sampul', 'judul', 'slug', 'created_at')->where('id_user', $id)->latest()->paginate(6);
            $search = '';
        }

        $kategori = Kategori::select('slug', 'nama')->orderBy('nama', 'asc')->get();
        $author_dipilih = User::select('id', 'name')->whereId($id)->firstOrFail();
        $author = User::getAdminPenulis();
        return view('artikel/index', compact('artikel', 'kategori', 'logo', 'footer', 'author', 'author_dipilih', 'search', 'session'));
    }
}
