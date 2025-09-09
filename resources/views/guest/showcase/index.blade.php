@extends('layouts.guest')

@push('styles')
  <link rel="stylesheet" href="{{ asset('guest/showcase.css') }}">
@endpush

@section('content')
  {{-- HERO --}}
  <section class="sc-hero">
    <div class="sc-wrap">
      <h1 class="sc-hero__title">Galeri Karya Member</h1>
      <p class="sc-hero__subtitle">
        Di e-learning, kami percaya semua orang bisa memulai dari nol dan berkarya.
        Berikut adalah hasil karya member, mulai dari project kecil hingga aplikasi profesional.
      </p>
    </div>
  </section>

{{-- GRID KARYA --}}
<section class="sc-grid-section" id="gallery">
  <div class="sc-wrap">
    @if($showcases->count())
      <div class="sc-grid" id="sc-grid">
        @foreach($showcases as $index => $s)
          <article class="sc-card {{ $index >= 6 ? 'hidden-card' : '' }}"
                   data-id="{{ $s->id }}"
                   data-title="{{ $s->title }}"
                   data-desc="{{ $s->description }}"
                   data-image="{{ $s->image_path ? asset('storage/'.$s->image_path) : asset('images/default.png') }}"
                   data-user="{{ $s->user->name ?? 'Anonymous' }}"
                   data-date="{{ $s->created_at?->format('d M Y') }}">
            <div class="sc-card__media">
              <img src="{{ $s->image_path ? asset('storage/'.$s->image_path) : asset('images/default.png') }}"
                   alt="{{ $s->title }}">
            </div>
            <div class="sc-card__body">
              <h3 class="sc-card__title">{{ $s->title }}</h3>
              <p class="sc-card__desc">
                {{ \Illuminate\Support\Str::limit(strip_tags($s->description), 120) }}
              </p>
            </div>
            <div class="sc-card__footer">
              <span class="sc-meta">Oleh <strong>{{ $s->user->name ?? 'Anonymous' }}</strong></span>
              <span class="sc-dot">•</span>
              <time class="sc-date">{{ $s->created_at?->format('d M Y') }}</time>
            </div>
          </article>
        @endforeach
      </div>

      {{-- Tombol Lihat Semua --}}
      @if($showcases->count() > 6)
        <div class="sc-showmore">
          <button id="show-all-btn" class="sc-btn sc-btn--primary">Lihat Semua</button>
        </div>
      @endif
    @else
      <div class="sc-empty">
        <div class="sc-empty__box">
          <div class="sc-empty__icon">📁</div>
          <div class="sc-empty__text">Belum ada karya yang ditambahkan.</div>
        </div>
      </div>
    @endif
  </div>
</section>

{{-- MODAL DETAIL --}}
<div id="sc-modal" class="sc-modal">
  <div class="sc-modal__overlay"></div>
  <div class="sc-modal__content">
    <button class="sc-modal__close" aria-label="Tutup Modal">&times;</button>
    <div class="sc-modal__img">
      <img id="modal-image" src="" alt="">
    </div>
    <div class="sc-modal__info">
      <h2 id="modal-title"></h2>
      <p id="modal-desc"></p>
      <div class="sc-modal__meta">
        <span id="modal-user"></span> • <span id="modal-date"></span>
      </div>
    </div>
  </div>
</div>


{{-- BAND: Statement --}}
<section class="sc-band-modern">
  <div class="sc-wrap">
    <div class="sc-band__content">
      <h2 class="sc-band__title">🚀 Mulai Dari Nol, Raih Portofolio Profesional</h2>
      <p class="sc-band__subtitle">
        Banyak member kami awalnya bukan dari IT.  
        Dengan latihan, studi kasus, dan bimbingan mentor,  
        mereka berhasil membuat project profesional yang layak dipamerkan.
      </p>
    </div>
  </div>
</section>

{{-- CTA MODERN --}}
<section class="sc-cta-modern">
  <div class="sc-wrap sc-cta__inner">
    <div class="sc-cta__text">
      <h3>Ingin Hasilkan Karya Seperti Mereka?</h3>
      <p>
        Mulai belajar dari materi dasar, kerjakan studi kasus nyata,  
        dan tampilkan karyamu di sini bersama ratusan member lainnya.
      </p>
    </div>
    <a href="{{ route('login') }}" class="sc-btn-modern">
      <span>✨ Daftar Sekarang</span>
    </a>
  </div>
</section>


@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const cards = document.querySelectorAll('.sc-card');
  const modal = document.getElementById('sc-modal');
  const modalImage = document.getElementById('modal-image');
  const modalTitle = document.getElementById('modal-title');
  const modalDesc  = document.getElementById('modal-desc');
  const modalUser  = document.getElementById('modal-user');
  const modalDate  = document.getElementById('modal-date');
  const closeBtn   = document.querySelector('.sc-modal__close');
  const overlay    = document.querySelector('.sc-modal__overlay');

  const open = () => { modal.classList.add('show'); document.body.style.overflow = 'hidden'; }
  const close = () => { modal.classList.remove('show'); document.body.style.overflow = ''; }

  cards.forEach(card => {
    card.addEventListener('click', () => {
      modalImage.src   = card.dataset.image;
      modalTitle.textContent = card.dataset.title;
      modalDesc.textContent  = card.dataset.desc;
      modalUser.textContent  = card.dataset.user;
      modalDate.textContent  = card.dataset.date;
      open();
    });
  });

  closeBtn.addEventListener('click', close);
  overlay.addEventListener('click', close);
  window.addEventListener('keydown', e => { if (e.key === 'Escape') close(); });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const showAllBtn = document.getElementById('show-all-btn');
  if (showAllBtn) {
    showAllBtn.addEventListener('click', () => {
      document.querySelectorAll('.hidden-card').forEach(card => {
        card.style.display = 'flex';
      });
      showAllBtn.style.display = 'none';
    });
  }
});
</script>

@endpush
