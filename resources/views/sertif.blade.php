@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>Input Sertif</h1>
@stop

@section('content')
<div class="row">

    <div class="col-md-8">
        <!-- Include UserTable Livewire Component -->
        @livewire('input-sertif')
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
