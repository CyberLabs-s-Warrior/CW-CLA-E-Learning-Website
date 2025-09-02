@extends('layouts.student')

@push('styles')
    <link rel="stylesheet" href="{{ asset('client/course.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endpush

@section('title', 'Learnify - Courses')

@section('content')
<section class="course-page">
    {{-- SIDEBAR FILTER --}}
    <form method="GET" action="{{ route('course.index') }}" class="sidebar" data-aos="fade-right" id="filterForm">
        <h2>Course</h2>
        <label>
            <input type="checkbox" name="all" value="1" {{ request('all') ? 'checked' : '' }}> All Courses
        </label>
        <label>
            <input type="checkbox" name="my" value="1" {{ request('my') ? 'checked' : '' }}> My Courses
        </label>
        <label>
            <input type="checkbox" name="available" value="1" {{ request('available') ? 'checked' : '' }}> Available Courses
        </label>

        {{-- CATEGORY FILTER --}}
        <h2>Category</h2>
        @foreach($categories as $category)
            <label>
                <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                    {{ in_array($category->id, request()->input('categories', [])) ? 'checked' : '' }}>
                {{ $category->category }}
            </label>
        @endforeach

        {{-- PRICE FILTER --}}
        <h2>Price</h2>
        <label>
            <input type="radio" name="price" value=""
                {{ request('price') === null || request('price') === '' ? 'checked' : '' }}> All Prices
        </label>
        <label>
            <input type="radio" name="price" value="free"
                {{ request('price') === 'free' ? 'checked' : '' }}> Free
        </label>
        @foreach($priceRanges as $price)
            <label>
                <input type="radio" name="price" value="{{ $price->id }}"
                    {{ request('price') == $price->id ? 'checked' : '' }}>
                ${{ $price->min_price }} - ${{ $price->max_price }}
            </label>
        @endforeach

        {{-- LEVEL FILTER --}}
        <h2>Level</h2>
        <label>
            <input type="radio" name="level" value=""
                {{ request('level') === null || request('level') === '' ? 'checked' : '' }}> All Levels
        </label>
        @foreach($levels as $level)
            <label>
                <input type="radio" name="level" value="{{ $level->id }}"
                    {{ request('level') == $level->id ? 'checked' : '' }}>
                {{ $level->level }}
            </label>
        @endforeach
    </form>

    {{-- COURSE LIST --}}
    <div class="courses">
        <h1 data-aos="fade-up">All Courses</h1>
        <p data-aos="fade-up" data-aos-delay="100">Browse our wide selection of online courses</p>
        <div class="course-grid">
            @forelse($courses as $index => $course)
                <a class="course-card" href="{{ route('detail.index', $course->slug) }}" data-aos="zoom-in"
                    data-aos-delay="{{ $index * 50 }}">
                    
                    {{-- Gambar --}}
                    <div class="card-image">
                        <img src="{{ asset('storage/' . $course->img) }}" alt="{{ $course->name }}" />
                    </div>

                    <div class="card-body">
                        {{-- Judul + kategori --}}
                        <h3>{{ $course->name }}</h3>
                        <span class="category">{{ $course->category->category ?? '-' }}</span>

                        {{-- Harga --}}
                        <p class="price">
                            @if($course->price == 0)
                                Free
                            @else
                                ${{ number_format($course->price, 2) }}
                            @endif
                        </p>

                        {{-- Durasi & modul --}}
                        <div class="info">
                            <span><i class="fa-regular fa-clock"></i> {{ $course->formatted_duration }}</span>
                            <span><i class="fa-solid fa-book"></i> {{ $course->lessons_count ?? 0 }} Modul</span>
                        </div>

                        {{-- Rating + siswa --}}
                        <div class="meta">
                            <div class="rating">
                                @php
                                    $rating = round($course->reviews_avg_rating ?? 0, 1);
                                    $fullStars = floor($rating);
                                    $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
                                    $emptyStars = 5 - $fullStars - $halfStar;
                                @endphp

                                {{-- full star --}}
                                @for ($i = 0; $i < $fullStars; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor

                                {{-- half star --}}
                                @if ($halfStar)
                                    <i class="fas fa-star-half-alt"></i>
                                @endif

                                {{-- empty star --}}
                                @for ($i = 0; $i < $emptyStars; $i++)
                                    <i class="far fa-star"></i>
                                @endfor

                                <span class="rating-text">({{ $rating }})</span>
                            </div>
                            <div class="students">
                                <i class="fa-solid fa-users"></i> {{ $course->students_count ?? 0 }}
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <p>No courses found for the selected filters.</p>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="pagination">
            {{ $courses->links() }}
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true });

    // Auto submit filter
    document.querySelectorAll('#filterForm input').forEach(input => {
        input.addEventListener('change', () => {
            document.getElementById('filterForm').submit();
        });
    });
</script>
@endpush
