@extends('components.header')

@push('styles')
    <link rel="stylesheet" href="{{ asset('client/profile.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endpush

@section('title', 'Dashboard - Learnify')

@section('content')
    <main class="dashboard-container">

        <!-- Profile Header -->
        <div class="profile-header">
            <img src="{{ asset('image/avatar.jpg') }}" alt="User Avatar" class="avatar">
            <div class="user-info">
                <h2>Hi, Nugraha 👋</h2>
                <p>Selamat datang kembali! Ayo lanjutkan belajar.</p>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="dashboard-grid">

            <!-- Left Panel -->
            <div class="left-panel">
                <div class="overview-card">
                    <p><i class="fas fa-book-open"></i> Active Courses</p>
                    <h3>3</h3>
                </div>
                <div class="overview-card">
                    <p><i class="fas fa-chart-line"></i> Learning Progress</p>
                    <h3>45%</h3>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 45%"></div>
                    </div>
                </div>

                <div class="greeting-box">
                    <p><i class="fas fa-lightbulb"></i> Tetap semangat belajar!</p>
                    <div class="loading-bar"></div>
                </div>
            </div>

            <!-- Right Panel -->
            <div class="right-panel">
                <h2 class="section-title">Continue Learning</h2>
                <div class="course-grid">
                    <div class="course-card">
                        <div class="icon"><i class="fas fa-code"></i></div>
                        <h3>Programming Basics</h3>
                        <p>Lesson 2 of 8</p>
                        <button>Continue</button>
                    </div>
                    <div class="course-card">
                        <div class="icon"><i class="fas fa-database"></i></div>
                        <h3>Data Science Foundations</h3>
                        <p>Lesson 5 of 12</p>
                        <button>Continue</button>
                    </div>
                    <div class="course-card">
                        <div class="icon"><i class="fas fa-robot"></i></div>
                        <h3>Machine Learning Intro</h3>
                        <p>Lesson 3 of 10</p>
                        <button>Continue</button>
                    </div>
                </div>
            </div>

        </div>
    </main>
    @push('scripts')

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const profileBtn = document.getElementById("profile-btn");
                const dropdown = document.getElementById("dropdown-menu");
                const settingBtn = document.getElementById("setting-btn");
                const settingModal = document.getElementById("setting-modal");
                const settingContent = document.getElementById("setting-content");
                const cancelBtn = document.getElementById("cancel-btn");

                const profileInput = document.getElementById("profile-input");
                const profilePreview = document.getElementById("profile-preview");

                profilePreview.addEventListener("click", () => {
                    profileInput.click();
                });

                profileInput.addEventListener("change", function () {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            profilePreview.src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });

                profileBtn.addEventListener("click", () => {
                    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
                });

                settingBtn.addEventListener("click", () => {
                    settingModal.style.display = "flex";
                    setTimeout(() => {
                        settingContent.style.opacity = "1";
                        settingContent.style.transform = "scale(1)";
                    }, 10);
                    dropdown.style.display = "none";
                });

                cancelBtn.addEventListener("click", () => {
                    settingContent.style.opacity = "0";
                    settingContent.style.transform = "scale(0.9)";
                    setTimeout(() => {
                        settingModal.style.display = "none";
                    }, 200);
                });

                window.addEventListener("click", function (e) {
                    if (!profileBtn.contains(e.target) &&
                        !dropdown.contains(e.target) &&
                        !settingContent.contains(e.target)) {
                        dropdown.style.display = "none";
                    }
                });
            });
        </script>
    @endpush
@endsection