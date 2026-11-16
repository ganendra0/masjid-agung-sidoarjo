@extends('layouts.app')

@section('title', 'Halaman tidak ditemukan')
@section('robots', 'noindex')

@section('content')
    <section class="section">
        <div class="container-page max-w-xl text-center">
            <p class="text-7xl font-extrabold text-gold">404</p>
            <h1 class="mt-4 text-3xl font-extrabold text-primary-dark">Halaman tidak ditemukan</h1>
            <p class="mt-3 text-gray-600">Halaman yang Anda cari tidak tersedia, sudah dipindahkan, atau belum dipublikasikan.</p>
            <a href="{{ route('home') }}" class="btn-primary mt-8">Kembali ke Beranda</a>
        </div>
    </section>
@endsection
