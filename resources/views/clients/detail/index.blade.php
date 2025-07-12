@extends('components.header')
@push('styles')
    <link rel="stylesheet" href="{{ asset('client/detail.css') }}">
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
                <li>1. Introduction to JavaScript</li>
                <li>2. Variables & Data Types</li>
                <li>3. Functions and Scope</li>
                <li>4. DOM Manipulation</li>
            </ul>

            <div class="comment-section">
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
