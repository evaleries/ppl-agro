@extends('layouts.app')

@section('title', 'Seller Dashboard')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Seller Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Pesanan</h4>
                        </div>
                        <div class="card-body">
                            {{ $total_orders }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Produk</h4>
                        </div>
                        <div class="card-body">
                            {{ $total_products }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-calendar-week"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Acara Komunitas</h4>
                        </div>
                        <div class="card-body">
                            {{ $total_events }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Member Komunitas</h4>
                        </div>
                        <div class="card-body">
                            {{ $total_members }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($community->is_active === 0)
        <div class="row">
            <div class="col-12 mb-4">
                <div class="hero bg-primary text-white">
                    <div class="hero-inner">
                        <h2>Selamat Datang, {{auth()->user()->first_name}}!</h2>
                        <p class="lead">Anda telah menjadi seller di {{config('app.name')}}. Anda dapat mulai dengan menambahkan informasi untuk komunitas dan toko Anda.</p>
                        <div class="mt-4">
                            <a href="{{route('seller.community.index')}}" class="btn btn-outline-white btn-lg btn-icon icon-left"><i class="fas fa-edit"></i> Ubah Komunitas</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </section>
@endsection
