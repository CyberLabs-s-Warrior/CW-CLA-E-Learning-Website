@extends('layouts.guest')

@push('styles')
<link rel="stylesheet" href="{{ asset('guest/instruktur.css') }}">
@endpush

@section('content')
<section class="instruktur-section">
    <div class="instruktur-header">
        <h1 class="instruktur-title">Instruktur Kami</h1>
        <p class="instruktur-subtitle">
            Kenalan dengan para mentor hebat yang siap membimbingmu mencapai level profesional.
        </p>
    </div>

    <div class="instruktur-grid">
        @foreach ($instructors as $i)
        <div class="instruktur-card">
            <div class="instruktur-img-wrapper">
                <img src="{{ $i['img'] }}" alt="{{ $i['name'] }}">
            </div>
            <div class="instruktur-info">
                <h3 class="instruktur-name">{{ $i['name'] }}</h3>
                <p class="instruktur-skill">{{ $i['skill'] }}</p>
                <p class="instruktur-desc">
                    Mentor berpengalaman dengan passion mengajar dan membimbingmu memahami teknologi.
                </p>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection
