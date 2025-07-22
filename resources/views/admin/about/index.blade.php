@extends('templates.app')

@section('title', 'Kelola Konten About')

@section('content')
<div class="container-fluid py-4">
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
        <i class="fas fa-info-circle"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Kelola Konten About</h1>
  </div>

  {{-- Filter dan tombol tambah --}}
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
    <form method="GET" action="{{ route('admin.about.index') }}" id="filter-form" class="d-flex align-items-end gap-2 flex-wrap">
      <label for="section" class="form-label mb-0 fw-semibold">Filter Section:</label>
      <select name="section" id="section" class="form-select shadow-sm rounded-3"
              onchange="document.getElementById('filter-form').submit();">
        <option value="">-- Semua Section --</option>
        @foreach ($sections as $section)
          <option value="{{ $section }}" {{ request('section') == $section ? 'selected' : '' }}>
            {{ $section }}
          </option>
        @endforeach
      </select>
    </form>

    <a href="{{ route('admin.about.create') }}" class="btn btn-primary rounded-pill px-4">
      <i class="fas fa-plus me-2"></i>Tambah Konten
    </a>
  </div>

@if(session('success'))
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#3085d6',
        timer: 2500,
        timerProgressBar: true,
        showConfirmButton: false,
      });
    });
  </script>
@endif


  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Section</th>
              <th>Judul</th>
              <th>Deskripsi</th>
              <th>Gambar</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($contents as $content)
              <tr>
                <td>{{ $content->section }}</td>
                <td>{{ $content->title ?? '-' }}</td>
                <td>{{ Str::limit($content->description ?? '-', 50) }}</td>
                <td>
                  @if($content->image)
                    <img src="{{ asset('storage/' . $content->image) }}" width="60" class="img-thumbnail rounded">
                  @else
                    <span class="text-muted">-</span>
                  @endif
                </td>
                <td>
                  <div class="d-flex flex-wrap gap-1">
                    <a href="{{ route('admin.about.edit', $content->id) }}" class="btn btn-sm btn-warning rounded-pill px-3">
                      <i class="fas fa-edit me-1"></i>Edit
                    </a>

                    <form action="{{ route('admin.about.destroy', $content->id) }}" method="POST" id="delete-form-{{ $content->id }}">
                      @csrf
                      @method('DELETE')
                      <button type="button" class="btn btn-sm btn-danger rounded-pill px-3"
                        onclick="confirmDelete({{ $content->id }}, '{{ $content->title ?? 'konten ini' }}')">
                        <i class="fas fa-trash-alt me-1"></i>Hapus
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted py-4">
                  <i class="fas fa-info-circle me-2"></i>Belum ada konten.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      <div class="mt-4">
        {{ $contents->withQueryString()->links('vendor.pagination.bootstrap-5') }}
      </div>
    </div>
  </div>
</div>

{{-- MODAL KONFIRMASI --}}
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-semibold" id="deleteConfirmModalLabel">
          <i class="fas fa-trash-alt me-2 text-danger"></i>Konfirmasi Hapus
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p class="mb-0">Apakah Anda yakin ingin menghapus <span id="itemToDelete" class="fw-bold text-danger"></span>?</p>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger rounded-pill px-4 d-flex align-items-center gap-2" id="confirmDeleteBtn">
          <span class="spinner-border spinner-border-sm d-none" id="deleteSpinner" role="status" aria-hidden="true"></span>
          <span id="deleteBtnText">Ya, Hapus</span>
        </button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  let deleteFormId = null;

  function confirmDelete(id, title) {
    deleteFormId = `delete-form-${id}`;
    document.getElementById('itemToDelete').textContent = title;

    document.getElementById('deleteSpinner').classList.add('d-none');
    document.getElementById('deleteBtnText').textContent = 'Ya, Hapus';
    document.getElementById('confirmDeleteBtn').disabled = false;

    const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
    modal.show();
  }

  document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
    if (deleteFormId) {
      document.getElementById('deleteSpinner').classList.remove('d-none');
      document.getElementById('deleteBtnText').textContent = 'Menghapus...';
      document.getElementById('confirmDeleteBtn').disabled = true;

      setTimeout(() => {
        document.getElementById(deleteFormId).submit();
      }, 400);
    }
  });
</script>
@endsection
