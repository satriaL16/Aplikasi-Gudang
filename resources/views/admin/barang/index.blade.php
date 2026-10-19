@extends('layouts.app')

@section('title', 'Data Barang')

@section('content')
    @livewire(\App\Livewire\Admin\Barang\Index::class)
@endsection
