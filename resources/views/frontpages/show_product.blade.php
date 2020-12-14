@extends('layouts.front')

@section('title', $product->name)

@section('content')
    <section class="section-content padding-y-sm">
        <div class="container">
            <div class="row border border-light py-3 rounded">
                <aside class="col-sm-6 border-right">
                    @if ($product->images->isNotEmpty())
                        <article class="gallery-wrap">
                            <div class="img-big-wrap">
                                <a href="#"><img id="mainImage" class="rounded mx-auto d-block" src="{{$product->images->first()->image_url}}"></a>
                            </div> <!-- img-big-wrap.// -->
                            <div class="thumbs-wrap">
                                @foreach ($product->images->skip(1) as $image)
                                    <a class="item-thumb"> <img loading="lazy" class="img-child" src="{{ $image->image_url }}" alt="{{$product->name}}'s image"></a>
                                @endforeach
                            </div> <!-- thumbs-wrap.// -->
                        </article> <!-- gallery-wrap .end// -->
                    @endif
                </aside>
                <main class="col-sm-6">
                    <article class="content-body">
                        <h3 class="title">{{ $product->name }}</h3>
                        <div class="rating-wrap mb-3">
                            <span class="badge badge-warning"> <i class="fa fa-star"></i> {{$product->rating_avg}}</span>
                            <small class="text-muted ml-2">{{$product->ratings->count()}} reviews</small>
                        </div>
                        {!! $product->description !!}

                        <ul class="list-check my-4">
                            <li><strong>Stock</strong>: {{$product->stock}} items</li>
                            <li><strong>Toko</strong>: {{$product->store->name}}</li>
                            <li><strong>Komunitas</strong>: {{$product->store->community->name}}</li>
                            <li><strong>Berat</strong>: {{$product->weight}} {{$product->weight_unit}}</li>
                            @if (is_array($product->extra_info))
                            @foreach($product->extra_info as $info => $val)
                                @if (empty($info) && empty($val)) @continue @endif
                                <li>{{$info}}: {{$val}}</li>
                            @endforeach
                            @endif
                        </ul>

                        <div class="row">
                            <span class="price h4">@priceIDR($product->price)</span>
                        </div> <!-- col.// -->

                        <div class="row mt-3 align-items-center">
                            <div class="form-group col-md flex-grow-0">
                                <label>Quantity</label>
                                <div class="input-group mb-3 input-spinner">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-light btn-increase-quantity" type="button" id="button-plus"> + </button>
                                    </div>
                                    <input type="text" class="form-control p-0" id="quantity" max="{{$product->stock}}" min="1" value="1">
                                    <div class="input-group-append">
                                        <button class="btn btn-light btn-decrease-quantity" type="button" id="button-minus"> &minus; </button>
                                    </div>
                                </div>
                            </div> <!-- col.// -->
                            <div class="col text-right">
                                @if($product->stock > 1)
                                    <button class="btn btn-primary" id="btnAddToCart"> <span class="text">Tambah ke Keranjang Belanja</span> <i class="icon fas fa-shopping-cart"></i> </button>
                                @else
                                    <button class="btn btn-info"> <span class="text">Stok Produk Habis</span> <i class="icon fas fa-shopping-cart"></i> </button>
                                @endif
                            </div> <!-- col.// -->
                        </div> <!-- row.// -->

                    </article> <!-- product-info-aside .// -->
                </main> <!-- col.// -->
            </div> <!-- row.// -->
            @if($product->ratings->isNotEmpty())
            <div class="row">
                <div class="col-md-12">
                    <header class="section-heading">
                        <h3>Reviews</h3>
                        <div class="rating-wrap">
                            <ul class="rating-stars stars-lg">
                                <li style="width:{{20 * $product->rating_avg}}%" class="stars-active">
                                    <img src="{{asset('images/icons/stars-active.svg')}}" alt="">
                                </li>
                                <li>
                                    <img src="{{ asset('images/icons/starts-disable.svg')}}" alt="">
                                </li>
                            </ul>
                            <strong class="label-rating text-lg"> {{$product->rating_avg}} <span class="text-muted">| {{$product->ratings->count()}} reviews</span></strong>
                        </div>
                    </header>

                    @foreach ($product->ratings->sortByDesc('created_at') as $rating)
                    <article class="box mb-3">
                        <div class="icontext w-100">
                            <img src="{{ asset('images/avatars/avatar1.jpg') }}" class="img-xs icon rounded-circle">
                            <div class="text">
                                <span class="date text-muted float-md-right">{{ $rating->created_at }} </span>
                                <h6 class="mb-1">{{$rating->user->full_name}} </h6>
                                <ul class="rating-stars">
                                    <li style="width:{{ 20 * $rating->rate }}%" class="stars-active">
                                        <img src="{{asset('images/icons/stars-active.svg')}}" alt="">
                                    </li>
                                    <li>
                                        <img src="{{ asset('images/icons/starts-disable.svg')}}" alt="">
                                    </li>
                                </ul>
                                <span class="label-rating {{ $rating->rate >= 3 ? 'text-warning' : 'text-danger' }}">{{ $rating->rate >= 3 ? 'Good' : 'Bad' }}</span>
                            </div>
                        </div> <!-- icontext.// -->
                        <div class="mt-3">
                            <p>
                                {{$rating->comment}}
                            </p>
                        </div>
                    </article>
                    @endforeach

                </div> <!-- col.// -->
            </div> <!-- row.// -->
            @endif
        </div>
    </section>
    <form action="{{route('cart.add_item', $product->slug)}}" method="POST" class="d-none" id="formAddToCart">
        @csrf
        <input type="number" class="d-none" name="quantity" value="1">
    </form>
