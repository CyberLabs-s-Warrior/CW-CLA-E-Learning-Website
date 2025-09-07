{{-- resources/views/guest/instruktur/index.blade.php --}}
@extends('layouts.guest')

@push('styles')
<link rel="stylesheet" href="{{ asset('guest/instruktur.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" />
@endpush

@section('content')
<section class="instruktur-section">
  <div class="instruktur-header">
    <h1 class="instruktur-title">Instruktur Kami</h1>
    <p class="instruktur-subtitle">Kenalan dengan para mentor hebat yang siap membimbingmu.</p>
  </div>

  @if($profiles->isNotEmpty())
    <div id="instructorCarousel" class="splide instructor-splide" aria-label="Daftar Instruktur">
      <div class="splide__track">
        <ul class="splide__list">
          @foreach ($profiles as $p)
            @php
              $name = $p->user->name ?? 'Instruktur';
              $img  = $p->avatar_path
                        ? asset('storage/'.$p->avatar_path)
                        : 'https://ui-avatars.com/api/?name='.urlencode($name).'&background=EAF2FF&color=0D6EFD&bold=true';
            @endphp

            <li class="splide__slide">
              <div class="instruktur-card">
                <div class="instruktur-img-wrapper">
                  <img src="{{ $img }}" alt="{{ $name }}" loading="lazy">
                </div>

                <div class="instruktur-info">
                  <h3 class="instruktur-name">{{ $name }}</h3>
                  <p class="instruktur-skill">{{ $p->primary_skill }}</p>

                  {{-- Tampilkan deskripsi dengan baris baru, aman dari XSS --}}
                  <p class="instruktur-desc">{!! nl2br(e($p->short_bio)) !!}</p>

                  @if($p->github_url || $p->linkedin_url)
                    <div class="instruktur-social">
                      @if($p->github_url)
                        <a class="social-btn" href="{{ $p->github_url }}" target="_blank" rel="noopener noreferrer" aria-label="GitHub {{ $name }}">
                          <i class="fa-brands fa-github"></i>
                        </a>
                      @endif
                      @if($p->linkedin_url)
                        <a class="social-btn" href="{{ $p->linkedin_url }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn {{ $name }}">
                          <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                      @endif
                    </div>
                  @endif
                </div>
              </div>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  @else
    <div class="empty" style="max-width:720px;margin:0 auto;">
      <div class="empty-box">
        <div class="empty-ico">👋</div>
        Belum ada instruktur yang ditampilkan.
      </div>
    </div>
  @endif
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    new Splide('#instructorCarousel', {
      type: 'loop',
      rewind: true,
      perPage: 3,            // << 3 card per layar (desktop)
      perMove: 1,
      gap: '16px',
      arrows: true,
      pagination: false,
      speed: 650,
      drag: true,
      autoplay: true,        // auto-geser
      interval: 3500,        // tiap 3.5 detik
      pauseOnHover: true,    // berhenti saat hover
      pauseOnFocus: false,
      easing: 'cubic-bezier(.4,0,.2,1)',
      breakpoints: {
        1100: { perPage: 2, gap: '14px' },
        680:  { perPage: 1, gap: '12px' },
      },
      classes: {
        arrows: 'splide__arrows instruktur-arrows',
        pagination: 'splide__pagination instruktur-pagination',
      },
    }).mount();
  });
</script>
@endpush
