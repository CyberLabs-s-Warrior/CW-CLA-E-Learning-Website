@extends('layouts.student')

@push('styles')
    <link rel="stylesheet" href="{{ asset('client/lesson.css') }}">
@endpush

@section('title', 'Learnify - Lessons of ' . $course->title)

@section('content')
    <main class="main-layout">
        {{-- BAGIAN KIRI: MEDIA PLAYER + DETAIL --}}
        <div class="left-content">
            {{-- MEDIA PLAYER --}}
            <div class="media-container">
                @if ($lesson && $lesson->media)
                    @php
                        $ext = strtolower(pathinfo($lesson->media, PATHINFO_EXTENSION));
                    @endphp

                    @if (in_array($ext, ['mp4', 'mov', 'avi']))
                        <video controls>
                            <source src="{{ asset('storage/' . $lesson->media) }}" type="video/mp4" />
                            Browser tidak mendukung video.
                        </video>
                    @elseif (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                        <img src="{{ asset('storage/' . $lesson->media) }}" alt="Lesson Media" class="lesson-image" />
                    @else
                        <div class="no-video">
                            <p class="text-muted">Media tidak dikenali.</p>
                        </div>
                    @endif
                @else
                    <div class="no-video">
                        <p class="text-muted">Belum ada media untuk lesson ini.</p>
                    </div>
                @endif
            </div>

            {{-- JUDUL LESSON --}}
            <h1 class="material-title">
                {{ $lesson->title ?? 'Untitled Lesson' }}
            </h1>

            {{-- META LESSON --}}
            <div class="lesson-meta">
                <span>
                    @if($course->instructors->isNotEmpty())
                        {{ $course->instructors->pluck('name')->join(', ') }}
                    @else
                        Instruktur
                    @endif
                </span>
                •
                <span>{{ gmdate('i:s', $lesson->duration ?? 0) }}</span>
            </div>

            {{-- OVERVIEW --}}
            <h2>Lesson Overview</h2>
            <p>
                {!! $lesson->content ?? '<em>Belum ada deskripsi untuk lesson ini.</em>' !!}
            </p>

            {{-- KOMENTAR --}}
            <div class="comment-section">
                <h2>Comments</h2>
                <form id="comment-form">
                    <textarea id="comment-input" placeholder="Add a public comment..." required></textarea>
                    <button type="submit">Comment</button>
                </form>
                <p class="judul">Semua Komentar</p>
                <div id="comment-list"></div>
            </div>
        </div>

        {{-- BAGIAN KANAN: MODULE LIST --}}
        <aside class="right-sidebar">
            <h3>Course Modules</h3>
            <ul class="module-list">
                @forelse ($course->lessons as $item)
                    <li class="module-item {{ $item->id === $lesson->id ? 'active' : '' }}">
                        <a href="{{ route('lesson.index', $course->slug) }}?lesson={{ $item->id }}">
                            <div class="thumb">
                                @php
                                    $ext = strtolower(pathinfo($item->media, PATHINFO_EXTENSION));
                                @endphp
                                @if ($item->media && in_array($ext, ['mp4', 'mov', 'avi']))
                                    <video muted preload="metadata">
                                        <source src="{{ asset('storage/' . $item->media) }}" type="video/mp4" />
                                    </video>
                                @elseif ($item->media && in_array($ext, ['jpg','jpeg','png','gif','webp']))
                                    <img src="{{ asset('storage/' . $item->media) }}" alt="thumb" class="thumb-img" />
                                @else
                                    <div class="thumb-placeholder">🎬</div>
                                @endif
                            </div>
                            <div class="module-info">
                                <p class="module-title">{{ $item->title }}</p>
                                <span class="module-duration">{{ gmdate('i:s', $item->duration ?? 0) }}</span>
                            </div>
                        </a>
                    </li>
                @empty
                    <li class="module-item">
                        <p class="text-muted">Belum ada lesson di course ini.</p>
                    </li>
                @endforelse
            </ul>
        </aside>
    </main>
@endsection

@push('scripts')
    <script>
        const form = document.getElementById("comment-form");
        const input = document.getElementById("comment-input");
        const commentList = document.getElementById("comment-list");

        window.onload = function () {
            const saved = JSON.parse(localStorage.getItem("comments") || "[]");
            saved.forEach((text) => addComment(text));
        };

        form.addEventListener("submit", function (e) {
            e.preventDefault();
            const text = input.value.trim();
            if (text !== "") {
                const saved = JSON.parse(localStorage.getItem("comments") || "[]");
                saved.unshift(text);
                localStorage.setItem("comments", JSON.stringify(saved));
                addComment(text);
                input.value = "";
            }
        });

        function addComment(text) {
            const div = document.createElement("div");
            div.classList.add("comment");

            const p = document.createElement("p");
            p.textContent = text;

            div.appendChild(p);
            commentList.prepend(div);
        }
    </script>
@endpush