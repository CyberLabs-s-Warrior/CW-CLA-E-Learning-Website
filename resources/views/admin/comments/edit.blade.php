@extends('templates.app')

@section('title', 'Edit Komentar')

@section('content')
<div class="container-fluid py-4">
  {{-- Header --}}
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
        <i class="fas fa-comment-dots"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Edit Komentar</h1>
  </div>

  {{-- Form --}}
  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
      <form action="{{ route('admin.comments.update', $comment) }}" method="POST" class="d-flex flex-column gap-3">
        @csrf
        @method('PUT')

        {{-- Kursus --}}
        <div>
          <label for="detail_course_id" class="form-label fw-semibold">Kursus</label>
          <select name="detail_course_id" id="detail_course_id" class="form-select shadow-sm" required>
            @foreach($courses as $course)
              <option value="{{ $course->id }}" {{ $comment->detail_course_id == $course->id ? 'selected' : '' }}>
                {{ $course->title }}
              </option>
            @endforeach
          </select>
          @error('detail_course_id')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        {{-- Nama --}}
        <div>
          <label for="name" class="form-label fw-semibold">Nama</label>
          <input type="text" name="name" id="name" class="form-control shadow-sm" value="{{ old('name', $comment->name) }}" required>
          @error('name')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        {{-- Komentar --}}
        <div>
          <label for="content" class="form-label fw-semibold">Komentar</label>
          <textarea name="content" id="content" class="form-control shadow-sm" rows="4" required>{{ old('content', $comment->content) }}</textarea>
          @error('content')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        {{-- Tombol --}}
        <div class="d-flex gap-2 mt-3">
          <button type="submit" class="btn btn-warning rounded-pill px-4">
            <i class="fas fa-save me-2"></i>Update
          </button>
          <a href="{{ route('admin.comments.index') }}" class="btn btn-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i>Kembali
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
