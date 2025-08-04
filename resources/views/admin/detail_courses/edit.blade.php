@extends('templates.app')

@section('title', 'Edit Kursus')

@section('content')
<div class="container-fluid py-4">
  {{-- Header --}}
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px;">
        <i class="fas fa-pen-to-square"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Edit Kursus</h1>
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
      <form action="{{ route('admin.detail_courses.update', $detailCourse) }}" method="POST" enctype="multipart/form-data" class="row g-3">
        @csrf
        @method('PUT')

        <div class="col-12">
          <label for="title" class="form-label fw-semibold">Judul Kursus</label>
          <input type="text" name="title" id="title" class="form-control shadow-sm" required value="{{ old('title', $detailCourse->title) }}">
        </div>

        <div class="col-12">
          <label for="description" class="form-label fw-semibold">Deskripsi</label>
          <textarea name="description" id="description" class="form-control shadow-sm" rows="4">{{ old('description', $detailCourse->description) }}</textarea>
        </div>

        <div class="col-12">
          <label class="form-label fw-semibold">Media Saat Ini</label><br>
          @php
              $ext = pathinfo($detailCourse->media, PATHINFO_EXTENSION);
              $ext = strtolower($ext);
          @endphp

          @if($detailCourse->media)
            @if(in_array($ext, ['jpg', 'jpeg', 'png', 'webp']))
              <img src="{{ asset('storage/' . $detailCourse->media) }}" class="img-thumbnail mb-2 shadow-sm" width="150">
            @elseif(in_array($ext, ['mp4', 'mov', 'avi']))
              <video width="200" controls class="shadow-sm rounded">
                <source src="{{ asset('storage/' . $detailCourse->media) }}" type="video/{{ $ext }}">
              </video>
            @else
              <p class="text-muted">Format media tidak dikenali</p>
            @endif
          @else
            <p class="text-muted">Tidak ada media</p>
          @endif
        </div>

        <div class="col-12">
          <label for="media" class="form-label fw-semibold">Ganti Media (Gambar / Video)</label>
          <input type="file" name="media" id="media" class="form-control shadow-sm" accept="image/*,video/*">
        </div>

        <div class="col-12">
          <label class="form-label fw-semibold">Modul</label>
          <div id="modules-list">
            @foreach(old('modules', $detailCourse->modules) as $module)
              <input type="text" name="modules[]" class="form-control mb-2 shadow-sm" value="{{ $module }}">
            @endforeach
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 mt-1" onclick="addModule()">
            <i class="fas fa-plus me-1"></i>Tambah Modul
          </button>
        </div>

        <div class="col-12 d-flex gap-2 mt-4">
          <button type="submit" class="btn btn-warning rounded-pill px-4 shadow-sm">
            <i class="fas fa-save me-2"></i>Update
          </button>
          <a href="{{ route('admin.detail_courses.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Script --}}
<script>
  function addModule() {
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'modules[]';
    input.className = 'form-control mb-2 shadow-sm';
    input.placeholder = 'Modul tambahan';
    document.getElementById('modules-list').appendChild(input);
  }
</script>
@endsection
