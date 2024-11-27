@extends('adminlte::page')

@section('title', 'Profile')

@section('content')
    <div class="row">

        <div class="col-md-10">
            <!-- Include UserTable Livewire Component -->
            @livewire('api-sertif')
        </div>
        <div class="col-md-20">
            <!-- Include UserTable Livewire Component -->
            @livewire('sertif')
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
