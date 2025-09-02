@extends('layouts.guest')

@push('styles')
<link rel="stylesheet" href="{{ asset('guest/testimoni.css') }}">
@endpush

@section('content')
<section class="testimoni-section">
    <div class="testimoni-header">
        <h1 class="testimoni-title">Apa Kata Mereka</h1>
        <p class="testimoni-subtitle">
            Ulasan jujur dari member yang telah mengikuti kursus dan belajar bersama kami.
        </p>
    </div>

    <div class="testimoni-grid">
        @foreach ($testimonials as $t)
        <div class="testimoni-card">
            <div class="testimoni-profile">
                <img src="{{ $t['img'] }}" alt="{{ $t['name'] }}">
                <div class="testimoni-user">
                    <h3>{{ $t['name'] }}</h3>
                    <span class="testimoni-role">{{ $t['role'] }}</span>
                </div>
            </div>
            <div class="testimoni-text">
                <p>"{{ $t['text'] }}"</p>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection
