@extends('layouts.student')

@push('styles')
    <link rel="stylesheet" href="{{ asset('client/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endpush

@section('title', 'Dashboard - Learnify')

@section('content')
<main class="dashboard-container">

    {{-- ===== Profile ===== --}}
    <section class="profile-header">
        <img
            src="{{ Auth::user()->profile && Auth::user()->profile->foto
                ? asset('storage/' . Auth::user()->profile->foto)
                : asset('image/avatar.jpg') }}"
            alt="Foto profil {{ Auth::user()->profile->nama_lengkap ?? Auth::user()->name }}"
            class="avatar"
        >
        <div class="user-info">
            <h1 class="page-title">Hi, {{ Auth::user()->profile->nama_lengkap ?? Auth::user()->name }} 👋</h1>
            <p class="page-subtitle">Selamat datang kembali! Ayo lanjutkan belajar.</p>
        </div>
    </section>

    {{-- ===== Progress Belajar (Full-width top) ===== --}}
    @php
      // Fallback agar kompatibel dengan controller lama/baru
      $progressPercent = $overviewPercent
          ?? $overallProgressPercent
          ?? 0;

      $progressLabel = $overviewLabel
          ?? 'Progress Belajar';

      // Dropdown data: gunakan $activeCourses jika tersedia; kalau tidak, ambil dari $continueLearning
      $activeList = (isset($activeCourses) && $activeCourses instanceof \Illuminate\Support\Collection)
          ? $activeCourses
          : collect($continueLearning ?? [])->map(fn($it)=>$it['course'] ?? null)->filter()->unique('id')->values();

      $selectedId = (int) ($selectedCourseId ?? request()->integer('course'));
    @endphp

    <section class="progress-wide card">
        <div class="pw-left">
            <div class="pw-head">
                <h2 class="pw-title"><i class="fas fa-chart-line"></i> {{ $progressLabel }}</h2>

                {{-- Dropdown filter course (opsional). Jika kosong -> semua course --}}
                @if($activeList->count() > 0)
                <form method="GET" action="{{ route('dashboard.index') }}" class="progress-filter" aria-label="Filter course untuk progress">
                  <label for="course" class="sr-only">Pilih course</label>
                  <div class="select-wrap">
                    <select id="course" name="course" onchange="this.form.submit()" aria-label="Pilih course untuk menghitung progress">
                      <option value="">— Semua course aktif —</option>
                      @foreach($activeList as $ac)
                        <option value="{{ $ac->id }}" {{ $selectedId === (int)$ac->id ? 'selected' : '' }}>
                          {{ $ac->name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </form>
                @endif
            </div>

            <div class="pw-meter">
                <div class="pw-track" aria-label="Progress belajar">
                    <span class="pw-fill" style="width: {{ max(0, min(100, (int)$progressPercent)) }}%"></span>
                </div>
                <div class="pw-meta">
                    <span class="pw-percent">{{ (int)$progressPercent }}%</span>
                    @if((int)$progressPercent >= 100)
                        <span class="pw-note done">Selesai semua 🎉</span>
                    @else
                        <span class="pw-note">Tetap semangat! Sedikit lagi 💪</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Stat Active Courses pindah ke kanan kecil --}}
        <div class="pw-stat">
            <p class="stat-label"><i class="fa-solid fa-book-open"></i> Active Courses</p>
            <p class="stat-value">{{ $activeCoursesCount ?? $activeList->count() }}</p>
        </div>
    </section>

    {{-- ===== Row bawah: kiri Active Courses, kanan Continue Learning ===== --}}
    <div class="below-grid">
        {{-- ==== LEFT: Active Courses (card list ringkas) ==== --}}
        <section class="card acard">
            <div class="card-head">
                <h3 class="card-title"><i class="fa-solid fa-layer-group"></i> Active Courses</h3>
            </div>

            @php
              // Sumber data active courses: prefer $continueLearning (ada progress & nextLesson)
              $activeItems = collect($continueLearning ?? [])->map(function($it){
                  $c = $it['course'] ?? null;
                  if(!$c) return null;
                  return [
                      'course' => $c,
                      'progress' => (int)($it['progress'] ?? 0),
                      'nextLesson' => $it['nextLesson'] ?? null,
                      'lessons_count' => (int)($it['lessons_count'] ?? ($c->lessons()->count() ?? 0)),
                  ];
              })->filter()->values();

              $doneCount = $activeItems->filter(fn($i) => ((int)$i['progress']) >= 100)->count();
              $todoCount = max(0, $activeItems->count() - $doneCount);
            @endphp

            @if($activeItems->isEmpty())
              <p class="muted">Belum ada kursus aktif.</p>
            @else
              {{-- Pill ringkasan status --}}
              <div class="ac-stat-row">
                <span class="pill pill-todo"><i class="fa-regular fa-clock"></i> In progress: {{ $todoCount }}</span>
                <span class="pill pill-done"><i class="fa-solid fa-circle-check"></i> Completed: {{ $doneCount }}</span>
              </div>

              <ul class="a-list">
                @foreach($activeItems as $item)
                  @php
                    $c = $item['course'];
                    $p = (int) $item['progress'];
                    $done = $p >= 100;
                  @endphp
                  <li class="a-item">
                    <div class="a-info">
                      <h4 class="a-name">{{ $c->name }}</h4>
                      <div class="a-line">
                        <div class="a-track"><span style="width: {{ $p }}%"></span></div>
                        <small class="a-caption">{{ $p }}%</small>
                      </div>
                      <span class="badge {{ $done ? 'bdone' : 'bprog' }}">
                        {{ $done ? 'Completed' : 'In progress' }}
                      </span>
                    </div>
                    <div class="a-cta">
                      @if($done)
                        <a class="btn ghost" href="{{ route('detail.index', $c->slug) }}">Review</a>
                      @else
                        @php $next = $item['nextLesson']; @endphp
                        @if($next)
                          <a class="btn primary" href="{{ route('lesson.index', [$c->slug, 'lesson' => $next->id]) }}">Continue</a>
                        @else
                          <a class="btn primary" href="{{ route('detail.index', $c->slug) }}">Lihat</a>
                        @endif
                      @endif
                    </div>
                  </li>
                @endforeach
              </ul>
            @endif
        </section>

        {{-- ==== RIGHT: Continue Learning ==== --}}
        <section class="cl-wrap">
            <div class="cl-head">
                <h2 class="section-title">Continue Learning</h2>
            </div>

            @php
              $cl = collect($continueLearning ?? []);
              $isSlider = $cl->count() > 3;
            @endphp

            @if(!$isSlider)
              {{-- Grid biasa (<=3 items) --}}
              <div class="course-grid">
                @forelse($cl as $it)
                  @php
                    $c     = $it['course'];
                    $next  = $it['nextLesson'] ?? null;
                    $p     = (int)($it['progress'] ?? 0);
                    $count = (int)($it['lessons_count'] ?? 0);
                    $done  = $p >= 100;
                  @endphp
                  <article class="course-card">
                    <div>
                      <div class="icon" aria-hidden="true"><i class="fas fa-book"></i></div>
                      <h3 class="course-title">{{ $c->name }}</h3>
                      <p class="course-meta">
                        @if($done)
                          {{ $p }}% selesai • Selesai 🎉
                        @else
                          {{ $p }}% selesai
                          @if($next)
                            • Next: {{ $next->module_name ? $next->module_name.' · ' : '' }}{{ $next->title }}
                          @endif
                        @endif
                      </p>
                      <span class="badge {{ $done ? 'bdone' : 'bprog' }}">{{ $done ? 'Completed' : 'In progress' }}</span>

                      <div class="mini-line">
                        <div class="mini-track"><span style="width: {{ $p }}%"></span></div>
                        <small class="mini-caption">{{ $p }}% • {{ $count }} modul</small>
                      </div>
                    </div>

                    @if($done)
                      <a class="btn-primary" href="{{ route('detail.index', $c->slug) }}">Review</a>
                    @else
                      @if($next)
                        <a class="btn-primary" href="{{ route('lesson.index', [$c->slug, 'lesson' => $next->id]) }}">Continue</a>
                      @else
                        <a class="btn-primary" href="{{ route('detail.index', $c->slug) }}">Lihat</a>
                      @endif
                    @endif
                  </article>
                @empty
                  <p class="muted">Belum ada kursus untuk dilanjut.</p>
                @endforelse
              </div>
            @else
              {{-- Slider ( > 3 items ) --}}
              <div class="cl-slider" id="cl-slider" aria-roledescription="carousel" aria-label="Continue Learning">
                <div class="cl-track" id="cl-track">
                  @foreach($cl as $it)
                    @php
                      $c     = $it['course'];
                      $next  = $it['nextLesson'] ?? null;
                      $p     = (int)($it['progress'] ?? 0);
                      $count = (int)($it['lessons_count'] ?? 0);
                      $done  = $p >= 100;
                    @endphp
                    <article class="course-card cl-item" role="group">
                      <div>
                        <div class="icon" aria-hidden="true"><i class="fas fa-book"></i></div>
                        <h3 class="course-title">{{ $c->name }}</h3>
                        <p class="course-meta">
                          @if($done)
                            {{ $p }}% selesai • Selesai 🎉
                          @else
                            {{ $p }}% selesai
                            @if($next)
                              • Next: {{ $next->module_name ? $next->module_name.' · ' : '' }}{{ $next->title }}
                            @endif
                          @endif
                        </p>
                        <span class="badge {{ $done ? 'bdone' : 'bprog' }}">{{ $done ? 'Completed' : 'In progress' }}</span>

                        <div class="mini-line">
                          <div class="mini-track"><span style="width: {{ $p }}%"></span></div>
                          <small class="mini-caption">{{ $p }}% • {{ $count }} modul</small>
                        </div>
                      </div>

                      @if($done)
                        <a class="btn-primary" href="{{ route('detail.index', $c->slug) }}">Review</a>
                      @else
                        @if($next)
                          <a class="btn-primary" href="{{ route('lesson.index', [$c->slug, 'lesson' => $next->id]) }}">Continue</a>
                        @else
                          <a class="btn-primary" href="{{ route('detail.index', $c->slug) }}">Lihat</a>
                        @endif
                      @endif
                    </article>
                  @endforeach
                </div>

                <div class="cl-nav">
                  <button class="cl-btn" id="cl-prev" aria-label="Sebelumnya"><i class="fa-solid fa-chevron-left"></i></button>
                  <button class="cl-btn" id="cl-next" aria-label="Berikutnya"><i class="fa-solid fa-chevron-right"></i></button>
                </div>
              </div>
            @endif
        </section>
    </div>
</main>
@endsection

@push('scripts')
<script>
(function(){
  // Auto slider Continue Learning bila ada track
  const track = document.getElementById('cl-track');
  if(!track) return;

  const prevBtn = document.getElementById('cl-prev');
  const nextBtn = document.getElementById('cl-next');
  const slider  = document.getElementById('cl-slider');

  // Scroll snap per kartu
  const CARD_GAP = 16; // match CSS gap
  const step = () => {
    const card = track.querySelector('.cl-item');
    if(!card) return 300;
    return card.getBoundingClientRect().width + CARD_GAP;
  }

  function scrollByStep(dir = 1){
    track.scrollBy({ left: dir * step(), behavior: 'smooth' });
  }

  prevBtn?.addEventListener('click', ()=>scrollByStep(-1));
  nextBtn?.addEventListener('click', ()=>scrollByStep(+1));

  // Auto slide tiap 5 detik (pause saat hover)
  let auto = setInterval(()=>scrollByStep(+1), 5000);
  slider?.addEventListener('mouseenter', ()=>clearInterval(auto));
  slider?.addEventListener('mouseleave', ()=>{
    clearInterval(auto);
    auto = setInterval(()=>scrollByStep(+1), 5000);
  });
})();
</script>
@endpush
