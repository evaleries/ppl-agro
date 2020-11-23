@extends('layouts.front')

@section('title', 'Home')

@section('content')

    <!-- ========================= SECTION INTRO ========================= -->
    <section class="section-intro padding-y-sm">
        <div class="container">

            <div class="intro-banner-wrap">
                <img src="{{ asset('images/banners/1.jpg') }}" class="img-fluid rounded">
            </div>

        </div> <!-- container //  -->
    </section>
    <!-- ========================= SECTION INTRO END// ========================= -->


    <!-- ========================= SECTION FEATURE ========================= -->
    <section class="section-content padding-y-sm">
        <div class="container">
            <article class="card card-body">
                <div class="row">
                    <div class="col-md-4">
                        <figure class="item-feature">
                            <span class="text-primary"><i class="fa fa-2x fa-truck"></i></span>
                            <figcaption class="pt-3">
                                <h5 class="title">Fast delivery</h5>
                                <p>Dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                    tempor incididunt ut labore </p>
                            </figcaption>
                        </figure> <!-- iconbox // -->
                    </div><!-- col // -->
                    <div class="col-md-4">
                        <figure  class="item-feature">
                            <span class="text-primary"><i class="fa fa-2x fa-landmark"></i></span>
                            <figcaption class="pt-3">
                                <h5 class="title">Creative Strategy</h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                </p>
                            </figcaption>
                        </figure> <!-- iconbox // -->
                    </div><!-- col // -->
                    <div class="col-md-4">
                        <figure  class="item-feature">
                            <span class="text-primary"><i class="fa fa-2x fa-lock"></i></span>
                            <figcaption class="pt-3">
                                <h5 class="title">High secured </h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                </p>
                            </figcaption>
                        </figure> <!-- iconbox // -->
                    </div> <!-- col // -->
                </div>
            </article>

        </div> <!-- container .//  -->
    </section>
    <!-- ========================= SECTION FEATURE END// ========================= -->


    <!-- ========================= SECTION CONTENT ========================= -->
    <section class="section-content">
        <div class="container">

            <header class="section-heading">
                <h3 class="section-title">Latest products</h3>
            </header><!-- sect-heading -->

            <div class="row">
                @foreach($latest_products as $product)
                <div class="col-md-3">
                    <div href="#" class="card card-product-grid">
                        <a href="#" class="img-wrap"> @if($product->images->isNotEmpty()) <img src="{{ $product->images->first()->path }}" loading="lazy"> @endif </a>
                        <figcaption class="info-wrap">
                            <a href="#" class="title">{{ $product->name }}</a>
                            @if ($product->ratings->isNotEmpty())
                            <div class="rating-wrap">
                                <ul class="rating-stars">
                                    <li class="stars-active">
                                        {!! str_repeat('<i class="fa fa-star"></i>', $product->rating_avg) !!}
                                    </li>
                                    <li>
                                        {!! str_repeat('<i class="fa fa-star"></i>', $product->rating_avg) !!}
                                    </li>
                                </ul>
                                <span class="label-rating text-muted"> {{ $product->ratings->count() }} reviews</span>
                            </div>
                            @endif
                            <div class="price mt-1">@priceIDR($product->price)</div> <!-- price-wrap.// -->
                        </figcaption>
                    </div>
                </div> <!-- col.// -->
                @endforeach
            </div> <!-- row.// -->

        </div> <!-- container .//  -->
    </section>
    <!-- ========================= SECTION CONTENT END// ========================= -->
@endsection
