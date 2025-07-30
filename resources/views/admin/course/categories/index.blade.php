@extends('templates.app')

@section('title', 'Kelola Kategori, Level, dan Rentang Harga')

@section('content')
<div class="container-fluid py-4">

  {{-- Heading --}}
  <div class="d-flex align-items-center mb-4">
    <div class="me-3">
      <div class="bg-gradient rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px; background: linear-gradient(135deg, #3f51b5, #2196f3);">
        <i class="fas fa-sliders-h text-black"></i>
      </div>
    </div>
    <div>
      <h1 class="h4 fw-bold mb-0">Kelola Kategori, Level & Rentang Harga</h1>
      <small class="text-muted">Pengelolaan data dasar course</small>
    </div>
  </div>

  {{-- Button --}}
  <div class="d-flex justify-content-end mb-4">
    <a href="{{ route('admin.course-categories.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
      <i class="fas fa-plus me-2"></i>Tambah Kategori
    </a>
  </div>

  {{-- SECTION: Kategori --}}
  <div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-white fw-semibold border-bottom-0 text-primary">
      <i class="fas fa-folder-tree me-2"></i>Data Kategori
    </div>
    <div class="card-body p-0">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Nama</th>
            <th class="text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($categories as $category)
            <tr>
              <td>{{ $category->category }}</td>
              <td class="text-end">
                <a href="{{ route('admin.course-categories.edit', $category->id) }}" class="btn btn-sm btn-outline-warning rounded-pill px-3">
                  <i class="fas fa-edit me-1"></i>Edit
                </a>
                <form action="{{ route('admin.course-categories.destroy', $category->id) }}" method="POST" class="d-inline" id="delete-form-category-{{ $category->id }}">
                  @csrf @method('DELETE')
                  <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3"
                    onclick="confirmDelete('delete-form-category-{{ $category->id }}', '{{ $category->category }}')">
                    <i class="fas fa-trash-alt me-1"></i>Hapus
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="2" class="text-center text-muted py-4">Belum ada kategori.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- SECTION: Level --}}
  <div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-white fw-semibold border-bottom-0 text-success">
      <i class="fas fa-signal me-2"></i>Data Level
    </div>
    <div class="card-body p-0">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Nama</th>
            <th class="text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($levels as $level)
            <tr>
              <td>{{ $level->level }}</td>
              <td class="text-end">
                <a href="{{ route('admin.course-levels.edit', $level->id) }}" class="btn btn-sm btn-outline-warning rounded-pill px-3">
                  <i class="fas fa-edit me-1"></i>Edit
                </a>
                <form action="{{ route('admin.course-levels.destroy', $level->id) }}" method="POST" class="d-inline" id="delete-form-level-{{ $level->id }}">
                  @csrf @method('DELETE')
                  <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3"
                    onclick="confirmDelete('delete-form-level-{{ $level->id }}', '{{ $level->level }}')">
                    <i class="fas fa-trash-alt me-1"></i>Hapus
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="2" class="text-center text-muted py-4">Belum ada level.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- SECTION: Rentang Harga --}}
  <div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-white fw-semibold border-bottom-0 text-danger">
      <i class="fas fa-money-bill-wave me-2"></i>Rentang Harga
    </div>
    <div class="card-body p-0">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Harga</th>
            <th class="text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($prices as $price)
            <tr>
              <td>Rp {{ number_format($price->min_price) }} - Rp {{ number_format($price->max_price) }}</td>
              <td class="text-end">
                <a href="{{ route('admin.course-prices.edit', $price->id) }}" class="btn btn-sm btn-outline-warning rounded-pill px-3">
                  <i class="fas fa-edit me-1"></i>Edit
                </a>
                <form action="{{ route('admin.course-prices.destroy', $price->id) }}" method="POST" class="d-inline" id="delete-form-price-{{ $price->id }}">
                  @csrf @method('DELETE')
                  <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3"
                    onclick="confirmDelete('delete-form-price-{{ $price->id }}', 'Rentang Harga')">
                    <i class="fas fa-trash-alt me-1"></i>Hapus
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="2" class="text-center text-muted py-4">Belum ada rentang harga.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

{{-- Modal Konfirmasi --}}
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
        <p class="mb-0">Anda yakin ingin menghapus <span id="itemToDelete" class="fw-bold text-danger"></span>?</p>
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

  function confirmDelete(formId, label) {
    deleteFormId = formId;
    document.getElementById('itemToDelete').textContent = label;

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
      }, 500);
    }
  });
</script>
@endsection
