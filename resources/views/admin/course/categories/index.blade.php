@extends('templates.app')

@section('title', 'Kelola Kategori, Level, dan Rentang Harga')

@section('content')
<div class="container-fluid py-4">

  {{-- Heading --}}
  <div class="d-flex align-items-center mb-4">
    <div class="me-3">
      <div class="bg-gradient rounded-circle d-flex align-items-center justify-content-center shadow-sm"
        style="width: 50px; height: 50px; background: linear-gradient(135deg, #3f51b5, #2196f3);">
        <i class="fas fa-sliders-h text-primary"></i>
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

  {{-- Nav Tabs --}}
  <ul class="nav nav-tabs mb-3" id="manageTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="kategori-tab" data-bs-toggle="tab" data-bs-target="#kategori" type="button"
        role="tab" aria-controls="kategori" aria-selected="false">
        <i class="fas fa-folder-tree me-1"></i> Kategori
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="level-tab" data-bs-toggle="tab" data-bs-target="#level" type="button" role="tab"
        aria-controls="level" aria-selected="false">
        <i class="fas fa-signal me-1"></i> Level
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="harga-tab" data-bs-toggle="tab" data-bs-target="#harga" type="button" role="tab"
        aria-controls="harga" aria-selected="false">
        <i class="fas fa-money-bill-wave me-1"></i> Rentang Harga
      </button>
    </li>
  </ul>

  {{-- Tab Contents --}}
  <div class="tab-content" id="manageTabContent">
    {{-- Kategori --}}
    <div class="tab-pane fade" id="kategori" role="tabpanel" aria-labelledby="kategori-tab">
      <div class="card border-0 shadow-sm rounded-4">
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
                  <a href="{{ route('admin.course-categories.edit', $category->id) }}"
                    class="btn btn-sm btn-outline-warning rounded-pill px-3">
                    <i class="fas fa-edit me-1"></i>Edit
                  </a>
                  <form action="{{ route('admin.course-categories.destroy', $category->id) }}" method="POST"
                    id="delete-form-category-{{ $category->id }}" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 me-2"
                      onclick="confirmDelete('category', {{ $category->id }}, '{{ addslashes($category->category) }}')">
                      <i class="fas fa-trash me-1"></i>Hapus
                    </button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="2" class="text-center text-muted py-4">Belum ada kategori.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
          <div class="px-3 py-2">
            {{ $categories->appends(['tab' => 'kategori'])->links() }}
          </div>
        </div>
      </div>
    </div>

    {{-- Level --}}
    <div class="tab-pane fade" id="level" role="tabpanel" aria-labelledby="level-tab">
      <div class="card border-0 shadow-sm rounded-4">
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
                  <a href="{{ route('admin.course-levels.edit', $level->id) }}"
                    class="btn btn-sm btn-outline-warning rounded-pill px-3">
                    <i class="fas fa-edit me-1"></i>Edit
                  </a>
                  <form action="{{ route('admin.course-levels.destroy', $level->id) }}" method="POST"
                    id="delete-form-level-{{ $level->id }}" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 me-2"
                      onclick="confirmDelete('level', {{ $level->id }}, '{{ addslashes($level->level) }}')">
                      <i class="fas fa-trash me-1"></i>Hapus
                    </button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="2" class="text-center text-muted py-4">Belum ada level.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
          <div class="px-3 py-2">
            {{ $levels->appends(['tab' => 'level'])->links() }}
          </div>
        </div>
      </div>
    </div>

    {{-- Rentang Harga --}}
    <div class="tab-pane fade" id="harga" role="tabpanel" aria-labelledby="harga-tab">
      <div class="card border-0 shadow-sm rounded-4">
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
                  <a href="{{ route('admin.course-prices.edit', $price->id) }}"
                    class="btn btn-sm btn-outline-warning rounded-pill px-3">
                    <i class="fas fa-edit me-1"></i>Edit
                  </a>
                  <form action="{{ route('admin.course-prices.destroy', $price->id) }}" method="POST"
                    id="delete-form-price-{{ $price->id }}" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 me-2"
                      onclick="confirmDelete('price', {{ $price->id }}, 'Rentang Harga')">
                      <i class="fas fa-trash me-1"></i>Hapus
                    </button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="2" class="text-center text-muted py-4">Belum ada rentang harga.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
          <div class="px-3 py-2">
            {{ $prices->appends(['tab' => 'harga'])->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

{{-- Modal Konfirmasi Hapus --}}
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel"
  aria-hidden="true">
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
  // Handle konfirmasi hapus
  let deleteFormId = null;
  let deleteModal = null;

  function confirmDelete(type, id, title) {
    deleteFormId = `delete-form-${type}-${id}`;
    document.getElementById('itemToDelete').textContent = title;

    document.getElementById('deleteSpinner').classList.add('d-none');
    document.getElementById('deleteBtnText').textContent = 'Ya, Hapus';
    document.getElementById('confirmDeleteBtn').disabled = false;

    if (!deleteModal) {
      deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
    }
    deleteModal.show();
  }

  document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
    if (!deleteFormId) return;

    const spinner = document.getElementById('deleteSpinner');
    const btnText = document.getElementById('deleteBtnText');
    const confirmBtn = document.getElementById('confirmDeleteBtn');

    spinner.classList.remove('d-none');
    btnText.textContent = 'Menghapus...';
    confirmBtn.disabled = true;

    setTimeout(() => {
      document.getElementById(deleteFormId).submit();
    }, 500);
  });

  // Handle tab & URL query param agar aktif sesuai tab
  document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab');

    if (tab) {
      const tabTriggerEl = document.querySelector(`#${tab}-tab`);
      if (tabTriggerEl) {
        const tabInstance = bootstrap.Tab.getInstance(tabTriggerEl) || new bootstrap.Tab(tabTriggerEl);
        tabInstance.show();
      }
    } else {
      // Jika tidak ada param tab, aktifkan kategori (default)
      const defaultTabTriggerEl = document.querySelector('#kategori-tab');
      if (defaultTabTriggerEl) {
        const tabInstance = bootstrap.Tab.getInstance(defaultTabTriggerEl) || new bootstrap.Tab(defaultTabTriggerEl);
        tabInstance.show();
      }
    }

    // Update URL tanpa reload saat klik tab
    const tabButtons = document.querySelectorAll('#manageTab button[data-bs-toggle="tab"]');
    tabButtons.forEach(btn => {
      btn.addEventListener('shown.bs.tab', function (e) {
        const newTab = e.target.getAttribute('aria-controls');
        const url = new URL(window.location);
        url.searchParams.set('tab', newTab);
        history.replaceState(null, '', url);
      });
    });
  });
