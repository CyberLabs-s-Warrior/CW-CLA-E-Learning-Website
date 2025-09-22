{{-- resources/views/forum/index.blade.php --}}
@extends('layouts.guest')
@section('title','Forum')

@php
  use Illuminate\Support\Str;
@endphp

@push('styles')
  {{-- cache-busting agar perubahan CSS langsung terbaca --}}
  <link rel="stylesheet" href="{{ asset('guest/forum.css') }}?v={{ filemtime(public_path('guest/forum.css')) }}">
@endpush

@section('content')
<section class="forum-hero" aria-labelledby="forumHeroTitle">
  <div class="forum-hero__bg" aria-hidden="true"></div>
  <div class="forum-hero__container">
    <div class="forum-hero__text">
      <h1 id="forumHeroTitle" class="forum-hero__title">Forum Diskusi</h1>
      <p class="forum-hero__subtitle">
        Tanya, berbagi, dan bantu sesama. Topik terstruktur, pengalaman mulus.
      </p>
    </div>
    <div class="forum-hero__cta">
      @auth
        <a href="{{ route('forum.thread.create') }}" class="btn-cta btn-cta--primary" aria-label="Buat topik baru">
          <i class="fa-solid fa-pen-to-square"></i> Buat Topik
        </a>
      @else
        <a href="{{ route('login') }}" class="btn-cta btn-cta--ghost" aria-label="Masuk untuk membuat topik">
          <i class="fa-solid fa-right-to-bracket"></i> Masuk untuk Buat Topik
        </a>
      @endauth
    </div>
  </div>
  <div class="forum-hero__wave" aria-hidden="true"></div>
</section>

<section class="forum-wrap">
  <div class="forum-container">

    {{-- Kategori --}}
    <div class="section-head">
      <h2 class="section-title">Kategori</h2>
      <div class="section-actions">
        {{-- (opsional) tempat tombol/filter kecil ke depan --}}
      </div>
    </div>

    <div class="cat-grid" role="list">
      @foreach($categories as $cat)
        <a class="cat-card reveal-up" role="listitem"
           href="{{ route('forum.category', $cat->slug) }}"
           aria-label="Kategori {{ $cat->name }}">
          <div class="cat-card__head">
            <span class="cat-avatar" aria-hidden="true">{{ Str::substr($cat->name,0,1) }}</span>
            <h3 class="cat-title">{{ $cat->name }}</h3>
          </div>
          @if(!empty($cat->description))
            <p class="cat-desc">{{ $cat->description }}</p>
          @else
            <p class="cat-desc cat-desc--muted">Tidak ada deskripsi.</p>
          @endif
          {{-- Jika kamu nanti menambahkan eager load count: withCount('threads') --}}
          @if(isset($cat->threads_count))
            <div class="cat-meta">
              <span class="meta-chip"><i class="fa-regular fa-message"></i> {{ number_format($cat->threads_count) }} topik</span>
            </div>
          @endif
        </a>
      @endforeach
    </div>

    <hr class="forum-divider" aria-hidden="true"/>

    {{-- Topik Terbaru --}}
    <div class="section-head">
      <h2 class="section-title">Topik Terbaru</h2>
    </div>

    @forelse($threads as $t)
      <a class="thread-item reveal-up"
         href="{{ route('forum.thread.show', ['id'=>$t->id, 'slug'=>Str::slug($t->title)]) }}"
         aria-label="Buka topik: {{ $t->title }}">
        <div class="thread-row">
          <div class="thread-left">

            {{-- === Thumbnail jika ada gambar; kalau tidak, pakai avatar huruf === --}}
            @if(!empty($t->image_url))
              <img class="thread-thumb" src="{{ $t->image_url }}"
                   alt="Gambar topik: {{ $t->title }}" loading="lazy">
            @else
              <div class="avatar" aria-hidden="true">
                {{ isset($t->user->name) ? Str::upper(Str::substr($t->user->name,0,1)) : 'U' }}
              </div>
            @endif

          </div>

          <div class="thread-main">
            <div class="thread-line">
              <div class="thread-badges">
                @if($t->pinned_at)
                  <span class="chip chip--pinned" aria-label="Topik dipasang">
                    <i class="fa-solid fa-thumbtack"></i> Pinned
                  </span>
                @endif
                @if($t->is_locked)
                  <span class="chip chip--locked" aria-label="Topik dikunci">
                    <i class="fa-solid fa-lock"></i> Locked
                  </span>
                @endif
              </div>
              <div class="thread-title">{{ $t->title }}</div>
            </div>
            <div class="thread-meta">
              <span class="meta-item">
                <i class="fa-regular fa-folder-open"></i> {{ $t->category->name ?? 'Umum' }}
              </span>
              <span class="meta-dot" aria-hidden="true">•</span>
              <span class="meta-item">
                <i class="fa-regular fa-user"></i> {{ $t->user->name ?? 'Pengguna' }}
              </span>
            </div>
          </div>

          <div class="thread-right">
            <time class="thread-time" title="{{ $t->updated_at->format('d M Y H:i') }}">
              {{ $t->updated_at->diffForHumans() }}
            </time>
            <span class="thread-arrow" aria-hidden="true">
              <i class="fa-solid fa-chevron-right"></i>
            </span>
          </div>
        </div>
      </a>
    @empty
      <div class="forum-empty reveal-up" role="status">
        <div class="empty-illus" aria-hidden="true">💬</div>
        <div class="empty-text">Belum ada topik.</div>
        @auth
          <a href="{{ route('forum.thread.create') }}" class="btn-cta btn-cta--mini btn-cta--primary mt-8">Mulai Diskusi</a>
        @endauth
      </div>
    @endforelse

    {{-- Pagination bawaan laravel kalau ada (kalau kamu ubah controller jadi paginate) --}}
    @if(method_exists($threads, 'links'))
      <div class="forum-pagination">
        {{ $threads->links() }}
      </div>
    @endif

  </div>
</section>
@endsection
