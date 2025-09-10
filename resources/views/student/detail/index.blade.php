@extends('layouts.student')

@push('styles')
    <link rel="stylesheet" href="{{ asset('client/detail.css') }}">
@endpush

@section('content')
    <header class="hero container">
        <div class="hero-media">
            <div class="img-protected"
                 style="background-image: url('{{ $course->img ? asset('storage/' . $course->img) : 'https://via.placeholder.com/600x300' }}');"
                 role="img"
                 aria-label="{{ $course->name }}">
            </div>
        </div>

        <div class="hero-info">
            <h1 class="course-title">{{ $course->name }}</h1>

            <div class="rating-line">
                <div class="stars" aria-label="Rating {{ number_format($course->reviews_avg_rating, 1) }} dari 5">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="{{ $i <= round($course->reviews_avg_rating) ? 'fa-solid fa-star' : 'fa-regular fa-star' }}"></i>
                    @endfor
                </div>
                <span class="rating-number">{{ number_format($course->reviews_avg_rating, 1) }}</span>
                <span class="divider">•</span>
                <span class="reviews">({{ $course->reviews->count() }} ulasan)</span>
            </div>

            <div class="meta-line">
                <i class="fa-solid fa-user-group"></i>
                <span>{{ $course->students_count }} orang sudah ikut</span>
            </div>

            <a href="{{ route('lesson.index', $course->slug) }}" class="btn pay-btn" aria-label="Mulai Belajar">
                <i class="fa-solid fa-play"></i>
                {{ $course->priceRange->name ?? 'Free' }}
            </a>

            <ul class="quick-facts">
                <li><i class="fa-regular fa-clock"></i> {{ $course->formatted_duration }}</li>
                <li><i class="fa-solid fa-signal"></i> Tingkat: {{ $course->level->level }}</li>
                <li><i class="fa-solid fa-certificate"></i> Sertifikat kelulusan</li>
            </ul>
        </div>
    </header>

    <!-- ================= TABS ================= -->
    <section class="tabs container">
        <input type="radio" id="tab-tentang" name="tabs" checked />
        <input type="radio" id="tab-modul" name="tabs" />
        <input type="radio" id="tab-mentor" name="tabs" />
        <input type="radio" id="tab-review" name="tabs" />

        <nav class="tab-nav">
            <label for="tab-tentang">Tentang Kursus</label>
            <label for="tab-modul">Modul</label>
            <label for="tab-mentor">Mentor</label>
            <label for="tab-review">Review</label>
            <span class="active-pill"></span>
        </nav>

        <div class="tab-panels">
            <!-- Tentang -->
            <article id="panel-tentang" class="tab-panel">
                <h2>Apa yang akan kamu pelajari</h2>
                <p>{!! $course->detail->description !!}</p>
                @if(!empty($course->detail->outcomes))
                    <div>{!! $course->detail->outcomes !!}</div>
                @endif
            </article>

            <!-- Modul -->
            <article id="panel-modul" class="tab-panel">
                <h2>Daftar Modul</h2>
                @php
                    $grouped = $course->lessons->groupBy('module_name');
                @endphp

                @forelse ($grouped as $module => $lessons)
                    <details>
                        <summary>{{ $module }}</summary>
                        <ul>
                            @foreach ($lessons as $lesson)
                                <li>
                                    {{ $lesson->title }} ({{ $lesson->formatted_duration }})
                                </li>
                            @endforeach
                        </ul>
                    </details>
                @empty
                    <p>Belum ada modul.</p>
                @endforelse
            </article>

            <!-- Mentor -->
            <article id="panel-mentor" class="tab-panel">
                <h2>Mentor</h2>
                <div class="mentor-grid">
                    @forelse ($course->detail?->instructors as $mentor)
                        <div class="mentor-card">
                            <div class="img-protected mentor-avatar"
                                 style="background-image: url('{{ $mentor->avatar_path ? asset('storage/' . $mentor->avatar_path) : 'https://via.placeholder.com/200' }}');"
                                 role="img"
                                 aria-label="{{ $mentor->user->name }}">
                            </div>
                            <div class="mentor-info">
                                <h3>{{ $mentor->user->name }}</h3>
                                <p class="role">{{ $mentor->primary_skill ?? '-' }}</p>
                                <p class="bio">{{ $mentor->short_bio ?? '-' }}</p>
                                <div class="socials">
                                    @if($mentor->github_url)
                                        <a href="{{ $mentor->github_url }}" target="_blank" aria-label="GitHub">
                                            <i class="fa-brands fa-github"></i>
                                        </a>
                                    @endif
                                    @if($mentor->linkedin_url)
                                        <a href="{{ $mentor->linkedin_url }}" target="_blank" aria-label="LinkedIn">
                                            <i class="fa-brands fa-linkedin"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>Belum ada mentor yang ditambahkan.</p>
                    @endforelse
                </div>
            </article>

            <!-- Review -->
            <article id="panel-review" class="tab-panel">
                <div class="review-header">
                    <div class="avg">
                        <div class="avg-score">{{ number_format($course->reviews_avg_rating, 1) }}</div>
                        <div class="avg-stars">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= round($course->reviews_avg_rating) ? 'fa-solid fa-star' : 'fa-regular fa-star' }}"></i>
                            @endfor
                        </div>
                        <p class="count">({{ $course->reviews->count() }} ulasan)</p>
                    </div>
                </div>

                <ul class="review-list">
                    @forelse ($course->reviews as $review)
                        <li class="review-item">
                            <div class="img-protected review-avatar"
                                 style="background-image: url('{{ $review->user->avatar ?? 'https://i.pravatar.cc/80' }}');"
                                 role="img"
                                 aria-label="{{ $review->user->name }}">
                            </div>
                            <div>
                                <div class="name">
                                    {{ $review->user->name }}
                                    <span class="stars-inline">
                                        @for ($i = 1; $i <= 5; $i++)
                                            {{ $i <= $review->rating ? '★' : '☆' }}
                                        @endfor
                                    </span>
                                </div>
                                <p>{{ $review->comment }}</p>
                            </div>
                        </li>
                    @empty
                        <p>Belum ada review.</p>
                    @endforelse
                </ul>
            </article>
        </div>
    </section>

    <!-- ================= REKOMENDASI ================= -->
    <section class="container recos">
        <h2>Orang lain juga kursus di sini</h2>
        <div class="reco-row">
            @forelse ($relatedCourses as $rel)
                <a class="reco-card" href="{{ route('detail.index', $rel->slug) }}">
                    <div class="img-protected reco-thumb"
                         style="background-image: url('{{ $rel->img ? asset('storage/' . $rel->img) : 'https://via.placeholder.com/400x200' }}');"
                         role="img"
                         aria-label="{{ $rel->name }}">
                    </div>
                    <div class="reco-body">
                        <h3>{{ $rel->name }}</h3>
                        <div class="mini">
                            <span class="stars-mini">
                                @for ($i = 1; $i <= 5; $i++)
                                    {{ $i <= round($rel->reviews_avg_rating) ? '★' : '☆' }}
                                @endfor
                            </span>
                            <span class="price">{{ $rel->priceRange->name ?? 'Gratis' }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <p>Tidak ada rekomendasi.</p>
            @endforelse
        </div>
    </section>

    <footer class="container footer">
        <p>© {{ date('Y') }} Tasty Academy. Semua hak dilindungi.</p>
    </footer>
@endsection
