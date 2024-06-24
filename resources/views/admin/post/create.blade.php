@extends('sb-admin/app')
@section('title', 'Post')
@section('post', 'active')
@section('main', 'show')
@section('main-active', 'active')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Post</h1>

    <form action="/post" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="judul">Post</label>
            <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}">
            @error('judul')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="sampul">Sampul</label>
            <input type="file" class="form-control" id="sampul" name="sampul">
            @error('sampul')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="kategori">Kategori</label>
            <select name="kategori" id="kategori" class="form-control">
                <option selected disabled>Pilih Kategori</option>
                @foreach ($kategori as $row)
                    <option value="{{ $row->id }}">{{ $row->nama }}</option>
                @endforeach
            </select>
            @error('kategori')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="tag">Tag</label>
            <select multiple name="tag[]" id="tag" class="form-control">
                @foreach ($tag as $row)
                    <option value="{{ $row->id }}">{{ $row->nama }}</option>
                @endforeach
            </select>
            @error('tag')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="editor">Konten</label>
            <textarea class="form-control" id="editor" rows="10" name="konten">{{ old('konten') }}</textarea>
        </div>
        @error('konten')
            <small class="text-danger">{{ $message }}</small>
        @enderror
        <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
        <a href="/post" class="btn btn-secondary btn-sm">Kembali</a>
    </form>

@endsection
@section('ck-editor')
    @include('ckeditor/setting')
@endsection