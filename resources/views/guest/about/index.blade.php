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

  // Resolusi hero image aman (pakai placeholder jika kosong)
  $heroImagePath = $heroImageItem?->image ? 'storage/'.$heroImageItem->image : 'image/banner.jpg';
  $heroImage = asset($heroImagePath);
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
    @php
      $introImg = $intro->image ? asset('storage/'.$intro->image) : asset('image/placeholder-landscape.jpg');
    @endphp
    <div class="media">
      <img loading="lazy" src="{{ $introImg }}" alt="{{ $intro->title ?? 'Tentang Kami' }}">
    </div>
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
        <div class="media media--blob">
          <img loading="lazy" src="{{ asset('image/laptop1.png') }}" alt="Visi">
        </div>
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
        <div class="media media--blob">
          <img loading="lazy" src="{{ asset('image/laptop2.png') }}" alt="Misi">
        </div>
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
    <div class="cards cards--auto">
      @foreach($contents->get('sejarah') as $row)
        <article class="card" data-animate>
          <div class="card__media">
            @php
              $img = !empty($row->image) ? asset('storage/'.$row->image) : asset('image/placeholder-landscape.jpg');
            @endphp
            <div class="media media--ratio">
              <img loading="lazy" src="{{ $img }}" alt="{{ $row->title ?? 'Sejarah' }}">
            </div>
          </div>
          <div class="card__content">
            @if(!empty($row->title))
              <h4 class="card__title">{{ $row->title }}</h4>
            @endif
            @if(!empty($row->description))
              <div class="card__body rich-text">{!! $row->description !!}</div>
            @endif
          </div>
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

  @php
    // Judul section rapi
    $sectionTitle = \Illuminate\Support\Str::of($section)->replace('_',' ')->title();
  @endphp

  <section class="generic">
    <div class="container">
      <h3 class="section-title center">{{ $sectionTitle }}</h3>

      @if($items->count() > 1)
        <!-- Grid bila item banyak -->
        <div class="cards cards--auto">
          @foreach($items as $item)
            @php
              $img = !empty($item->image) ? asset('storage/'.$item->image) : asset('image/placeholder-landscape.jpg');
            @endphp
            <article class="card" data-animate>
              <div class="card__media">
                <div class="media media--ratio">
                  <img loading="lazy" src="{{ $img }}" alt="{{ $item->title ?? $sectionTitle }}">
                </div>
              </div>
              <div class="card__content">
                @if(!empty($item->title))
                  <h4 class="card__title">{{ $item->title }}</h4>
                @endif
                @if(!empty($item->description))
                  <div class="card__body rich-text">{!! $item->description !!}</div>
                @endif
              </div>
            </article>
          @endforeach
        </div>
      @else
        <!-- Satu item: layout lebar -->
        @php
          $item = $items->first();
          $img = !empty($item->image) ? asset('storage/'.$item->image) : asset('image/placeholder-landscape.jpg');
        @endphp
        <article class="card card--wide" data-animate>
          <div class="card__media">
            <div class="media media--ratio">
              <img loading="lazy" src="{{ $img }}" alt="{{ $item->title ?? $sectionTitle }}">
            </div>
          </div>
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

<!-- ===== EMPTY STATE ===== -->
@if($contents->isEmpty())
<section class="empty">
  <div class="container">
    <div class="empty__box">
      <h3>Tidak ada konten About.</h3>
      <p>Silakan tambahkan konten dari panel Admin → About.</p>
    </div>
  </div>
</section>
@endif

@endsection
