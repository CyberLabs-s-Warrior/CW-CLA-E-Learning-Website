@extends('templates.app')

@section('title', 'Daftar Materi')

@section('content')
<div class="container-fluid py-4">
  {{-- Header --}}
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px;">
        <i class="fas fa-book-open"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Daftar Materi</h1>
  </div>

  {{-- Tambah Materi --}}
  <div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.lessons.create') }}" class="btn btn-primary rounded-pill px-4">
      <i class="fas fa-plus me-2"></i>Tambah Materi
    </a>
  </div>

  {{-- Alert Sukses --}}
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  {{-- Table --}}
  @if($lessons->count())
    <div class="card border-0 shadow-sm rounded-4">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th>No</th>
                <th>Kursus</th>
                <th>Modul</th>
                <th>Judul</th>
                <th>Media</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($lessons as $lesson)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $lesson->course->title ?? '-' }}</td>
                  <td>{{ $lesson->module_name }}</td>
                  <td>{{ $lesson->title }}</td>
                  <td>
                    @if($lesson->media)
                      @php
                        $mediaExt = pathinfo($lesson->media, PATHINFO_EXTENSION);
                        $isImage = in_array(strtolower($mediaExt), ['jpg', 'jpeg', 'png', 'webp']);
                        $isVideo = in_array(strtolower($mediaExt), ['mp4', 'mov', 'avi']);
                      @endphp

                      @if($isImage)
                        <img src="{{ asset('storage/' . $lesson->media) }}" alt="{{ $lesson->title }}" class="img-thumbnail rounded shadow-sm" style="width: 80px; height: auto;">
                      @elseif($isVideo)
                        <video width="140" height="90" controls class="rounded shadow-sm">
                          <source src="{{ asset('storage/' . $lesson->media) }}" type="video/{{ $mediaExt }}">
                          Browser tidak mendukung tag video.
                        </video>
                      @else
                        <span class="text-muted">Format tidak didukung</span>
                      @endif
                    @else
                      <span class="text-muted">Tidak ada media</span>
                    @endif
                  </td>
                  <td class="text-center">
                    <div class="d-flex justify-content-center gap-1 flex-wrap">
                      <a href="{{ route('admin.lessons.show', $lesson) }}" class="btn btn-sm btn-info rounded-pill px-3">
                        <i class="fas fa-eye me-1"></i>Show
                      </a>
                      <a href="{{ route('admin.lessons.edit', $lesson) }}" class="btn btn-sm btn-warning rounded-pill px-3">
                        <i class="fas fa-edit me-1"></i>Edit
                      </a>
                      <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus materi ini?')" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3">
                          <i class="fas fa-trash-alt me-1"></i>Hapus
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  @else
    <div class="alert alert-info d-flex align-items-center gap-2" role="alert">
      <i class="fas fa-info-circle"></i>
      <div>Belum ada data materi yang tersedia.</div>
    </div>
  @endif
</div>
@endsection
