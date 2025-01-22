@extends('adminlte::page')

@section('title', 'Dashboard')
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
        <div class="row">

        <div class="col-md-8">
            <!-- Include UserTable Livewire Component -->
            @livewire('realisasi')
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
<script>
    function formatRupiah(input) {
        let value = input.value.replace(/[^0-9]/g, '');
        let formatted = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        input.value = formatted;
    }

    function validateNumber(input) {
        input.value = input.value.replace(/[^0-9]/g, ''); // Hanya angka
    }
</script>