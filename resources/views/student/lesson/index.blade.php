{{-- resources/views/student/lesson/index.blade.php --}}
@extends('layouts.student')

@push('styles')
    <link rel="stylesheet" href="{{ asset('client/lesson.css') }}">
    {{-- Font Awesome (jika layout belum include) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endpush

{{-- Pakai name kalau title tidak ada --}}
@section('title', 'Learnify - Lessons of ' . ($course->name ?? $course->title ?? 'Course'))

@section('content')
@php
    // Urutkan lesson agar konsisten: module_name ASC, order ASC
    $orderedLessons = $course->lessons->sortBy([
        ['module_name','asc'],
        ['order','asc'],
    ]);

    // Hitung progress user terhadap course
    $totalLessons = $orderedLessons->count();
    $doneCount = \App\Models\LessonProgress::where('user_id', auth()->id())
        ->where('course_id', $course->id)
        ->count();
    $percent = $totalLessons ? (int) round(($doneCount / $totalLessons) * 100) : 0;

    // Cek status lesson aktif (sudah selesai atau belum)
    $isThisLessonDone = \App\Models\LessonProgress::where('user_id', auth()->id())
        ->where('lesson_id', $lesson->id)
        ->exists();

    // Cari next lesson yang belum selesai
    $doneIds = \App\Models\LessonProgress::where('user_id', auth()->id())
        ->where('course_id', $course->id)
        ->pluck('lesson_id')
        ->all();

    $nextLesson = $orderedLessons->first(function($l) use ($doneIds) {
        return !in_array($l->id, $doneIds);
    });
@endphp

<div class="lesson-page">
    {{-- ======= HEADER / BREADCRUMB ======= --}}
    <section class="lp-header container" aria-label="Course header">
        <nav class="crumbs" aria-label="Breadcrumb">
            <a href="{{ route('detail.index', $course->slug) }}" class="crumb">
                <i class="fa-solid fa-chevron-left"></i>
                Kembali ke Detail Kursus
            </a>
        </nav>

        <div class="course-head">
            <div class="head-text">
                <h1 class="course-name">{{ $course->name ?? $course->title }}</h1>
                <div class="sub">
                    <span class="badge-level">
                        <i class="fa-solid fa-signal"></i>
                        {{ $course->level->level ?? 'Level' }}
                    </span>
                    <span class="dot">•</span>
                    <span>
                        <i class="fa-regular fa-clock"></i>
                        {{ $lesson?->duration ? gmdate('i:s', $lesson->duration) : '00:00' }}
                    </span>
                    <span class="dot">•</span>
                    <span>
                        <i class="fa-solid fa-user-tie"></i>
                        @if($course->instructors->isNotEmpty())
                            {{ $course->instructors->pluck('name')->join(', ') }}
                        @else
                            Instruktur
                        @endif
                    </span>
                </div>
            </div>

            <div class="head-cta">
                <a class="btn ghost" href="{{ route('detail.index', $course->slug) }}">
                    <i class="fa-regular fa-circle-play"></i> Lihat Kursus
                </a>
                <a class="btn brand" href="#comments">
                    <i class="fa-regular fa-message"></i> Diskusi
                </a>
            </div>
        </div>
    </section>

    {{-- ======= LAYOUT ======= --}}
    <main class="lesson-layout container">
        {{-- ======= KIRI: PLAYER + DETAIL ======= --}}
        <section class="lp-left">
            {{-- MEDIA PLAYER --}}
            <div class="media-shell" aria-label="Lesson media">
                @php
                    $media = $lesson->media ?? null;
                    $ext = $media ? strtolower(pathinfo($media, PATHINFO_EXTENSION)) : null;
                    $isVideo = $ext && in_array($ext, ['mp4','mov','avi','mkv','webm']);
                    $isImage = $ext && in_array($ext, ['jpg','jpeg','png','gif','webp']);
                @endphp

                @if ($media && $isVideo)
                    <video class="media" controls oncontextmenu="return false;" controlsList="nodownload" preload="metadata">
                        <source src="{{ asset('storage/' . $media) }}" type="video/{{ $ext === 'mkv' ? 'mp4' : $ext }}" />
                        Browser tidak mendukung video.
                    </video>
                @elseif ($media && $isImage)
                    <img
                        class="media img-protected"
                        src="{{ asset('storage/' . $media) }}"
                        alt="Media untuk {{ $lesson->title ?? 'Lesson' }}"
                        draggable="false"
                        oncontextmenu="return false;"
                    />
                @else
                    <div class="media-empty" role="img" aria-label="Tidak ada media">
                        <i class="fa-solid fa-photo-film"></i>
                        <p>Belum ada media untuk lesson ini.</p>
                    </div>
                @endif
            </div>

            {{-- JUDUL LESSON --}}
            <h2 class="lesson-title">{{ $lesson->title ?? 'Untitled Lesson' }}</h2>

            {{-- META LESSON --}}
            <div class="lesson-meta">
                <span class="meta-item">
                    <i class="fa-solid fa-user-group"></i>
                    @if($course->instructors->isNotEmpty())
                        {{ $course->instructors->pluck('name')->join(', ') }}
                    @else
                        Instruktur
                    @endif
                </span>
                <span class="dot">•</span>
                <span class="meta-item">
                    <i class="fa-regular fa-clock"></i>
                    {{ $lesson?->duration ? gmdate('i:s', $lesson->duration) : '00:00' }}
                </span>
            </div>

            {{-- MINI PROGRESS BAR (KESIMPULAN PROGRES COURSE) --}}
            <div class="mini-progress" aria-label="Progress belajar">
                <div class="bar" aria-hidden="true"><span style="width: {{ $percent }}%"></span></div>
                <div class="mini-progress-row">
                    <small>{{ $percent }}% selesai ({{ $doneCount }}/{{ $totalLessons }} modul)</small>
                    @if($percent >= 100)
                        <small class="done-badge">Selesai 🎉</small>
                    @endif
                </div>
            </div>

            {{-- OVERVIEW --}}
            <article class="lesson-overview">
                <h3>Lesson Overview</h3>
                <div class="overview-body">
                    {!! $lesson->content ?? '<em>Belum ada deskripsi untuk lesson ini.</em>' !!}
                </div>
            </article>

            {{-- TOMBOL PROGRES: "Tandai Selesai" / Navigasi --}}
            <div class="lesson-actions">
                @if(!$isThisLessonDone)
                    <form method="POST" action="{{ route('lesson.complete', $lesson->id) }}" class="la-form">
                        @csrf
                        <button type="submit" class="btn brand la-primary">
                            <i class="fa-regular fa-circle-check"></i>
                            Tandai Selesai
                        </button>
                    </form>
                @else
                    <div class="alert success" role="status">
                        <i class="fa-solid fa-circle-check"></i>
                        Modul ini sudah selesai
                    </div>
                    @if($nextLesson)
                        <a class="btn ghost la-next" href="{{ route('lesson.index', [$course->slug, 'lesson' => $nextLesson->id]) }}">
                            Lanjut Modul Berikutnya →
                        </a>
                    @else
                        <a class="btn ghost la-next" href="{{ route('detail.index', $course->slug) }}">
                            Kembali ke Detail Kursus
                        </a>
                    @endif
                @endif
            </div>

            {{-- KOMENTAR (demo localStorage) --}}
            <section id="comments" class="comment-card" aria-labelledby="comments-title">
                <div class="comment-head">
                    <h3 id="comments-title"><i class="fa-regular fa-message"></i> Komentar</h3>
                    <button id="toggle-comments" type="button" class="btn ghost-sm" aria-expanded="true" aria-controls="comment-wrap">
                        Sembunyikan
                    </button>
                </div>

                <div id="comment-wrap">
                    <form id="comment-form" class="comment-form" autocomplete="off">
                        @csrf
                        <label for="comment-input" class="sr-only">Tambah komentar</label>
                        <textarea id="comment-input" placeholder="Tulis komentar publik..." required></textarea>
                        <div class="form-actions">
                            <button type="submit" class="btn brand-sm">Kirim</button>
                        </div>
                    </form>

                    <p class="judul">Semua Komentar</p>
                    <div id="comment-list" class="comment-list" aria-live="polite"></div>
                </div>
            </section>
        </section>

        {{-- ======= KANAN: PLAYLIST / MODUL ======= --}}
        <aside class="lp-right" aria-label="Daftar modul">
            <div class="playlist-head">
                <h3><i class="fa-regular fa-rectangle-list"></i> Course Modules</h3>
                <span class="count">{{ $orderedLessons->count() }} materi</span>
            </div>

            <ul class="playlist">
                @forelse ($orderedLessons as $item)
                    @php
                        $mext = $item->media ? strtolower(pathinfo($item->media, PATHINFO_EXTENSION)) : null;
                        $mIsVideo = $mext && in_array($mext, ['mp4','mov','avi','mkv','webm']);
                        $mIsImage = $mext && in_array($mext, ['jpg','jpeg','png','gif','webp']);
                        $isActive = $lesson && $item->id === $lesson->id;

                        $itemDone = in_array($item->id, $doneIds);
                    @endphp
                    <li class="pl-item {{ $isActive ? 'active' : '' }}">
                        <a
                            href="{{ route('lesson.index', $course->slug) }}?lesson={{ $item->id }}"
                            class="pl-link"
                            aria-current="{{ $isActive ? 'page' : 'false' }}"
                        >
                            <div class="thumb" aria-hidden="true">
                                @if ($item->media && $mIsVideo)
                                    <video muted preload="metadata" oncontextmenu="return false;" controlsList="nodownload">
                                        <source src="{{ asset('storage/' . $item->media) }}" type="video/{{ $mext === 'mkv' ? 'mp4' : $mext }}" />
                                    </video>
                                @elseif ($item->media && $mIsImage)
                                    <img
                                        src="{{ asset('storage/' . $item->media) }}"
                                        alt=""
                                        class="thumb-img img-protected"
                                        draggable="false"
                                        oncontextmenu="return false;"
                                    />
                                @else
                                    <div class="thumb-empty">🎬</div>
                                @endif
                                @if($isActive)
                                    <span class="now">Sedang diputar</span>
                                @endif
                            </div>
                            <div class="info">
                                <p class="title">
                                    {{ $item->module_name ? $item->module_name . ' · ' : '' }}{{ $item->title }}
                                </p>
                                <div class="row-right">
                                    <span class="duration">{{ $item->duration ? gmdate('i:s', $item->duration) : '00:00' }}</span>
                                    @if($itemDone)
                                        <span class="done-ic" title="Selesai" aria-label="Selesai">✔</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </li>
                @empty
                    <li class="pl-item">
                        <div class="pl-link">
                            <div class="thumb-empty">—</div>
                            <div class="info">
                                <p class="title">Belum ada lesson di course ini.</p>
                            </div>
                        </div>
                    </li>
                @endforelse
            </ul>
        </aside>
    </main>
</div>
@endsection

@push('scripts')
<script>
  // ===== Proteksi dasar media (klik kanan)
  document.addEventListener('contextmenu', function(e) {
    if (e.target.closest('.img-protected, video')) e.preventDefault();
  });
  document.querySelectorAll('.img-protected').forEach(el => el.setAttribute('draggable','false'));

  // ===== Komentar (demo localStorage)
  const form   = document.getElementById('comment-form');
  const input  = document.getElementById('comment-input');
  const list   = document.getElementById('comment-list');
  const wrap   = document.getElementById('comment-wrap');
  const toggle = document.getElementById('toggle-comments');
  const LS_KEY = 'lesson_comments_' + "{{ $course->id }}_{{ $lesson->id }}";

  function addComment(text, announce=false){
    const item = document.createElement('div');
    item.className = 'comment';
    item.innerHTML = `<p>${text}</p>`;
    list.prepend(item);
    if (announce) item.setAttribute('aria-live','polite');
  }
  function loadComments(){
    const saved = JSON.parse(localStorage.getItem(LS_KEY) || '[]');
    saved.forEach(t => addComment(t));
  }
  loadComments();

  form?.addEventListener('submit', (e)=>{
    e.preventDefault();
    const text = input.value.trim();
    if(!text) return;
    const saved = JSON.parse(localStorage.getItem(LS_KEY) || '[]');
    saved.unshift(text);
    localStorage.setItem(LS_KEY, JSON.stringify(saved));
    addComment(text, true);
    input.value = '';
  });

  // ===== Toggle komentar
  toggle?.addEventListener('click', ()=>{
    const open = wrap.style.display !== 'none';
    wrap.style.display = open ? 'none' : '';
    toggle.textContent = open ? 'Tampilkan' : 'Sembunyikan';
    toggle.setAttribute('aria-expanded', String(!open));
  });

  // ===== Scroll active item ke view (playlist)
  const active = document.querySelector('.pl-item.active');
  active?.scrollIntoView({ block: 'nearest', inline: 'nearest' });
</script>
@endpush
