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

  {{-- FILTER: kategori, price, level (ambil dari DB) --}}
  <form action="{{ route('katalog.index') }}" method="GET" class="katalog-toolbar" id="filterForm">
    <div class="toolbar-row">
      <div class="form-field">
        <label class="label">Kategori</label>
        <select name="category" class="select" onchange="this.form.submit()">
          <option value="">Semua</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>{{ $cat->category }}</option>
          @endforeach
        </select>
      </div>

      <div class="form-field">
        <label class="label">Harga</label>
        <select name="price" class="select" onchange="this.form.submit()">
          <option value="">Semua</option>
          <option value="free" @selected(request('price')==='free')>Gratis</option>
          @foreach($priceRanges as $pr)
            <option value="{{ $pr->id }}" @selected(request('price') == $pr->id)">
              ${{ $pr->min_price }} - ${{ $pr->max_price }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="form-field">
        <label class="label">Level</label>
        <select name="level" class="select" onchange="this.form.submit()">
          <option value="">Semua</option>
          @foreach($levels as $lv)
            <option value="{{ $lv->id }}" @selected(request('level') == $lv->id)>{{ $lv->level }}</option>
          @endforeach
        </select>
      </div>

      @if(request('category') || request('price') || request('level'))
        <a href="{{ route('katalog.index') }}" class="btn-reset">Reset</a>
      @endif
    </div>
  </form>

  {{-- GRID KURSUS --}}
  @if($courses->count())
    <div class="katalog-grid">
      @foreach ($courses as $course)
        @php
          $rating = round($course->reviews_avg_rating ?? 0, 1);
          $priceLabel = ($course->price ?? 0) == 0
              ? 'Free'
              : '$'.number_format($course->price, 2);
          // tujuan redirect setelah login: ke detail course milik student area
          $afterLogin = route('detail.index', $course->slug);
          $loginUrl   = route('login') . '?redirect=' . urlencode($afterLogin);
        @endphp

        <article class="katalog-card">
          <div class="katalog-media">
            <img src="{{ asset('storage/' . $course->img) }}" alt="{{ $course->name }}">
            @if(($course->price ?? 0) == 0)
              <span class="katalog-badge">Gratis</span>
            @endif
          </div>

          <div class="katalog-body">
            <h3 class="katalog-name">{{ $course->name }}</h3>

            <div class="katalog-meta">
              <span class="meta-item"><span class="meta-ico">⏱️</span><span>{{ $course->formatted_duration ?? '—' }}</span></span>
              <span class="meta-dot">•</span>
              <span class="meta-item"><span class="meta-ico">📘</span><span>{{ $course->lessons_count ?? 0 }} Modul</span></span>
              <span class="meta-dot">•</span>
              <span class="meta-item"><span class="meta-ico">👥</span><span>{{ $course->students_count ?? 0 }}</span></span>
            </div>

            {{-- Bintang rating --}}
            <div class="stars" aria-label="Rating {{ number_format($rating,1) }} dari 5">
              @for($i=1;$i<=5;$i++)
                @php $full = $i <= floor($rating); @endphp
                <span class="star {{ $full ? 'is-full' : '' }}">{{ $full ? '★' : '☆' }}</span>
              @endfor
              <span class="stars-num">{{ number_format($rating,1) }}</span>
            </div>

            <p class="katalog-desc">
              {{ Str::limit($course->short_description ?? $course->description ?? '-', 120) }}
            </p>

            <div class="katalog-row">
              <span class="katalog-level">{{ $course->level->level ?? 'All Levels' }}</span>
              <span class="katalog-price {{ $priceLabel === 'Free' ? 'is-free' : '' }}">
                {{ $priceLabel }}
              </span>
            </div>

            <div class="katalog-actions">
              {{-- Katalog khusus guest: semua tombol menuju login dengan redirect ke detail --}}
              <a href="{{ $loginUrl }}" class="btn-join">Bergabung</a>
              <a href="{{ $loginUrl }}" class="btn-outline">Detail</a>
            </div>
          </div>
        </article>
      @endforeach
    </div>

    {{-- Pagination (pakai simplePaginate/paginate di controller) --}}
    <div class="pagination">
      {{ $courses->appends(request()->query())->links() }}
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
