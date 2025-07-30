@extends('components.header')
@push('styles')
    <link rel="stylesheet" href="{{ asset('client/detail.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
@endpush
@section('title', 'Learnify - Courses')
@section('content')
    <main class="content">
        <div class="lesson">
            <div class="hero-img">
                <img src="https://images.ctfassets.net/piwi0eufbb2g/4k3m7B1tegAEtCfQ3XJP13/eea1eae6fcaf7099e20cf7f41d5201b8/What_is_a_Callback_Function_in_JavaScript.jpg?w=1200&h=630"
                    alt="JavaScript Essentials" />
            </div>
            <h1 class="section-title">JavaScript Essentials</h1>

            <h2 class="material-title">Introduction</h2>
            <p>
            <div class="hero-img" data-aos="zoom-in">
                <img src="https://images.ctfassets.net/piwi0eufbb2g/4k3m7B1tegAEtCfQ3XJP13/eea1eae6fcaf7099e20cf7f41d5201b8/What_is_a_Callback_Function_in_JavaScript.jpg?w=1200&h=630"
                    alt="JavaScript Essentials" />
            </div>
            <h1 class="section-title" data-aos="fade-up">JavaScript Essentials</h1>

            <h2 class="material-title" data-aos="fade-up" data-aos-delay="100">Introduction</h2>
            <p data-aos="fade-up" data-aos-delay="200">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam illum consectetur aperiam quidem qui?
                Laudantium minus facere commodi autem maxime, rem illum repudiandae distinctio similique temporibus nulla,
                velit sapiente nihil perspiciatis officiis. Minima tempora porro facilis suscipit nemo. Praesentium iste
                assumenda architecto similique totam ad, illo quasi numquam iusto quos alias facere debitis incidunt sint
                accusantium perferendis laborum! Sit quisquam dicta alias, excepturi sunt vero animi? Sunt similique eaque
                odit iste ex saepe temporibus eius unde iusto necessitatibus esse deleniti veritatis ullam dolorem ab
                praesentium repellat, atque quibusdam pariatur minima aut corporis totam odio? Exercitationem iusto saepe
                quidem explicabo at.
            </p>

            <h2>Course Modules</h2>
            <ul class="module-list">
            <h2 data-aos="fade-up" data-aos-delay="300">Course Modules</h2>
            <ul class="module-list" data-aos="fade-up" data-aos-delay="400">
                <li>1. Introduction to JavaScript</li>
                <li>2. Variables & Data Types</li>
                <li>3. Functions and Scope</li>
                <li>4. DOM Manipulation</li>
            </ul>
            <div class="comment-section">
            <div class="comment-section" data-aos="fade-up" data-aos-delay="500">
                <h2>Comments</h2>
                <form id="comment-form">
                    <textarea id="comment-input" placeholder="Add a public comment..." required></textarea>
                    <button type="submit">Comment</button>
                </form>
                <p class="judul">Semua Komentar</p>
                <div id="comment-list">
                    <!-- Komentar akan muncul di sini -->
                </div>
            </div>
            <a href="{{ route('course.index') }}" class="back-btn">← Back to Courses</a>
            <a href="{{ route('lesson.index') }}" class="next-btn">Follow Courses →</a>
        </div>
    </main>
    @push('scripts')
            <a href="{{ route('course.index') }}" class="back-btn" data-aos="fade-right" data-aos-delay="600">← Back to Courses</a>
            <a href="{{ route('lesson.index') }}" class="next-btn" data-aos="fade-left" data-aos-delay="600">Follow Courses →</a>
        </div>
    </main>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
        <script>
            AOS.init({
                duration: 800,
                once: true
            });
        </script>
        <script>
            const form = document.getElementById("comment-form");
            const input = document.getElementById("comment-input");
            const commentList = document.getElementById("comment-list");

            // Load komentar dari localStorage
            window.onload = function() {
                const saved = JSON.parse(localStorage.getItem("comments") || "[]");
                saved.forEach((text, index) => addComment(text, index));
            };

            form.addEventListener("submit", function(e) {
                e.preventDefault();
                const text = input.value.trim();
                if (text !== "") {
                    const saved = JSON.parse(localStorage.getItem("comments") || "[]");
                    saved.unshift(text);
                    localStorage.setItem("comments", JSON.stringify(saved));
                    addComment(text, 0);
                    input.value = "";
                }
            });

            function addComment(text, index) {
                const div = document.createElement("div");
                div.classList.add("comment");

                const p = document.createElement("p");
                p.textContent = text;

                const del = document.createElement("button");
                del.textContent = "Hapus";
                del.className = "delete";
                del.onclick = function() {
                    deleteComment(index);
                };

                div.appendChild(p);
                div.appendChild(del);
                commentList.prepend(div);
            }

            function deleteComment(index) {
                let saved = JSON.parse(localStorage.getItem("comments") || "[]");
                saved.splice(index, 1);
                localStorage.setItem("comments", JSON.stringify(saved));
                refreshComments();
            }

            function refreshComments() {
                commentList.innerHTML = "";
                const saved = JSON.parse(localStorage.getItem("comments") || "[]");
                saved.forEach((text, index) => addComment(text, index));
            }
        </script>
    @endpush
@endsection
