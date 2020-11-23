@extends('layouts.front')

@section('title', 'My Orders')

@section('content')
    <section class="section-content padding-y-sm">
        <div class="container">
            <div class="row">
                @include('partials.front.sidebar')
                <main class="col-md-9">
                    <article class="card">
                        <header class="card-header">
                            <strong class="d-inline-block mr-3">Daftar Pesanan</strong>
                            <span></span>
                        </header>
                        <div class="table-responsive">
                            {{ $dataTable->table() }}
{{--                            <table class="table table-hover">--}}
{{--                                <thead>--}}
{{--                                    <tr>--}}
{{--                                        <th>#</th>--}}
{{--                                        <th>Items</th>--}}
{{--                                        <th>Total Amount</th>--}}
{{--                                        <th>Status</th>--}}
{{--                                        <th>Date</th>--}}
{{--                                        <th>Action</th>--}}
{{--                                    </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody>--}}
{{--                                @foreach ($orders as $order)--}}
{{--                                <tr>--}}
{{--                                    <td>{{$order->id}}</td>--}}
{{--                                    <td>{{$order->items->count()}}</td>--}}
{{--                                    <td>@priceIDR($order->total_amount)</td>--}}
{{--                                    <td>{{$order->status}}</td>--}}
{{--                                    <td>{{ $order->created_at }}</td>--}}
{{--                                    <td width="250">--}}
{{--                                        @if ($order->status == 'Shipped')--}}
{{--                                        <a href="#" class="btn btn-outline-primary">Track order</a>--}}
{{--                                        @endif--}}
{{--                                        <a href="#" class="btn btn-light"> Details </a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                                @endforeach--}}
{{--                                </tbody>--}}
{{--                            </table>--}}
                        </div> <!-- table-responsive .end// -->
                    </article> <!-- order-group.// -->
                </main>
            </div>
        </div>
    </section>
@endsection

@push('javascript')
    {{ $dataTable->scripts() }}
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
@endpush