</script>

@if(session('success'))
<script>
  document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: @json(session('success')),
      background: 'linear-gradient(145deg, #e6f0ff, #f8fbff)',
      color: '#1e3a8a',
      iconColor: '#0d6efd',
      showConfirmButton: false,
      timer: 2500,
      timerProgressBar: true,
      customClass: {
        popup: 'custom-swal-popup rounded-4 shadow-lg border-0 p-4',
        title: 'fw-bold fs-4 text-primary custom-swal-title',
        htmlContainer: 'mt-2 fs-6 custom-swal-text',
        icon: 'custom-swal-icon'
      },
      didOpen: () => {
        const icon = document.querySelector('.custom-swal-icon');
        if (icon) {
          icon.style.animation = 'bounceInIcon 0.6s ease, pulseBlue 1.5s infinite';
        }
      },
      willClose: () => {
        const popup = document.querySelector('.custom-swal-popup');
        if (popup) {
          popup.style.animation = 'fadeZoomOut 0.4s ease forwards';
        }
      }
    });
  });
</script>

<style>
  .custom-swal-popup {
    animation: fadeZoomIn 0.45s ease;
    backdrop-filter: blur(6px);
  }

  @keyframes fadeZoomOut {
    from {
      opacity: 1;
      transform: scale(1);
    }

    to {
      opacity: 0;
      transform: scale(0.85);
    }
  }

  @keyframes fadeZoomIn {
    from {
      opacity: 0;
      transform: scale(0.85);
    }

    to {
      opacity: 1;
      transform: scale(1);
    }
  }

  @keyframes bounceInIcon {
    0% {
      transform: translateY(50px) scale(0.8);
      opacity: 0;
    }

    60% {
      transform: translateY(-10px) scale(1.05);
      opacity: 1;
    }

    100% {
      transform: translateY(0) scale(1);
    }
  }

  @keyframes pulseBlue {
    0% {
      box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.6);
    }

    70% {
      box-shadow: 0 0 0 15px rgba(13, 110, 253, 0);
    }

    100% {
      box-shadow: 0 0 0 0 rgba(13, 110, 253, 0);
    }
  }

  .custom-swal-title {
    animation: fadeInDown 0.5s ease 0.2s both;
  }

  .custom-swal-text {
    animation: fadeInUp 0.5s ease 0.4s both;
  }
</style>
@endif
@endsection
