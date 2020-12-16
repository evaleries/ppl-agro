@extends('layouts.front')

@section('title', $event->community->name)

@section('header')
    <section class="section-pagetop bg">
        <div class="container">
            <div class="row">
                <div class="col-10">
                    <h2 class="title-page">{{$event->community->name}}</h2>
                    <p>{{Str::limit(strip_tags($event->community->description), 150)}}</p>
                </div>
                <div class="col-2">
                    <img src="{{$event->community->logo_url}}" class="img-fluid rounded-circle" style="max-height: 150px" loading="lazy" alt="">
                </div>
            </div>
        </div> <!-- container //  -->
    </section>
@endsection

@section('content')
    <section class="section-content my-5">
        <div class="container">
            <div class="row">
                <main class="col-lg-12">
                    <div class="event-banner mt-2 mb-3">
                        <img src="{{$event->banner_url}}" class="img-fluid d-block mx-auto" alt="{{$event->name}}">
                    </div>
                    <hr>
                    <div class="d-block">
                        {!! $event->description !!}
                    </div>

                    <div class="d-block mt-5 mb-0">
                        @if($event->can_join)
                            <button class="btn btn-md btn-success">Daftar Event</button>
                            <br>
                            <small class="text-muted">Dengan mendaftar event, Anda otomatis akan tergabung ke dalam komunitas <strong>{{$event->community->name}}</strong></small>
                        @endif

                    </div>
                </main>
            </div>
        </div>
    </section>
@endsection
