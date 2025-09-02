@extends('layouts.guest')

@push('styles')
<link rel="stylesheet" href="{{ asset('guest/katalog.css') }}">
@endpush

@section('content')
<section class="katalog-section">

  {{-- HEADER --}}
  <header class="katalog-head">
    <h1 class="katalog-title">Katalog Kursus</h1>
    <p class="katalog-subtitle">Pilih kursus favoritmu dan mulai belajar sekarang</p>
  </header>

  {{-- FILTER: kategori, price, level --}}
  <form action="{{ route('katalog.index') }}" method="GET" class="katalog-toolbar" id="filterForm">
    <div class="toolbar-row">
      <div class="form-field">
        <label class="label">Kategori</label>
        <select name="category" class="select" onchange="this.form.submit()">
          <option value="">Semua</option>
          <option value="frontend" @selected(request('category')==='frontend')>Frontend</option>
          <option value="web" @selected(request('category')==='web')>Web</option>
          <option value="aplikasi" @selected(request('category')==='aplikasi')>Aplikasi</option>
        </select>
      </div>

      <div class="form-field">
        <label class="label">Harga</label>
        <select name="price" class="select" onchange="this.form.submit()">
          <option value="">Semua</option>
          <option value="free" @selected(request('price')==='free')>Gratis</option>
          <option value="paid" @selected(request('price')==='paid')>Berbayar</option>
        </select>
      </div>

      <div class="form-field">
        <label class="label">Level</label>
        <select name="level" class="select" onchange="this.form.submit()">
          <option value="">Semua</option>
          <option value="beginner" @selected(request('level')==='beginner')>Beginner</option>
          <option value="intermediate" @selected(request('level')==='intermediate')>Intermediate</option>
          <option value="advanced" @selected(request('level')==='advanced')>Advanced</option>
        </select>
      </div>

      @if(request('category') || request('price') || request('level'))
        <a href="{{ route('katalog.index') }}" class="btn-reset">Reset</a>
      @endif
    </div>
  </form>

  {{-- GRID KURSUS --}}
  @if(collect($courses)->count())
    <div class="katalog-grid">
      @foreach ($courses as $course)
        @php $rating = (float)($course['rating'] ?? 0); @endphp
        <article class="katalog-card">
          <div class="katalog-media">
            <img src="{{ $course['img'] }}" alt="{{ $course['title'] }}">
            @if(!empty($course['badge']))
              <span class="katalog-badge">{{ $course['badge'] }}</span>
            @endif
          </div>

          <div class="katalog-body">
            <h3 class="katalog-name">{{ $course['title'] }}</h3>

            <div class="katalog-meta">
              <span class="meta-item"><span class="meta-ico">⏱️</span><span>{{ $course['duration'] ?? '—' }}</span></span>
              <span class="meta-dot">•</span>
              <span class="meta-item"><span class="meta-ico">📘</span><span>{{ $course['modules'] ?? '—' }} Modul</span></span>
              <span class="meta-dot">•</span>
              <span class="meta-item"><span class="meta-ico">👥</span><span>{{ $course['students'] ?? 0 }}</span></span>
            </div>

            {{-- Bintang rating --}}
            <div class="stars" aria-label="Rating {{ number_format($rating,1) }} dari 5">
              @for($i=1;$i<=5;$i++)
                @php $full = $i <= floor($rating); @endphp
                <span class="star {{ $full ? 'is-full' : '' }}">{{ $full ? '★' : '☆' }}</span>
              @endfor
              <span class="stars-num">{{ number_format($rating,1) }}</span>
            </div>

            <p class="katalog-desc">{{ $course['desc'] }}</p>

            <div class="katalog-row">
              <span class="katalog-level">{{ $course['level'] ?? 'All Levels' }}</span>
              <span class="katalog-price {{ ($course['price'] ?? 'Free') === 'Free' ? 'is-free' : '' }}">
                {{ $course['price'] ?? 'Free' }}
              </span>
            </div>

            <div class="katalog-actions">
              <a href="#" class="btn-join">Bergabung</a>
              <a href="#" class="btn-outline"> Detail</a>
            </div>
          </div>
        </article>
      @endforeach
    </div>
  @else
    <div class="empty">
      <div class="empty-box">
        <div class="empty-ico">🔎</div>
        <p>Tidak ada kursus ditemukan sesuai filter.</p>
      </div>
    </div>
  @endif
</section>
@endsection
