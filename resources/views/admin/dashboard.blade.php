@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1>Dashboard Admin</h1>
            </div>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3 data-stat="barang">{{ $totalBarang }}</h3>
                            <p>Total Data Barang</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <a href="{{ route('admin.barang.index') }}" wire:navigate class="small-box-footer">
                            Kelola Barang <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
