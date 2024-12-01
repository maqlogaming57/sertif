@extends('adminlte::page')

@section('title', 'Input Sertif')

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
