@extends('adminlte::page')

@section('title', 'LunchHub')

{{-- Header opcional --}}
@section('content_header')
    @yield('content_header')
@endsection

{{-- Contenido principal --}}
@section('content')
    @yield('content')
@endsection

{{-- CSS propio --}}
@section('css')
    <link rel="stylesheet" href="{{ asset('archivos/appblade.css') }}">
@endsection

{{-- JS propio --}}
@section('js')
    <script src="{{ asset('archivos/tables/table.js') }}"></script>
@endsection
