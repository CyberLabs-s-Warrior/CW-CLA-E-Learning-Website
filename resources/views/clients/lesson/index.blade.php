@extends('components.header')
@push('styles')
    <link rel="stylesheet" href="{{ asset('client/lesson.css') }}">
@endpush
@section('title', 'Learnify - Courses')
@section('content')
    <main class="content">
        <div class="lesson">
            <h2 class="section-title">Course Modules</h2>
            <select class="module-dropdown">
                <option selected>Lesson 1: Introduction</option>
            </select>

            <h1 class="material-title">Introduction</h1>

            <div class="video-lesson">
                <video controls>
                    <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4" />
                    Your browser does not support the video tag.
                </video>
            </div>

            <h2>Lesson Overview</h2>
            <p>
                Welcome to the Programming Basics course! In this lesson, we’ll give
                you an overview of what programming is, why it’s useful, and how to
                get started.
            </p>
            <p>
                Programming is a valuable skill that can open up many opportunities in
                various fields such as software development, web development, and data
                analysis.
            </p>
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
            <a href="{{route ('course.index')}}" class="back-btn">← Back to Courses</a>
        </div>
    </main>
    @push('scripts')
    <script>
        const form = document.getElementById("comment-form");
        const input = document.getElementById("comment-input");
        const commentList = document.getElementById("comment-list");
  
        // Load komentar dari localStorage
        window.onload = function () {
          const saved = JSON.parse(localStorage.getItem("comments") || "[]");
          saved.forEach((text, index) => addComment(text, index));
        };
  
        form.addEventListener("submit", function (e) {
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
          del.onclick = function () {
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
