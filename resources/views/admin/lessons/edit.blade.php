@extends('templates.app')

@section('title', 'Edit Materi')

@section('content')
<div class="container-fluid py-4">
  {{-- Header --}}
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px;">
        <i class="fas fa-pen-to-square"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Edit Materi</h1>
  </div>

  {{-- Error Message --}}
  @if($errors->any())
    <div class="alert alert-danger shadow-sm">
      <ul class="mb-0">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Form --}}
  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
      <form action="{{ route('admin.lessons.update', $lesson) }}" method="POST" enctype="multipart/form-data" class="row g-3">
        @csrf
        @method('PUT')

        <div class="col-md-6">
          <label for="detail_courses_id" class="form-label fw-semibold">Kursus</label>
          <select name="detail_courses_id" id="detail_courses_id" class="form-select shadow-sm" required>
            <option value="">-- Pilih Kursus --</option>
            @foreach($courses as $course)
              <option value="{{ $course->id }}" {{ $lesson->detail_courses_id == $course->id ? 'selected' : '' }}>
                {{ $course->title }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="col-md-6">
          <label for="module_name" class="form-label fw-semibold">Nama Modul</label>
          <input type="text" name="module_name" id="module_name" class="form-control shadow-sm" value="{{ old('module_name', $lesson->module_name) }}" required>
        </div>

        <div class="col-12">
          <label for="title" class="form-label fw-semibold">Judul Materi</label>
          <input type="text" name="title" id="title" class="form-control shadow-sm" value="{{ old('title', $lesson->title) }}" required>
        </div>

        <div class="col-12">
          <label for="content" class="form-label fw-semibold">Konten</label>
          <textarea name="content" id="content" class="form-control shadow-sm" rows="4">{{ old('content', $lesson->content) }}</textarea>
        </div>

        {{-- Media saat ini --}}
        <div class="col-12">
          <label class="form-label fw-semibold">Media Saat Ini</label><br>
          @php
              $ext = pathinfo($lesson->media, PATHINFO_EXTENSION);
              $ext = strtolower($ext);
          @endphp

          @if($lesson->media)
            @if(in_array($ext, ['jpg', 'jpeg', 'png', 'webp']))
              <img src="{{ asset('storage/' . $lesson->media) }}" class="img-thumbnail mb-2 shadow-sm" width="150">
            @elseif(in_array($ext, ['mp4', 'mov', 'avi']))
              <video width="200" controls class="shadow-sm rounded">
                <source src="{{ asset('storage/' . $lesson->media) }}" type="video/{{ $ext }}">
              </video>
            @else
              <p class="text-muted">Format media tidak dikenali</p>
            @endif
          @else
            <p class="text-muted">Tidak ada media</p>
          @endif
        </div>

        {{-- Upload Media --}}
        <div class="col-12">
          <label for="media" class="form-label fw-semibold">Ganti Media (Gambar / Video)</label>
          <input type="file" name="media" id="media" class="form-control shadow-sm" accept="image/*,video/*">
        </div>

        {{-- Tombol --}}
        <div class="col-12 d-flex gap-2 mt-4">
          <button type="submit" class="btn btn-warning rounded-pill px-4 shadow-sm">
            <i class="fas fa-save me-2"></i>Update
          </button>
          <a href="{{ route('admin.lessons.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
