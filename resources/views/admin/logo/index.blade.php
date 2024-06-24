@extends('sb-admin/app')
@section('title', 'Logo')
@section('pengaturan', 'show')
@section('logo', 'active')
@section('pengaturan-active', 'active')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Logo</h1>

    <a href="/logo/{{ $logo->id }}/edit" class="btn btn-primary btn-sm"><i class="fa-solid fa-edit"></i> Edit Logo</a>

    <div class="card mt-4">
        <img src="/upload/logo/{{ $logo->gambar }}"  height="500px" class="card-img-top" alt="...">
    </div>
@endsection