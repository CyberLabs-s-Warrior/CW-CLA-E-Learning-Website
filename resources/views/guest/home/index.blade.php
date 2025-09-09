@extends('layouts.guest')

@push('styles')
  <link rel="stylesheet" href="{{ asset('guest/home.css') }}" />
  <link rel="stylesheet" href="{{ asset('client/footer.css') }}" />
@endpush

@section('title', 'Learnify - Home')

@section('content')
  {{-- ================= HERO ================= --}}
  <main class="hero hero--accent">
    <div class="container hero-content">
      <div class="text-content">
        <h1>
          Learn and grow <br />
          your skills
        </h1>
        <p>
          Take your learning to the next level. Join our platform and explore a variety of online courses.
        </p>
        <a href="{{ route('katalog.index') }}" class="btn">Get Started</a>

        <div class="hero-trust">
          <span>⭐ 4.8/5 Reviews</span>
          <span>👥 120K+ Students</span>
          <span>🧑‍🏫 50+ Mentors</span>
        </div>
      </div>

      <div class="image">
        <img
          src="{{ asset('image/iconpage.png') }}"
          onerror="this.src='https://images.unsplash.com/photo-1521737604893-d14cc237f11d?q=80&w=1200&auto=format&fit=crop'"
          alt="Hero Image" class="main-img" />
      </div>
    </div>

    <div class="stats-bar">
      <div class="container stats">
        <div class="stat"><span class="num">120K+</span><span class="lbl">Students</span></div>
        <div class="stat"><span class="num">350+</span><span class="lbl">Courses</span></div>
        <div class="stat"><span class="num">50+</span><span class="lbl">Mentors</span></div>
        <div class="stat"><span class="num">900+</span><span class="lbl">Lessons</span></div>
      </div>
    </div>
  </main>

  {{-- ============== WHY #1 ============== --}}
  <section class="why-section soft-1">
    <div class="container why-split">
      <div class="why-text">
        <h2 class="section-title section-title--left">Belajar Terarah, Nggak Bingung Mulai</h2>
        <p class="section-sub left">
          Pilih jalur (Web, Mobile, Data/AI) → ikuti modul berurutan → praktik proyek mini. Semua dirancang bertahap.
        </p>

        <ul class="why-list">
          <li><span class="bullet">①</span> Roadmap jelas dari dasar sampai mahir.</li>
          <li><span class="bullet">②</span> Tiap modul singkat & fokus (video + kuis).</li>
          <li><span class="bullet">③</span> Proyek mini supaya langsung “nempel”.</li>
        </ul>

        <div class="chips mt-12">
          <a href="{{ route('katalog.index', ['category' => 'web']) }}" class="chip">Web Development</a>
          <a href="{{ route('katalog.index', ['category' => 'aplikasi']) }}" class="chip">Mobile</a>
          <a href="{{ route('katalog.index') }}" class="chip">Data & AI</a>
        </div>
      </div>

      <div class="why-media">
        <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?q=80&w=1200&auto=format&fit=crop" alt="Learning Path">
      </div>
    </div>
  </section>

  {{-- ============== WHY #2 ============== --}}
  <section class="why-section soft-2">
    <div class="container why-split reverse">
      <div class="why-media">
        <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=1200&auto=format&fit=crop" alt="Project Based">
      </div>
      <div class="why-text">
        <h2 class="section-title section-title--left">Relevan dengan Industri & Project-Based</h2>
        <p class="section-sub left">
          Materi mengikuti kebutuhan pasar. Output-mu: portfolio yang bisa dipamerkan di CV/LinkedIn.
        </p>

        <div class="pill-grid">
          <span class="pill">Best-practice coding</span>
          <span class="pill">Studi kasus nyata</span>
          <span class="pill">Checklist skill</span>
          <span class="pill">Template proyek</span>
        </div>
      </div>
    </div>
  </section>

  {{-- ============== WHY #3 ============== --}}
  <section class="why-section soft-3">
    <div class="container why-split">
      <div class="why-text">
        <h2 class="section-title section-title--left">Ada yang Bimbing & Komunitas yang Aktif</h2>
        <p class="section-sub left">
          Belajar bareng, dapat feedback mentor, dan akses sumber karier seperti resume review & mock interview.
        </p>

        <ul class="why-list">
          <li><span class="check">✔</span> Forum/Group diskusi & live Q&A.</li>
          <li><span class="check">✔</span> Review tugas/portfolio.</li>
          <li><span class="check">✔</span> Tips karier & job board internal.</li>
        </ul>
      </div>

      <div class="why-media">
        <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=1200&auto=format&fit=crop" alt="Project Based">
      </div>
    </div>
  </section>

  {{-- ============== INSTRUKTUR (dinamis) ============== --}}
<section class="instructors-pro">
  <div class="container">
    <h2 class="section-title" style="text-align:center">Instruktur Terverifikasi</h2>
    <p class="section-sub">Foto besar, jabatan jelas, dan ringkasan pengalaman yang relevan.</p>

    @if($topInstructors->isNotEmpty())
      <div class="mentor-grid mentor-grid--3">
        @foreach($topInstructors as $p)
          @php
            $name = $p->user->name ?? 'Instruktur';
            $img  = $p->avatar_path
                      ? asset('storage/'.$p->avatar_path)
                      : 'https://ui-avatars.com/api/?name='.urlencode($name).'&background=EAF2FF&color=0D6EFD&bold=true';
          @endphp

          <article class="mentor-card">
            <div class="mentor-photo">
              <img src="{{ $img }}" alt="{{ $name }}" loading="lazy">
            </div>
            <div class="mentor-body">
              <h3 class="mentor-name">{{ $name }}</h3>
              <div class="mentor-role">{{ $p->primary_skill }}</div>
              <p class="mentor-desc">{{ $p->short_bio }}</p>

              @if($p->github_url || $p->linkedin_url)
                <div class="mentor-social">
                  @if($p->github_url)
                    <a class="social-btn" href="{{ $p->github_url }}" target="_blank" rel="noopener" aria-label="GitHub {{ $name }}">
                      <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 .5a12 12 0 0 0-3.79 23.4c.6.11.82-.26.82-.58 0-.29-.01-1.06-.02-2.07-3.34.73-4.05-1.61-4.05-1.61-.55-1.41-1.34-1.79-1.34-1.79-1.09-.75.08-.74.08-.74 1.2.08 1.83 1.23 1.83 1.23 1.07 1.83 2.81 1.3 3.5.99.11-.78.42-1.3.76-1.6-2.67-.31-5.48-1.34-5.48-5.95 0-1.31.47-2.38 1.23-3.22-.12-.31-.54-1.55.12-3.23 0 0 1.01-.32 3.3 1.23A11.5 11.5 0 0 1 12 6.84c1.02.01 2.05.14 3.01.41 2.29-1.55 3.3-1.23 3.3-1.23.66 1.68.24 2.92.12 3.23.77.84 1.23 1.91 1.23 3.22 0 4.62-2.81 5.63-5.49 5.94.43.37.81 1.1.81 2.22 0 1.6-.01 2.89-.01 3.29 0 .32.22.7.83.58A12 12 0 0 0 12 .5Z"/>
                      </svg>
                    </a>
                  @endif
                  @if($p->linkedin_url)
                    <a class="social-btn" href="{{ $p->linkedin_url }}" target="_blank" rel="noopener" aria-label="LinkedIn {{ $name }}">
                      <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M4.98 3.5a2.5 2.5 0 1 1 0 5.001 2.5 2.5 0 0 1 0-5zM3 9h4v12H3zM14.5 9c-2.33 0-3.5 1.27-3.5 2.73V21h4v-6.2c0-1.07.74-1.8 1.8-1.8 1.02 0 1.7.69 1.7 1.8V21h4v-7.06C22.5 10.55 20.7 9 18.2 9c-1.24 0-2.38.54-3 1.41V9h-.7z"/>
                      </svg>
                    </a>
                  @endif
                </div>
              @endif
            </div>
          </article>
        @endforeach
      </div>

      <div class="center" style="margin-top:16px;">
        <a href="{{ route('instruktur.index') }}" class="btn btn--light">Lihat semua instruktur</a>
      </div>
    @else
      <p class="muted-center">Belum ada instruktur yang ditampilkan.</p>
    @endif
  </div>
</section>


  {{-- ============== CTA ============== --}}
  <section class="cta-join">
    <div class="container cta-wrap">
      <div class="cta-text">
        <h2>Jangan Belajar Sendiri. Gabung & Naik Level Bareng!</h2>
        <p>Akses materi lengkap, proyek nyata, dan komunitas suportif. Mulai gratis, upgrade kapan pun.</p>
        <div class="cta-actions">
          <a href="{{ route('register') }}" class="btn">Daftar Sekarang</a>
          <a href="{{ route('login') }}" class="btn btn--light">Saya Sudah Punya Akun</a>
        </div>
      </div>
      <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?q=80&w=1200&auto=format&fit=crop" alt="">
    </div>
  </section>

 {{-- ============== REVIEWS (minimal) ============== --}}
<section id="reviews" class="rv-section">
  <div class="container">
    <div class="rv-head">
      <h2 class="rv-title">Apa Kata Mereka</h2>
      <p class="rv-sub">Ulasan dari member yang telah mengikuti kursus di Learnify.</p>
    </div>

    <div class="rv-grid">
      @forelse($testimonials as $t)
        @php
          $name = $t->user->name ?? 'Student';
          $parts = preg_split('/\s+/', trim($name));
          $initials = strtoupper(mb_substr($parts[0] ?? '', 0, 1) . mb_substr(end($parts) ?: '', 0, 1));
          $hue = crc32($name) % 360;
        @endphp

        <article class="rv-card">
          <div class="rv-card-head">
            <div class="rv-avatar" style="--hue: {{ $hue }}">{{ $initials }}</div>
            <div class="rv-id">
              <h3 class="rv-name">{{ $name }}</h3>
              <span class="rv-role">Student</span>
            </div>
          </div>

          <p class="rv-text">{{ $t->content }}</p>
        </article>
      @empty
        <p class="rv-empty">Belum ada testimoni.</p>
      @endforelse
    </div>

    @if(!empty($testiHasMore) && $testiHasMore)
      <div class="rv-foot">
        <a href="{{ route('testimoni.index') }}" class="rv-btn">Lihat semua testimoni</a>
      </div>
    @endif
  </div>
</section>

  
@endsection
