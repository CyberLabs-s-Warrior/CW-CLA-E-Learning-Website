{{-- resources/views/forum/category.blade.php --}}
@extends('layouts.guest')
@section('title','Forum - '.$category->name)

@php
  use Illuminate\Support\Str;
@endphp

@push('styles')
  {{-- cache-busting agar update CSS langsung terbaca --}}
  <link rel="stylesheet" href="{{ asset('guest/forum-category.css') }}?v={{ filemtime(public_path('guest/forum-category.css')) }}">
@endpush

@section('content')

{{-- ===== HERO KATEGORI ===== --}}
<section class="fc-hero" aria-labelledby="fcHeroTitle">
  <div class="fc-hero__bg" aria-hidden="true"></div>
  <div class="fc-hero__container">
    <div class="fc-hero__left">
      <a href="{{ route('forum.index') }}" class="fc-crumb" aria-label="Kembali ke beranda forum">
        <i class="fa-solid fa-angle-left"></i> Forum
      </a>

      <div class="fc-hero__title-wrap">
        <div class="fc-hero__avatar" aria-hidden="true">{{ Str::substr($category->name,0,1) }}</div>
        <h1 id="fcHeroTitle" class="fc-hero__title">{{ $category->name }}</h1>
      </div>

      @if($category->description)
        <p class="fc-hero__desc">{{ $category->description }}</p>
      @endif
    </div>

    <div class="fc-hero__right">
      @auth
        <a href="{{ route('forum.thread.create') }}" class="btn-cta btn-cta--primary">
          <i class="fa-solid fa-pen-to-square"></i> Buat Topik
        </a>
      @else
        <a href="{{ route('login') }}" class="btn-cta btn-cta--ghost">
          <i class="fa-solid fa-right-to-bracket"></i> Masuk untuk Buat Topik
        </a>
      @endauth
    </div>
  </div>
</section>

<section class="fc-wrap">
  <div class="fc-container">

    {{-- ===== DAFTAR THREAD ===== --}}
    @if($threads->count())
      <div class="fc-threads">
        @foreach($threads as $t)
          <a class="fc-thread reveal-up"
             href="{{ route('forum.thread.show',['id'=>$t->id,'slug'=>Str::slug($t->title)]) }}"
             aria-label="Buka topik: {{ $t->title }}">
            <div class="fc-thread__row">
              <div class="fc-thread__left">

                {{-- Thumbnail jika ada gambar; jika tidak, avatar huruf --}}
                @if(!empty($t->image_url))
                  <img class="thread-thumb"
                       src="{{ $t->image_url }}"
                       alt="Gambar topik: {{ $t->title }}"
                       loading="lazy">
                @else
                  <div class="avatar" aria-hidden="true">
                    {{ isset($t->user->name) ? Str::upper(Str::substr($t->user->name,0,1)) : 'U' }}
                  </div>
                @endif

              </div>

              <div class="fc-thread__main">
                <div class="fc-thread__line">
                  <div class="badges">
                    @if($t->pinned_at)
                      <span class="chip chip--pinned"><i class="fa-solid fa-thumbtack"></i> Pinned</span>
                    @endif
                    @if($t->is_locked)
                      <span class="chip chip--locked"><i class="fa-solid fa-lock"></i> Locked</span>
                    @endif
                  </div>
                  <div class="fc-thread__title">{{ $t->title }}</div>
                </div>
                <div class="fc-thread__meta">
                  <span class="meta-item"><i class="fa-regular fa-user"></i> {{ $t->user->name ?? 'Pengguna' }}</span>
                  <span class="meta-dot" aria-hidden="true">•</span>
                  <time class="meta-item" title="{{ $t->updated_at->format('d M Y H:i') }}">
                    <i class="fa-regular fa-clock"></i> {{ $t->updated_at->diffForHumans() }}
                  </time>
                </div>
              </div>

              <div class="fc-thread__right">
                <span class="chev" aria-hidden="true"><i class="fa-solid fa-chevron-right"></i></span>
              </div>
            </div>
          </a>
        @endforeach
      </div>

      {{-- Pagination Laravel --}}
      <div class="fc-pagination">
        {{ $threads->links() }}
      </div>
    @else
      <div class="fc-empty reveal-up" role="status">
        <div class="empty-illus" aria-hidden="true">📂</div>
        <div class="empty-text">Belum ada topik di kategori ini.</div>
        @auth
          <a href="{{ route('forum.thread.create') }}" class="btn-cta btn-cta--mini btn-cta--primary mt-8">
            Mulai Diskusi
          </a>
        @endauth
      </div>
    @endif

  </div>
</section>
@endsection
