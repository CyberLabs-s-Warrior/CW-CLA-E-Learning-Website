@extends('templates.app')

@section('title', 'Daftar Course')

@section('content')
  <div class="container-fluid py-4">
    {{-- Heading --}}
    <div class="d-flex align-items-center mb-4">
      <div class="me-2">
        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center"
          style="width: 40px; height: 40px;">
          <i class="fas fa-chalkboard-teacher"></i>
        </div>
      </div>
      <h1 class="h4 fw-semibold mb-0">Daftar Course</h1>
    </div>

    {{-- Tombol Tambah --}}
    <div class="d-flex justify-content-end mb-3">
      <a href="{{ route('admin.course.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
        <i class="fas fa-plus me-2"></i>Tambah Course
      </a>
    </div>

    {{-- Alert kosong --}}
    @if($courses->isEmpty())
      <div class="alert alert-info d-flex align-items-center gap-2" role="alert">
        <i class="fas fa-info-circle"></i>
        <div>Belum ada data course.</div>
      </div>
    @endif

    {{-- Tabel Course --}}
    @if($courses->isNotEmpty())
      <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th>Gambar</th>
                  <th>Nama</th>
                  <th>Slug</th>
                  <th>Kategori</th>
                  <th>Level</th>
                  <th>Harga</th>
                  <th>Range Harga</th>
                  <th>Durasi</th>
                  <th>Jumlah Siswa</th>
                  <th>Rating</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($courses as $course)
                  <tr>
                    <td>
                      @if($course->img)
                        <img src="{{ asset('storage/' . $course->img) }}" alt="" class="img-thumbnail rounded shadow-sm"
                          style="width: 60px; height: auto;">
                      @else
                        <span class="text-muted">-</span>
                      @endif
                    </td>
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->slug }}</td>
                    <td>{{ $course->category->category ?? '-' }}</td>
                    <td>{{ $course->level->level ?? '-' }}</td>
                    <td>Rp{{ number_format($course->price) }}</td>
                    <td>
                      @if ($course->priceRange)
                        Rp{{ number_format($course->priceRange->min_price) }} -
                        Rp{{ number_format($course->priceRange->max_price) }}
                      @else
                        <span class="text-muted">Tidak Masuk Range</span>
                      @endif
                    </td>
                    <td>
                      @if($course->formatted_duration)
                        <span class="badge bg-info text-dark px-3 py-2 rounded-pill shadow-sm">
                          <i class="fas fa-clock me-1"></i> {{ $course->formatted_duration }}
                        </span>
                      @else
                        <span class="badge bg-secondary px-3 py-2 rounded-pill">-</span>
                      @endif
                    </td>
                    <td>{{ $course->students_count }}</td>
                    <td>{{ $course->rating }}</td>
                    <td class="text-center">
                      <div class="d-flex justify-content-center gap-2 flex-wrap">
                        <a href="{{ route('admin.course.edit', $course) }}"
                          class="btn btn-sm btn-outline-warning rounded-pill px-3 shadow-sm" data-bs-toggle="tooltip">
                          <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <form action="{{ route('admin.course.destroy', $course) }}" method="POST" class="d-inline"
                          id="delete-form-{{ $course->id }}">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 shadow-sm btn-delete"
                            data-id="{{ $course->id }}" data-name="{{ $course->name }}" data-bs-toggle="tooltip">
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

          {{-- Pagination --}}
          <div class="mt-4 px-3">
            {{ $courses->withQueryString()->links('vendor.pagination.bootstrap-5') }}
          </div>
        </div>
      </div>
    @endif
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
          <p class="mb-0">Apakah Anda yakin ingin menghapus <span id="itemToDelete" class="fw-bold text-danger"></span>?
          </p>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-danger rounded-pill px-4 d-flex align-items-center gap-2"
            id="confirmDeleteBtn">
            <span class="spinner-border spinner-border-sm d-none" id="deleteSpinner" role="status"
              aria-hidden="true"></span>
            <span id="deleteBtnText">Ya, Hapus</span>
          </button>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Session Success
      @if(session('success'))
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
            if (icon) icon.style.animation = 'bounceInIcon 0.6s ease, pulseBlue 1.5s infinite';
          },
          willClose: () => {
            const popup = document.querySelector('.custom-swal-popup');
            if (popup) popup.style.animation = 'fadeZoomOut 0.4s ease forwards';
          }
        });
      @endif

      // Session Error
      @if(session('error'))
        Swal.fire({
          icon: 'error',
          title: 'Gagal!',
          text: @json(session('error')),
          background: 'linear-gradient(145deg, #fff0f0, #fff8f8)',
          color: '#7f1d1d',
          iconColor: '#dc3545',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          customClass: {
            popup: 'custom-swal-popup rounded-4 shadow-lg border-0 p-4',
            title: 'fw-bold fs-4 text-danger custom-swal-title',
            htmlContainer: 'mt-2 fs-6 custom-swal-text',
            icon: 'custom-swal-icon'
          },
          didOpen: () => {
            const icon = document.querySelector('.custom-swal-icon');
            if (icon) icon.style.animation = 'bounceInIcon 0.6s ease, pulseRed 1.5s infinite';
          },
          willClose: () => {
            const popup = document.querySelector('.custom-swal-popup');
            if (popup) popup.style.animation = 'fadeZoomOut 0.4s ease forwards';
          }
        });
      @endif

      // Error Validasi
      @if($errors->any())
        @php $errorMessages = implode("<br>", $errors->all()); @endphp
        Swal.fire({
          icon: 'error',
          title: 'Gagal!',
          html: @json($errorMessages),
          background: 'linear-gradient(145deg, #fff0f0, #fff8f8)',
          color: '#7f1d1d',
          iconColor: '#dc3545',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          customClass: {
            popup: 'custom-swal-popup rounded-4 shadow-lg border-0 p-4',
            title: 'fw-bold fs-4 text-danger custom-swal-title',
            htmlContainer: 'mt-2 fs-6 custom-swal-text text-start',
            icon: 'custom-swal-icon'
          },
          didOpen: () => {
            const icon = document.querySelector('.custom-swal-icon');
            if (icon) icon.style.animation = 'bounceInIcon 0.6s ease, pulseRed 1.5s infinite';
          },
          willClose: () => {
            const popup = document.querySelector('.custom-swal-popup');
            if (popup) popup.style.animation = 'fadeZoomOut 0.4s ease forwards';
          }
        });
      @endif

      // Modal hapus
      let deleteForm = null;
      document.querySelectorAll(".btn-delete").forEach(button => {
        button.addEventListener("click", function () {
          const courseId = this.dataset.id;
          const courseName = this.dataset.name;
          deleteForm = document.getElementById(`delete-form-${courseId}`);
          document.getElementById("itemToDelete").textContent = courseName;
          const modal = new bootstrap.Modal(document.getElementById("deleteConfirmModal"));
          modal.show();
        });
      });

      document.getElementById("confirmDeleteBtn").addEventListener("click", function () {
        if (deleteForm) {
          document.getElementById("deleteSpinner").classList.remove("d-none");
          document.getElementById("deleteBtnText").textContent = "Menghapus...";
          deleteForm.submit();
        }
      });
    });
  </script>

  <style>
    @keyframes bounceInIcon {
      0% {
        transform: scale(0.5);
        opacity: 0;
      }

      60% {
        transform: scale(1.2);
        opacity: 1;
      }

      100% {
        transform: scale(1);
      }
    }

    @keyframes fadeZoomOut {
      0% {
        transform: scale(1);
        opacity: 1;
      }

      100% {
        transform: scale(0.9);
        opacity: 0;
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

    @keyframes pulseRed {
      0% {
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.6);
      }

      70% {
        box-shadow: 0 0 0 15px rgba(220, 53, 69, 0);
      }

      100% {
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
      }
    }
  </style>
@endpush