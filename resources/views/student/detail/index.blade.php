@extends('layouts.student')

@push('styles')
    <link rel="stylesheet" href="{{ asset('client/detail.css') }}">
@endpush

@section('content')
    @php
        $avgFloat = (float) ($course->reviews_avg_rating ?? 0);
        $avgRounded = round($avgFloat);
        $avgLabel = number_format($avgFloat, 1);
        $students = (int) ($course->students_count ?? 0);
    @endphp

    <div class="detail-page">
        <!-- HERO -->
        <header class="hero container" aria-labelledby="course-title">
            <div class="hero-media" aria-hidden="true">
                <div class="img-protected"
                    style="background-image: url('{{ $course->img ? asset('storage/' . $course->img) : 'https://via.placeholder.com/1200x600?text=Course+Cover' }}');">
                </div>
            </div>

            <div class="hero-info">
                <h1 id="course-title" class="course-title">{{ $course->name }}</h1>

                <div class="rating-line" aria-label="Rating rata-rata {{ $avgLabel }} dari 5">
                    <div class="stars" aria-hidden="true">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="{{ $i <= $avgRounded ? 'fa-solid fa-star' : 'fa-regular fa-star' }}"></i>
                        @endfor
                    </div>
                    <span class="rating-number">{{ $avgLabel }}</span>
                    <span class="divider">•</span>
                    <span class="reviews">({{ $course->reviews->count() }} ulasan)</span>
                </div>

                <div class="meta-line">
                    {{-- <i class="fa-solid fa-user-group" aria-hidden="true"></i> --}}
                    {{-- <span>{{ $students }} orang sudah ikut</span> --}}
                </div>

                @php
                    $transaction = \App\Models\Transaction::where('user_id', auth()->id())
                        ->where('course_id', $course->id)
                        ->where('status', 'paid')
                        ->first();
                @endphp

                @if ($transaction)
                    <a href="{{ route('lesson.index', $course->slug) }}" class="btn pay-btn"
                        aria-label="Mulai belajar: {{ $course->name }}">
                        <i class="fa-solid fa-play" aria-hidden="true">
                        </i>
                        Mulai Belajar : {{ $course->name ?? 'Kursus' }}
                    </a>
                @else
                    <form action="{{ route('checkout.start', ['course' => $course->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn pay-btn">
                            <i class="fa-solid fa-play"></i>
                            Rp. {{ $course->price ?? 'Free' }}
                        </button>
                    </form>
                @endif


                <ul class="quick-facts" aria-label="Informasi singkat kursus">
                    <li><i class="fa-regular fa-clock" aria-hidden="true"></i> {{ $course->formatted_duration }}</li>
                    <li><i class="fa-solid fa-signal" aria-hidden="true"></i> Tingkat: {{ $course->level?->level ?? '-' }}
                    </li>
                    <li><i class="fa-solid fa-certificate" aria-hidden="true"></i> Sertifikat kelulusan</li>
                </ul>
            </div>
        </header>

        <!-- TABS -->
        <section class="tabs container" aria-label="Konten kursus">
            <input type="radio" id="tab-tentang" name="tabs" checked />
            <input type="radio" id="tab-modul" name="tabs" />
            <input type="radio" id="tab-mentor" name="tabs" />
            <input type="radio" id="tab-review" name="tabs" />

            <nav class="tab-nav" role="tablist" aria-label="Navigasi tab">
                <label for="tab-tentang" role="tab" aria-controls="panel-tentang" tabindex="0">Tentang Kursus</label>
                <label for="tab-modul" role="tab" aria-controls="panel-modul" tabindex="0">Modul</label>
                <label for="tab-mentor" role="tab" aria-controls="panel-mentor" tabindex="0">Mentor</label>
                <label for="tab-review" role="tab" aria-controls="panel-review" tabindex="0">Review</label>
                <span class="active-pill" aria-hidden="true"></span>
            </nav>

            <div class="tab-panels">
                <!-- TENTANG -->
                <article id="panel-tentang" class="tab-panel" role="tabpanel" aria-labelledby="tab-tentang">
                    <h2>Apa yang akan kamu pelajari</h2>
                    {!! $course->detail?->description ?? '<p class="muted">Belum ada deskripsi.</p>' !!}
                    @if (!empty($course->detail?->outcomes))
                        <div class="outcomes">{!! $course->detail->outcomes !!}</div>
                    @endif
                </article>

                <!-- MODUL -->
                <article id="panel-modul" class="tab-panel" role="tabpanel" aria-labelledby="tab-modul">
                    <h2>Daftar Modul</h2>
                    @php
                        $grouped = $course->lessons->groupBy(fn($l) => $l->module_name ?: 'Modul');
                    @endphp

                    @forelse ($grouped as $module => $lessons)
                        <details class="dp-accordion">
                            <summary>
                                <span class="mod-title">{{ $module }}</span>
                                <span class="count">{{ $lessons->count() }} materi</span>
                            </summary>
                            <ul class="module-list">
                                @foreach ($lessons as $lesson)
                                    <li>
                                        <i class="fa-regular fa-circle-play" aria-hidden="true"></i>
                                        <span class="ttl">{{ $lesson->title }}</span>
                                        <em class="dur">{{ $lesson->formatted_duration }}</em>
                                    </li>
                                @endforeach
                            </ul>
                        </details>
                    @empty
                        <p class="muted">Belum ada modul.</p>
                    @endforelse
                </article>

                <!-- MENTOR -->
                <article id="panel-mentor" class="tab-panel" role="tabpanel" aria-labelledby="tab-mentor">
                    <h2>Mentor</h2>
                    <div class="mentor-grid">
                        @forelse ($course->detail?->instructors as $mentor)
                            <div class="mentor-card">
                                <div class="img-protected mentor-avatar"
                                    style="background-image: url('{{ $mentor->avatar_path ? asset('storage/' . $mentor->avatar_path) : 'https://via.placeholder.com/240x240?text=Mentor' }}');">
                                </div>
                                <div class="mentor-info">
                                    <h3>{{ $mentor->user->name }}</h3>
                                    <p class="role">{{ $mentor->primary_skill ?? '-' }}</p>
                                    <p class="bio">{{ $mentor->short_bio ?? '-' }}</p>
                                    <div class="links" aria-label="Sosial">
                                        @if ($mentor->github_url)
                                            <a href="{{ $mentor->github_url }}" target="_blank" rel="noopener"
                                                aria-label="GitHub">
                                                <i class="fa-brands fa-github"></i>
                                            </a>
                                        @endif
                                        @if ($mentor->linkedin_url)
                                            <a href="{{ $mentor->linkedin_url }}" target="_blank" rel="noopener"
                                                aria-label="LinkedIn">
                                                <i class="fa-brands fa-linkedin"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="muted">Belum ada mentor yang ditambahkan.</p>
                        @endforelse
                    </div>
                </article>

                <!-- REVIEW -->
                <article id="panel-review" class="tab-panel" role="tabpanel" aria-labelledby="tab-review">
                    <div class="review-header card-soft">
                        <div class="avg">
                            <div class="avg-score">{{ $avgLabel }}</div>
                            <div class="avg-stars" aria-hidden="true">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= $avgRounded ? 'fa-solid fa-star' : 'fa-regular fa-star' }}"></i>
                                @endfor
                            </div>
                            <p class="count">({{ $course->reviews->count() }} ulasan)</p>
                        </div>
                    </div>

                    <ul class="review-list">
                        @forelse ($course->reviews as $review)
                            <li class="review-item card-soft">
                                <div class="img-protected review-avatar"
                                    style="background-image: url('{{ $review->user->avatar ?? 'https://i.pravatar.cc/80' }}');">
                                </div>
                                <div class="review-body">
                                    <div class="name">
                                        {{ $review->user->name }}
                                        <span class="stars-inline" aria-hidden="true">
                                            @for ($i = 1; $i <= 5; $i++)
                                                {{ $i <= (int) $review->rating ? '★' : '☆' }}
                                            @endfor
                                        </span>
                                    </div>
                                    <p class="comment">{{ $review->comment }}</p>
                                </div>
                            </li>
                        @empty
                            <p class="muted">Belum ada review.</p>
                        @endforelse
                    </ul>
                </article>
            </div>
        </section>

        <!-- REKOMENDASI -->
        <section class="container recos" aria-label="Rekomendasi kursus">
            <h2>Orang lain juga kursus di sini</h2>
            <div class="reco-row">
                @forelse ($relatedCourses as $rel)
                    <a class="reco-card card-hover" href="{{ route('detail.index', $rel->slug) }}"
                        aria-label="Lihat {{ $rel->name }}">
                        <div class="img-protected reco-thumb"
                            style="background-image: url('{{ $rel->img ? asset('storage/' . $rel->img) : 'https://via.placeholder.com/600x340?text=Course' }}');">
                        </div>
                        <div class="reco-body">
                            <h3>{{ $rel->name }}</h3>
                            <div class="mini">
                                <span class="stars-mini" aria-hidden="true">
                                    @php $rr = round((float)($rel->reviews_avg_rating ?? 0)); @endphp
                                    @for ($i = 1; $i <= 5; $i++)
                                        {{ $i <= $rr ? '★' : '☆' }}
                                    @endfor
                                </span>
                                <span class="price">{{ $rel->priceRange->name ?? 'Gratis' }}</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="muted">Tidak ada rekomendasi.</p>
                @endforelse
            </div>
        </section>
    </div>

@endsection
