@extends('layouts.student')

@push('styles')
    <link rel="stylesheet" href="{{ asset('client/course.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
@endpush

@section('title', 'Learnify - Courses')

@section('content')
    <section class="course-page">
        {{-- FORM FILTER --}}
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
                    <a class="course-card" href="{{ route('detail.index', urlencode($course->name)) }}" data-aos="zoom-in"
                        data-aos-delay="{{ $index * 50 }}">
                        <img src="{{ asset('storage/' . $course->img) }}" alt="{{ $course->name }}" />
                        <h3>{{ $course->name }}</h3>
                        <p class="price">${{ number_format($course->price, 2) }}</p>
                    </a>
                @empty
                    <p>No courses found for the selected filters.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });

        // Logika toggle radio (klik lagi untuk unselect)
        document.querySelectorAll('#filterForm input[type="radio"]').forEach(function(radio) {
            radio.addEventListener('mousedown', function(e) {
                if (this.checked) {
                    this.wasChecked = true;
                } else {
                    this.wasChecked = false;
                }
            });

            radio.addEventListener('click', function(e) {
                if (this.wasChecked) {
                    e.preventDefault();
                    this.checked = false;
                    this.wasChecked = false;
                    document.getElementById('filterForm').submit(); // auto submit saat unselect
                }
            });
        });

        // Auto submit saat filter berubah
        document.querySelectorAll('#filterForm input').forEach(input => {
            input.addEventListener('change', () => {
                document.getElementById('filterForm').submit();
            });
        });
    </script>
@endpush
