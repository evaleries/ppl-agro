@extends('layouts.front')

@section('title', 'Detail Orders')

@section('header')
    <section class="section-pagetop bg">
        <div class="container">
            <h2 class="title-page">Order #{{$order->id}}</h2>
        </div> <!-- container //  -->
    </section>
@endsection

@section('content')
    <section class="section-content padding-y-lg">
        <div class="container">
            <div class="row">
                @include('partials.front.sidebar')
                <main class="col-md-9">
                    <article class="card">
                        <header class="card-header">
                            <strong class="d-inline-block mr-3">Order ID: {{$order->id}}</strong>
                            <span>Order Date: {{$order->created_at->format('d F Y')}}</span>
                        </header>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h6 class="text-muted">Delivery to</h6>
                                    <p>Michael Jackson <br>
                                        Phone +1234567890 Email: myname@pixsellz.com <br>
                                        Location: Home number, Building name, Street 123,  Tashkent, UZB <br>
                                        P.O. Box: 100123
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="text-muted">Payment</h6>
                                    <span class="text-success">
                                <i class="fab fa-lg fa-cc-visa"></i>
                                Visa  **** 4216
                            </span>
                                    <p>Subtotal: $356 <br>
                                        Shipping fee:  $56 <br>
                                        <span class="b">Total:  $456 </span>
                                    </p>
                                </div>
                            </div> <!-- row.// -->
                        </div> <!-- card-body .// -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody><tr>
                                    <td width="65">
                                        <img src="../images/items/1.jpg" class="img-xs border">
                                    </td>
                                    <td>
                                        <p class="title mb-0">Product name goes here </p>
                                        <var class="price text-muted">USD 145</var>
                                    </td>
                                    <td> Seller <br> Nike clothing </td>
                                    <td width="250"> <a href="#" class="btn btn-outline-primary">Track order</a> <a href="#" class="btn btn-light"> Details </a> </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="../images/items/2.jpg" class="img-xs border">
                                    </td>
                                    <td>
                                        <p class="title mb-0">Another name goes here </p>
                                        <var class="price text-muted">USD 15</var>
                                    </td>
                                    <td> Seller <br> ABC shop </td>
                                    <td> <a href="#" class="btn btn-outline-primary">Track order</a> <a href="#" class="btn btn-light"> Details </a> </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="../images/items/3.jpg" class="img-xs border">
                                    </td>
                                    <td>
                                        <p class="title mb-0">The name of the product  goes here </p>
                                        <var class="price text-muted">USD 145</var>
                                    </td>
                                    <td> Seller <br> Wallmart </td>
                                    <td> <a href="#" class="btn btn-outline-primary">Track order</a> <a href="#" class="btn btn-light"> Details </a> </td>
                                </tr>
                                </tbody></table>
                        </div> <!-- table-responsive .end// -->
                    </article> <!-- order-group.// -->
                </main>
            </div>
        </div>
    </section>
@endsection
