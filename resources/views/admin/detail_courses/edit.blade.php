@extends('templates.app')

@section('title', 'Edit Kursus Detail')

@section('content')
<div class="container-fluid py-4">
  {{-- Header --}}
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px;">
        <i class="fas fa-edit"></i>
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
      <form action="{{ route('admin.detail_courses.update', $course->id) }}" method="POST" enctype="multipart/form-data" class="row g-3">
        @csrf
        @method('PUT')

        {{-- Judul --}}
        <div class="col-12">
          <label for="title" class="form-label fw-semibold">Judul Kursus</label>
          <input type="text" name="title" id="title" class="form-control shadow-sm" required value="{{ old('title', $course->title) }}">
        </div>

        {{-- Deskripsi --}}
        <div class="col-12">
          <label for="description" class="form-label fw-semibold">Deskripsi</label>
          <textarea name="description" id="description" class="form-control shadow-sm" rows="4" required>{{ old('description', $course->description) }}</textarea>
        </div>

        {{-- Modul --}}
        <div class="col-12">
          <label class="form-label fw-semibold">Modul</label>
          <div id="modules-list">
            @php
              $modules = old('modules', $course->modules ?? []);
            @endphp
            @forelse($modules as $mod)
              <input type="text" name="modules[]" class="form-control mb-2 shadow-sm" value="{{ $mod }}">
            @empty
              <input type="text" name="modules[]" class="form-control mb-2 shadow-sm" placeholder="Modul 1">
            @endforelse
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 mt-1" onclick="addModule()">
            <i class="fas fa-plus me-1"></i>Tambah Modul
          </button>
        </div>

        {{-- Media --}}
        <div class="col-12">
          <label for="media" class="form-label fw-semibold">Upload Media Baru (Opsional)</label>
          <input type="file" name="media" id="media" class="form-control shadow-sm" accept="image/*,video/*">
          @if($course->media)
            <small class="d-block text-muted mt-1">Media saat ini:
              <a href="{{ asset('storage/' . $course->media) }}" target="_blank">Lihat</a>
            </small>
          @endif
        </div>

        {{-- Tombol --}}
        <div class="col-12 d-flex gap-2 mt-4">
          <button type="submit" class="btn btn-warning rounded-pill px-4 shadow-sm">
            <i class="fas fa-save me-2"></i>Perbarui
          </button>
          <a href="{{ route('admin.detail_courses.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- JS for dynamic modules --}}
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
