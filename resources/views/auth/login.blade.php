<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk | Souko-APP</title>
    @include('layouts.style')
    @livewireStyles
</head>

<body class="hold-transition login-page">
    @livewire(\App\Livewire\Auth\Index::class)

    <script src="{{ asset('adminlte3/plugins/jquery/jquery.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('adminlte3/dist/js/adminlte.min.js') }}" data-navigate-once></script>
    @livewireScripts
</body>

</html>