@extends('templates.app')

@section('title', 'Daftar Kursus Detail')

@section('content')
<div class="container-fluid py-4">
  {{-- Header --}}
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px;">
        <i class="fas fa-book-open"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Manajemen Kursus Detail</h1>
  </div>

  {{-- Tombol Tambah --}}
  <div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.detail_courses.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
      <i class="fas fa-plus me-2"></i>Tambah Kursus
    </a>
  </div>

  {{-- Flash Message --}}
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
      <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  {{-- Tabel --}}
  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
      @if($courses->count())
        <div class="table-responsive">
          <table class="table table-hover align-middle text-nowrap">
            <thead class="table-light">
              <tr>
                <th style="width: 50px;">#</th>
                <th>Judul</th>
                <th>Media</th>
                <th>Deskripsi</th>
                <th>Modul</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($courses as $course)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td class="fw-semibold">{{ \Illuminate\Support\Str::limit($course->title, 40) }}</td>
                  <td>
                    @php
                      $ext = strtolower(pathinfo($course->media, PATHINFO_EXTENSION));
                      $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'webp']);
                      $isVideo = in_array($ext, ['mp4', 'mov', 'avi']);
                    @endphp

                    @if($course->media)
                      @if($isImage)
                        <img src="{{ asset('storage/' . $course->media) }}" class="rounded shadow-sm" style="width: 80px;" alt="Media">
                      @elseif($isVideo)
                        <video width="130" height="80" controls class="rounded shadow-sm">
                          <source src="{{ asset('storage/' . $course->media) }}" type="video/{{ $ext }}">
                          Browser tidak mendukung video.
                        </video>
                      @else
                        <span class="text-muted small fst-italic">Format tidak didukung</span>
                      @endif
                    @else
                      <span class="text-muted small fst-italic">Tidak ada media</span>
                    @endif
                  </td>
                  <td>{{ \Illuminate\Support\Str::limit($course->description, 80) }}</td>
                  <td>
                    @if($course->modules && count($course->modules))
                      <ul class="mb-0 ps-3 small">
                        @foreach($course->modules as $module)
                          <li>{{ $module }}</li>
                        @endforeach
                      </ul>
                    @else
                      <span class="text-muted small fst-italic">-</span>
                    @endif
                  </td>
                  <td class="text-center">
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                      <a href="{{ route('admin.detail_courses.show', $course) }}" class="btn btn-sm btn-info rounded-pill px-3 shadow-sm">
                        <i class="fas fa-eye me-1"></i>Lihat
                      </a>
                      <a href="{{ route('admin.detail_courses.edit', $course) }}" class="btn btn-sm btn-warning rounded-pill px-3 shadow-sm">
                        <i class="fas fa-edit me-1"></i>Edit
                      </a>
                      <form action="{{ route('admin.detail_courses.destroy', $course) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kursus ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger rounded-pill px-3 shadow-sm">
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
      @else
        <div class="alert alert-secondary d-flex align-items-center gap-2 mb-0">
          <i class="fas fa-info-circle"></i>
          <span>Belum ada data kursus detail.</span>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
