@extends('artikel/template/app')

    @isset($tag_dipilih)
        @section('title')
            Tag : {{ $tag_dipilih->nama }}
        @endsection
    @endisset

    @isset($kategori_dipilih)
        @section('title')
            Kategori : {{ $kategori_dipilih->nama }}
        @endsection
        @section('kategori', 'active')
    @endisset

    @isset($author_dipilih)
        @section('title')
            Author : {{ $author_dipilih->name }}
        @endsection
        @section('author', 'active')
    @endisset

    @isset($home)
        @section('title', 'Semua Post')
        @section('home', 'active')
    @endisset
    
@section('content')
    @isset($banner)
        <div id="carouselExampleIndicators" class="carousel slide mt-4" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach ($banner as $row)
                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $loop->index}}" class="{{ ($loop->first) ? 'active' : '' }}"></li>
                @endforeach
            </ol>
            <div class="carousel-inner">
                @foreach ($banner as $row)
                    <div class="carousel-item {{ ($loop->first) ? 'active' : ''}}">
                        <a href="/artikel-banner/{{ $row->slug }}"><img src="/upload/banner/{{ $row->sampul }}" height ="400px" class="d-block w-100" alt="..."></a>
                        <div class="carousel-caption d-none d-md-block">
                            <h3>{{ $row->judul }}</h3>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-target="#carouselExampleIndicators" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </button>
        </div>
    @endisset

    @isset($rekomendasi)
        @if ($rekomendasi->isNotEmpty())
            <h2 class="my-4 text-center">Rekomendasi</h2>

            <div class="row mt-4 justify-content-center">
                @foreach ($rekomendasi as $row)
                    <div class="col-md-4 mt-5">
                        <div class="card shadow-sm">
                            <a href="/{{ $row->post->slug }}"><img src="/upload/post/{{ $row->post->sampul }}" class="card-img-top" height="200px" alt="..."></a>
                            <div class="card-body">
                                <h5 class="card-title">{{ $row->post->judul }}</h5>
                                <p class="card-text"><small class="text-muted">{{ $row->post->created_at->diffForHumans() }}</small></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endisset
    
    <h2 class="my-4 text-center">@yield('title')</h2>
    
    <div class="d-flex justify-content-center">
        <form class="form-inline my-2 my-lg-0" method="GET" action="{{ url()->full() }}">
            <input name="search" class="form-control mr-sm-2" type="search" placeholder="Search For ..." aria-label="Search" value="{{ $search }}">
            <button class="btn btn-primary my-2 my-sm-0 mx-auto" type="submit">Search</button>
        </form>
    </div>

    @if ($session)
        <div class="row mt-4 justify-content-center text-center">
            <div class="col-md-6">
                <div class="alert alert-info" role="alert">
                    {{ $session }}
                </div>
            </div>
        </div>
    @else
        <div class="row mt-4">
            @foreach ($artikel as $row)
                <div class="col-md-4 mt-5">
                    <div class="card shadow-sm">
                        <a href="/{{ $row->slug }}"><img src="/upload/post/{{ $row->sampul }}" class="card-img-top" height="200px" alt="..."></a>
                        <div class="card-body">
                            <h5 class="card-title">{{ $row->judul }}</h5>
                            <p class="card-text"><small class="text-muted">{{ $row->created_at->diffForHumans() }}</small></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="d-flex justify-content-center mt-4">
        {{ $artikel->links() }}
    </div>
@endsection