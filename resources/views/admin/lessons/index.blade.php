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

  {{-- Tombol Tambah --}}
  <div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.lessons.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
      <i class="fas fa-plus me-2"></i>Tambah Materi
    </a>
  </div>

  {{-- Alert Sukses --}}
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm d-flex align-items-center gap-2" role="alert">
      <i class="fas fa-check-circle"></i>
      <div>{{ session('success') }}</div>
      <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
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
                    @php
                      $mediaExt = pathinfo($lesson->media, PATHINFO_EXTENSION);
                      $isImage = in_array(strtolower($mediaExt), ['jpg', 'jpeg', 'png', 'webp']);
                      $isVideo = in_array(strtolower($mediaExt), ['mp4', 'mov', 'avi']);
                    @endphp

                    @if($lesson->media)
                      @if($isImage)
                        <img src="{{ asset('storage/' . $lesson->media) }}" alt="{{ $lesson->title }}" class="img-thumbnail rounded shadow-sm" style="width: 80px; height: auto;">
                      @elseif($isVideo)
                        <video width="130" height="80" controls class="rounded shadow-sm">
                          <source src="{{ asset('storage/' . $lesson->media) }}" type="video/{{ $mediaExt }}">
                          Browser tidak mendukung video.
                        </video>
                      @else
                        <span class="text-muted small fst-italic">Format tidak didukung</span>
                      @endif
                    @else
                      <span class="text-muted small fst-italic">Tidak ada media</span>
                    @endif
                  </td>
                  <td class="text-center">
                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                      <a href="{{ route('admin.lessons.show', $lesson) }}" class="btn btn-sm btn-info rounded-pill px-3 shadow-sm">
                        <i class="fas fa-eye me-1"></i>Show
                      </a>
                      <a href="{{ route('admin.lessons.edit', $lesson) }}" class="btn btn-sm btn-warning rounded-pill px-3 shadow-sm">
                        <i class="fas fa-edit me-1"></i>Edit
                      </a>
                      {{-- Hapus dengan SweetAlert2 --}}
                      <form id="formHapus-{{ $lesson->id }}" action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger rounded-pill px-3 shadow-sm btn-confirm" data-id="{{ $lesson->id }}" data-title="{{ $lesson->title }}">
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

@push('scripts')
{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.btn-confirm');

    buttons.forEach(button => {
      button.addEventListener('click', function () {
        const id = this.dataset.id;
        const title = this.dataset.title;

        Swal.fire({
          title: 'Yakin ingin menghapus?',
          html: `Materi <strong>"${title}"</strong> akan dihapus secara permanen.`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Ya, Hapus!',
          cancelButtonText: 'Batal',
          reverseButtons: true,
          buttonsStyling: false,
          customClass: {
            confirmButton: 'btn btn-danger rounded-pill me-2',
            cancelButton: 'btn btn-secondary rounded-pill'
          }
        }).then((result) => {
          if (result.isConfirmed) {
            document.getElementById('formHapus-' + id).submit();
          }
        });
      });
    });
  });
</script>
@endpush
