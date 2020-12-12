@extends('layouts.front')

@section('title', 'Detail Pesanan')

@section('header')
    <section class="section-pagetop bg">
        <div class="container">
            <h2 class="title-page">Detail Pesanan #{{$order->id}}</h2>
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
                            <a href="{{route('user.orders')}}" class="btn btn-sm btn-primary"><i class="fa fa-arrow-left"></i></a>
                            <strong class="d-inline-block mr-3">Order ID: #{{$order->id}}</strong>
                            <span>Tanggal Pesanan: {{$order->created_at->format('d F Y')}} ({{$order->created_at->diffForHumans()}})</span>
                        </header>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="text-muted">Alamat Pengiriman</h6>
                                    @php $address = auth()->user()->addresses->first(); @endphp
                                    <p>{{$address->name}} <br>
                                        {{$address->address}}, {{$address->city->name}}, {{$address->province->name}} <br>
                                        Kode Pos: {{$address->zipcode}} <br> Nomor HP: {{$address->phone}}
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="text-muted">Penjual</h6>
                                    <p>{{$order->store->name}}</p>
                                        Dari: {{$order->store->city->name}}, {{$order->store->province->name}} <br>
                                        No HP: {{$order->store->phone}}
                                </div>
                                <div class="col-md-4">
                                    <h6 class="text-muted">Pembayaran</h6>
                                    <span class="text-success">
                                @php $payment = $order->invoice->payments->first(); @endphp
                                {{ucfirst($payment->method)}}: {{$payment->method === 'bank' ? strtoupper("{$payment->bank->bank_code} ({$payment->bank->account_number})") : strtoupper("{$payment->ewallet->wallet_type} ({$payment->ewallet->phone_number})")}}
                            </span>
                                    <p>Subtotal: @priceIDR($order->total) <br>
                                        PPN: @priceIDR($order->ppn) <br>
                                        Shipping: @priceIDR($order->shipping_cost) <br>
                                        <span class="b">Total:  @priceIDR($order->total + $order->ppn + $order->shipping_cost) </span>
                                    </p>
                                </div>
                            </div> <!-- row.// -->
                        </div> <!-- card-body .// -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                @foreach ($order->items as $item)
                                <tr>
                                    <td width="65">
                                        <img src="{{optional($item->product->images->first())->image_url}}" class="img-xs border">
                                    </td>
                                    <td>
                                        <p class="title mb-0">{{$item->product->name}}</p>
                                        <var class="price text-muted">@priceIDR($item->price * $item->quantity) | Qty: {{$item->quantity}} (satuan: @priceIDR($item->price))</var>
                                    </td>
                                    <td> Penjual <br> {{$item->product->store->name}} </td>
                                    @if ($order->status === \App\Models\Order::STATUS_ON_DELIVERY)
                                    <td width="125">Nomor Tracking: {{$order->shipping->tracking_code}} - dikirim oleh {{strtoupper($order->shipping->shipper)}} - {{$order->shipping->service}} </td>
                                    <td width="125">Perkiraan tiba: {{$order->shipping->etd}} hari </td>
                                    @endif
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div> <!-- table-responsive .end// -->
                    </article> <!-- order-group.// -->
                </main>
            </div>
        </div>
    </section>
@endsection
