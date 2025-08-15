@extends('components.header')

@push('styles')
    <link rel="stylesheet" href="{{ asset('client/lesson.css') }}">
@endpush

@section('title', 'Learnify - Lessons of '.$course->name)

@section('content')
<main class="content">
    <div class="lesson">
        <h2 class="section-title">Course Modules</h2>
        <select class="module-dropdown">
            @foreach($lessons as $lesson)
                <option value="{{ $lesson->id }}">{{ $lesson->module_name }}</option>
            @endforeach
        </select>

        <h1 class="material-title" id="material-title">
            {{ $lessons->first()->title ?? 'No Lesson Selected' }}
        </h1>

        <div class="video-lesson" id="video-lesson">
            @if($lessons->first()?->media)
                @php
                    $mediaPath = 'storage/' . $lessons->first()->media;
                    $extension = strtolower(pathinfo($mediaPath, PATHINFO_EXTENSION));
                    $isVideo = in_array($extension, ['mp4', 'webm', 'ogg']);
                @endphp

                @if($isVideo)
                    <video controls>
                        <source src="{{ asset($mediaPath) }}" type="video/{{ $extension }}" />
                        Your browser does not support the video tag.
                    </video>
                @else
                    <img src="{{ asset($mediaPath) }}" alt="Lesson Media">
                @endif
            @else
                <p>No media available for this lesson.</p>
            @endif
        </div>

        <h2>Lesson Overview</h2>
        <div id="lesson-content">
            {!! $lessons->first()->content ?? '<p>No content available.</p>' !!}
        </div>

        <a href="{{ route('detail.index', urlencode($course->name)) }}" class="back-btn">← Back to Courses</a>
    </div>
</main>

@push('scripts')
<script>
    const lessons = @json($lessons);
    const moduleDropdown = document.querySelector('.module-dropdown');
    const materialTitle = document.getElementById('material-title');
    const videoLesson = document.getElementById('video-lesson');
    const lessonContent = document.getElementById('lesson-content');

    moduleDropdown.addEventListener('change', function() {
        const selectedId = parseInt(this.value);
        const lesson = lessons.find(l => l.id === selectedId);

        materialTitle.textContent = lesson.title;
        lessonContent.innerHTML = lesson.content;

        if (lesson.media) {
            const ext = lesson.media.split('.').pop().toLowerCase();
            const isVideo = ['mp4', 'webm', 'ogg'].includes(ext);

            if (isVideo) {
                videoLesson.innerHTML = `
                    <video controls>
                        <source src="/storage/${lesson.media}" type="video/${ext}" />
                        Your browser does not support the video tag.
                    </video>
                `;
            } else {
                videoLesson.innerHTML = `
                    <img src="/storage/${lesson.media}" alt="Lesson Media">
                `;
            }
        } else {
            videoLesson.innerHTML = `<p>No media available for this lesson.</p>`;
        }
    });
</script>
@endpush
@endsection
