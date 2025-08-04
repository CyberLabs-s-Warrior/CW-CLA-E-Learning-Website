@extends('templates.app')

@section('content')
<div class="container-fluid py-4">
  {{-- Header --}}
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
        <i class="fas fa-comments"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Daftar Komentar</h1>
  </div>

  {{-- Tombol Tambah --}}
  <div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.comments.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
      <i class="fas fa-plus me-2"></i>Tambah Komentar
    </a>
  </div>

  {{-- Tabel --}}
  @if($comments->count())
    <div class="card border-0 shadow-sm rounded-4">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th style="width: 5%;">No</th>
                <th>Nama</th>
                <th>Kursus</th>
                <th>Komentar</th>
                <th style="width: 20%;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($comments as $comment)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $comment->name }}</td>
                  <td>{{ $comment->detailCourse->title ?? '-' }}</td>
                  <td>{{ $comment->content }}</td>
                  <td>
                    <div class="d-flex gap-1">
                      <a href="{{ route('admin.comments.edit', $comment) }}" class="btn btn-sm btn-warning rounded-pill px-3">
                        <i class="fas fa-edit me-1"></i>Edit
                      </a>
                      <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="d-inline form-delete" data-nama="{{ $comment->name }}">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger rounded-pill px-3 btn-delete">
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
    <div class="text-muted text-center py-4">
      <i class="fas fa-info-circle me-2"></i>Belum ada komentar.
    </div>
  @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Notifikasi sukses
    @if(session('success'))
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: @json(session('success')),
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true
      });
    @endif

    // Hapus dengan konfirmasi SweetAlert
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
      button.addEventListener('click', function () {
        const form = button.closest('form');
        const nama = form.getAttribute('data-nama');

        Swal.fire({
          title: 'Yakin ingin menghapus?',
          html: `<span class="fw-semibold text-danger">${nama}</span> akan dihapus secara permanen.`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Ya, Hapus',
          cancelButtonText: 'Batal',
          customClass: {
            confirmButton: 'btn btn-danger rounded-pill px-4 me-2',
            cancelButton: 'btn btn-secondary rounded-pill px-4'
          },
          buttonsStyling: false
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });
  });
</script>
@endpush