@endsection


@push('stylesheet')
    <style>
        #mainImage {
            -webkit-transition: all .4s ease-in-out;
            -moz-transition: all .4s ease-in-out;
            -o-transition: all .4s ease-in-out;
            -ms-transition: all .4s ease-in-out;
        }

        .img-transition {
            -webkit-transform: scale(1.6);
            -moz-transform: scale(1.6);
            -o-transform: scale(1.6);
            transform: scale(1.6);
        }
    </style>
@endpush

@push('javascript')
    <script>
        $(function() {
            let mainImgSrc = $('#mainImage').attr('src');
            let maxQty = parseInt($('#quantity').attr('max'))
            let minQty = parseInt($('#quantity').attr('min'))

            $('button.btn-increase-quantity').on('click', function () {
                let currentVal = parseInt($('#quantity').val());
                if (currentVal + 1 > maxQty) {
                    return $('button.btn-increase-quantity').attr('disabled', true)
                }
                $('button.btn-decrease-quantity').attr('disabled', false)
                $('#quantity').val(currentVal + 1)
            });

            $('button.btn-decrease-quantity').on('click', function () {
                let currentVal = parseInt($('#quantity').val());
                if (currentVal - 1 < minQty) {
                    return $('button.btn-decrease-quantity').attr('disabled', true)
                }
                $('button.btn-increase-quantity').attr('disabled', false)
                $('#quantity').val(currentVal - 1)
            });

            $('#quantity').on('change', function (e) {
                let currentVal = parseInt($('#quantity').val());
                if (currentVal < minQty) {
                    $('#quantity').val(minQty);
                }

                if (currentVal > maxQty) {
                    $('#quantity').val(maxQty)
                }
            });

            $('img.img-child').on('click', function () {
                let currentSrc = $(this).attr('src')
                $('#mainImage').attr('src', $(this).attr('src'))
                $(this).attr('src', mainImgSrc);
                mainImgSrc = currentSrc;
            });

            $('#mainImage').hover(function() {
               $(this).toggleClass('img-transition');
            }, function() {
                $(this).toggleClass('img-transition');
            });

            $('#btnAddToCart').on('click', function () {
                $('input[name=quantity]').val($('#quantity').val());
                $('#formAddToCart').submit();
            });
        })
    </script>
@endpush

