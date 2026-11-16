@extends('layouts.app')

@section('title', 'Beranda')
@section('description', \App\Support\Text::plain($profile->tagline ?: $profile->description, 160))

@section('content')
    @include('home.hero')
    @include('home.profile')
    @include('home.agenda')
    @include('home.news')
    @include('home.studies')
    @include('home.gallery')
    @include('home.info')
@endsection
