@extends('layouts.guest')

@push('styles')
  <link rel="stylesheet" href="{{ asset('guest/about.css') }}">
@endpush

@section('content')

@php
  // Helper untuk ambil item pertama dari section tertentu
  $getFirst = function($key) use ($contents) {
      return $contents->has($key) && $contents->get($key)->isNotEmpty()
          ? $contents->get($key)->first()
          : null;
  };

  // Data HERO (opsional dari DB): section = hero_title (title), hero_image (image)
  $heroTitleItem = $getFirst('hero_title');
  $heroImageItem = $getFirst('hero_image');

  $heroTitle = $heroTitleItem?->title ?? 'ABOUT US';
  // Kalau admin upload gambar di hero_image->image, pakai itu; kalau tidak, fallback ke banner bawaan
  $heroImage = $heroImageItem?->image ? asset('storage/'.$heroImageItem->image) : asset('image/banner.jpg');
@endphp

<!-- ===== HERO ===== -->
<section class="about-hero" style="--hero-bg:url('{{ $heroImage }}')">
  <div class="about-hero__overlay">
    <h1 class="about-hero__title">{{ $heroTitle }}</h1>
  </div>
</section>

<!-- ===== INTRO (opsional) | section: about_intro ===== -->
@php
  $intro = $getFirst('about_intro');
@endphp
@if($intro)
<section class="about-intro container">
  <div class="about-intro__text">
    <h2 class="section-title">{{ $intro->title ?? 'Tentang E-Learning Kami' }}</h2>
    @if(!empty($intro->description))
      <div class="rich-text">{!! $intro->description !!}</div>
    @endif
  </div>
  <div class="about-intro__media">
    <img class="img-card" src="{{ $intro->image ? asset('storage/'.$intro->image) : asset('image/si-imut.png') }}"
         alt="{{ $intro->title ?? 'Tentang Kami' }}">
  </div>
</section>
@endif

<!-- ===== VISI & MISI (opsional) | section: visi, misi ===== -->
@php
  $visi = $getFirst('visi');
  $misi = $getFirst('misi');
@endphp
@if($visi || $misi)
<section class="vm container">
  @if($visi)
    <div class="vm__row">
      <div class="vm__media">
        <img class="img-soft" src="{{ asset('image/laptop1.png') }}" alt="Visi">
      </div>
      <div class="vm__content">
        <h3 class="section-subtitle">VISI</h3>
        @if(!empty($visi->description)) <div class="rich-text">{!! $visi->description !!}</div> @endif
      </div>
    </div>
  @endif

  @if($misi)
    <div class="vm__row vm__row--reverse">
      <div class="vm__media">
        <img class="img-soft" src="{{ asset('image/laptop2.png') }}" alt="Misi">
      </div>
      <div class="vm__content">
        <h3 class="section-subtitle">MISI</h3>
        @if(!empty($misi->description)) <div class="rich-text">{!! $misi->description !!}</div> @endif
      </div>
    </div>
  @endif
</section>
@endif

<!-- ===== SEJARAH (opsional, bisa banyak item) | section: sejarah ===== -->
@if($contents->has('sejarah') && $contents->get('sejarah')->isNotEmpty())
<section class="history">
  <div class="container">
    <h3 class="section-title center">Sejarah Singkat</h3>
    <div class="history__stack">
      @foreach($contents->get('sejarah') as $row)
        <article class="history__item card">
          @if(!empty($row->title))
            <h4 class="card__title">{{ $row->title }}</h4>
          @endif
          @if(!empty($row->description))
            <div class="card__body rich-text">{!! $row->description !!}</div>
          @endif
          @if(!empty($row->image))
            <img class="card__image" src="{{ asset('storage/'.$row->image) }}" alt="{{ $row->title ?? 'Sejarah' }}">
          @endif
        </article>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- ===== GENERIC RENDER untuk SEMUA SECTION lain (otomatis) ===== -->
@php
  $reserved = collect(['hero_title','hero_image','about_intro','visi','misi','sejarah']);
@endphp

@foreach($contents as $section => $items)
  @continue($reserved->contains($section))

  <section class="generic">
    <div class="container">
      <h3 class="section-title center">{{ Str::of($section)->upper() }}</h3>

      @if($items->count() > 1)
        <!-- Grid bila item banyak -->
        <div class="grid">
          @foreach($items as $item)
            <article class="card">
              @if(!empty($item->image))
                <img class="card__image" src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->title ?? $section }}">
              @endif
              @if(!empty($item->title))
                <h4 class="card__title">{{ $item->title }}</h4>
              @endif
              @if(!empty($item->description))
                <div class="card__body rich-text">{!! $item->description !!}</div>
              @endif
            </article>
          @endforeach
        </div>
      @else
        <!-- Satu item: layout lebar -->
        @php $item = $items->first(); @endphp
        <article class="card card--wide">
          @if(!empty($item->image))
            <img class="card__image" src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->title ?? $section }}">
          @endif
          <div class="card__content">
            @if(!empty($item->title))
              <h4 class="card__title">{{ $item->title }}</h4>
            @endif
            @if(!empty($item->description))
              <div class="card__body rich-text">{!! $item->description !!}</div>
            @endif
          </div>
        </article>
      @endif
    </div>
  </section>
@endforeach

<!-- ===== EMPTY STATE (kalau benar-benar belum ada konten sama sekali) ===== -->
@if($contents->isEmpty())
<section class="empty">
  <div class="container">
    <div class="empty__box">
      <h3>Tidak ada konten About.</h3>
      <p>Silakan tambahkan konten dari panel Admin &rarr; About.</p>
    </div>
  </div>
</section>
@endif

@endsection
