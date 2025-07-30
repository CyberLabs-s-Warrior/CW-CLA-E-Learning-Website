@extends('components.header')
@push('styles')
    <link rel="stylesheet" href="{{ asset('client/course.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
@endpush
@section('title', 'Learnify - Courses')
@section('content')
    <section class="course-page">
        <div class="sidebar">
        <div class="sidebar" data-aos="fade-right">
            <h2>Course</h2>
            <label><input type="checkbox" /> All Courses</label>
            <label><input type="checkbox" /> My Courses</label>
            <label><input type="checkbox" /> Available Courses</label>
            <h2>Category</h2>
            <label><input type="checkbox" /> Web Development</label>
            <label><input type="checkbox" /> Mobile Development</label>
            <label><input type="checkbox" /> Data Science</label>
            <label><input type="checkbox" /> Machine Learning</label>
            <label><input type="checkbox" /> Design</label>

            <h2>Price</h2>
            <label><input type="radio" name="price" /> Free</label>
            <label><input type="radio" name="price" /> Under $50</label>
            <label><input type="radio" name="price" /> $50 - $100</label>
            <label><input type="radio" name="price" /> Over $100</label>

            <h2>Level</h2>
            <label><input type="checkbox" /> Beginner</label>
            <label><input type="checkbox" /> Intermediate</label>
            <label><input type="checkbox" /> Advanced</label>
        </div>

        <div class="courses">
            <h1 data-aos="fade-up">All Courses</h1>
            <p data-aos="fade-up" data-aos-delay="100">Browse our wide selection of online courses</p>
            <div class="course-grid">
                <a class="course-card" href="{{route('detail.index')}}">
                <a class="course-card" href="{{ route('detail.index') }}" data-aos="zoom-in">
                    <img src="https://placehold.co/100x100?text=JS" alt="JavaScript Essentials" />
                    <h3>JavaScript Essentials</h3>
                    <p class="price">$39</p>
                </a>
                <div class="course-card" data-aos="zoom-in" data-aos-delay="50">
                    <img src="https://placehold.co/100x100?text=React" alt="React Development" />
                    <h3>React Development</h3>
                    <p class="price">$39</p>
                </div>
                <div class="course-card" data-aos="zoom-in" data-aos-delay="100">
                    <img src="https://placehold.co/100x100?text=Python" alt="Python for Data Analysis" />
                    <h3>Python for Data Analysis</h3>
                    <p class="price">$29</p>
                </div>
                <div class="course-card" data-aos="zoom-in" data-aos-delay="150">
                    <img src="https://placehold.co/100x100?text=Viz" alt="Data Visualization" />
                    <h3>Data Visualization</h3>
                    <p class="price">$25</p>
                </div>
                <div class="course-card" data-aos="zoom-in" data-aos-delay="200">
                    <img src="https://placehold.co/100x100?text=Figma" alt="Figma for Beginners" />
                    <h3>Figma for Beginners</h3>
                    <p class="price">$19</p>
                </div>
                <div class="course-card" data-aos="zoom-in" data-aos-delay="250">
                    <img src="https://placehold.co/100x100?text=Tensor" alt="Deep Learning with TensorFlow" />
                    <h3>Deep Learning with TensorFlow</h3>
                    <p class="price">$45</p>
                </div>
                <div class="course-card" data-aos="zoom-in" data-aos-delay="300">
                    <img src="https://placehold.co/100x100?text=UX" alt="User Experience Design" />
                    <h3>User Experience Design</h3>
                    <p class="price">$35</p>
                </div>
                <div class="course-card" data-aos="zoom-in" data-aos-delay="350">
                    <img src="https://placehold.co/100x100?text=XD" alt="Adobe XD UI/UX Design" />
                    <h3>Adobe XD UI/UX Design</h3>
                    <p class="price">$25</p>
                </div>
                <div class="course-card" data-aos="zoom-in" data-aos-delay="400">
                    <img src="https://placehold.co/100x100?text=Responsive" alt="Responsive Web Design" />
                    <h3>Responsive Web Design</h3>
                    <p class="price">$35</p>
                </div>
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
    </script>
@endpush
