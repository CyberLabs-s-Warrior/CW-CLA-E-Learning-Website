@extends('components.header')

@push('styles')
<link rel="stylesheet" href="{{ asset('client/detail.css') }}">
@endpush

@section('title', 'Learnify - ' . $detailCourse->title)

@section('content')
<main class="content">
    <div class="lesson">

        {{-- Media Slider --}}
        @php
            $mediaArray = is_array($detailCourse->media) ? $detailCourse->media : [$detailCourse->media];
        @endphp

        <div class="media-slider">
            @foreach($mediaArray as $index => $file)
                @php
                    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    $filePath = $file && file_exists(storage_path('app/public/' . $file))
                        ? asset('storage/' . $file)
                        : asset('images/no-image.png');
                @endphp
                <div class="media-slide {{ $index === 0 ? 'active' : '' }}">
                    @if(in_array($ext, ['jpg','jpeg','png','webp']))
                        <img src="{{ $filePath }}" alt="Media" loading="lazy" class="media-item">
                    @elseif(in_array($ext, ['mp4','mov','avi','webm']))
                        <video controls preload="metadata" class="media-item">
                            <source src="{{ $filePath }}" type="video/{{ $ext }}">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        <img src="{{ asset('images/no-image.png') }}" alt="No Media" loading="lazy" class="media-item">
                    @endif
                </div>
            @endforeach

            @if(count($mediaArray) > 1)
                <button class="slider-btn prev" id="prevMedia">&#10094;</button>
                <button class="slider-btn next" id="nextMedia">&#10095;</button>
            @endif
        </div>

        {{-- Title --}}
        <h1 class="section-title">{{ $detailCourse->course->name }}</h1>

        {{-- Description --}}
        <div class="description-box">
            <div class="material-title">Description</div>
            <div>{!! $detailCourse->description !!}</div>
        </div>

        {{-- Modules --}}
        @if(!empty($detailCourse->modules) && is_array($detailCourse->modules))
            <div class="module-box">
                <h2>Course Modules</h2>
                <ul class="module-list">
                    @foreach($detailCourse->modules as $module)
                        <li>{{ $module }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Comment Section --}}
        <div class="comment-section">
            <h2>Comments</h2>
            <form id="comment-form">
                <textarea id="comment-input" placeholder="Add a public comment..." required></textarea>
                <button type="submit">Comment</button>
            </form>
            <p class="judul">Semua Komentar</p>
            <div id="comment-list"></div>
        </div>

        {{-- Navigation --}}
        <a href="{{ route('course.index') }}" class="back-btn">← Back to Courses</a>
        <a href="{{ route('lesson.index', ['courseName' => $detailCourse->course->name]) }}" class="next-btn">Follow Courses →</a>

    </div>
</main>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const slides = document.querySelectorAll('.media-slide');
    const mediaItems = document.querySelectorAll('.media-item');
    let currentIndex = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => slide.classList.toggle('active', i === index));
    }

    document.getElementById('prevMedia')?.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + slides.length) % slides.length;
        showSlide(currentIndex);
    });

    document.getElementById('nextMedia')?.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % slides.length;
        showSlide(currentIndex);
    });

    // Ganti object-fit saat fullscreen
    mediaItems.forEach(item => {
        item.addEventListener('fullscreenchange', () => {
            if (document.fullscreenElement) {
                item.style.objectFit = 'contain';
            } else {
                item.style.objectFit = 'cover';
            }
        });

        // Untuk Safari & vendor prefix
        item.addEventListener('webkitfullscreenchange', () => {
            if (document.webkitFullscreenElement) {
                item.style.objectFit = 'contain';
            } else {
                item.style.objectFit = 'cover';
            }
        });
    });
});
</script>
@endpush
@endsection
