@extends('templates.app')

@section('title', 'Daftar Materi')

@section('content')
  <div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex align-items-center mb-4">
      <div class="me-2">
        <div
          class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center shadow-sm"
          style="width: 44px; height: 44px;">
          <i class="fas fa-book-open"></i>
        </div>
      </div>
      <h1 class="h4 fw-semibold mb-0">Daftar Materi</h1>
    </div>

    {{-- Tombol Tambah --}}
    <div class="d-flex justify-content-end mb-3">
      <a href="{{ route('admin.lessons.create') }}"
        class="btn btn-primary px-4 shadow-sm rounded-3 d-flex align-items-center gap-2">
        <i class="fas fa-plus"></i>
        <span>Tambah Materi</span>
      </a>
    </div>

    {{-- SweetAlert untuk success --}}
    @if(session('success'))
      <script>
        document.addEventListener('DOMContentLoaded', () => {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: @json(session('success')),
            timer: 2500,
            timerProgressBar: true,
            showConfirmButton: false,
            background: '#f8fbff',
            color: '#1e3a8a',
            iconColor: '#0d6efd',
            customClass: {
              popup: 'rounded-4 shadow-lg p-4',
              title: 'fw-bold fs-4 text-primary',
              htmlContainer: 'mt-2 fs-6',
            }
          });
        });
      </script>
    @endif

    {{-- Table --}}
    <div class="card border-0 shadow-sm rounded-4">
      <div class="card-body p-0">
        @if($lessons->count())
          <div class="table-responsive">
            <table class="table table-hover align-middle text-nowrap mb-0">
              <thead class="table-light">
                <tr>
                  <th>No</th>
                  <th>Kursus</th>
                  <th>Modul</th>
                  <th>Judul</th>
                  <th>Media</th>
                  <th>Durasi</th>
                  <th>Preview</th>
                  <th>Urutan</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @php $currentModule = null; @endphp
                @foreach($lessons as $lesson)
                  {{-- Header modul --}}
                  @if($currentModule !== $lesson->module_name)
                    <tr class="table-secondary">
                      <td colspan="11" class="fw-bold">
                        <i class="fas fa-layer-group me-2"></i> Modul: {{ $lesson->module_name }}
                      </td>
                    </tr>
                    @php $currentModule = $lesson->module_name; @endphp
                  @endif

                  @php
                    $mediaExt = strtolower(pathinfo($lesson->media, PATHINFO_EXTENSION));
                    $isImage = in_array($mediaExt, ['jpg', 'jpeg', 'png', 'webp']);
                    $isVideo = in_array($mediaExt, ['mp4', 'mov', 'avi', 'mkv']);
                  @endphp
                  <tr>
                    <td>{{ $loop->iteration + ($lessons->currentPage() - 1) * $lessons->perPage() }}</td>
                    <td>{{ optional($lesson->course)->name ?? '-' }}</td>
                    <td>{{ $lesson->module_name }}</td>
                    <td class="fw-semibold">{{ $lesson->title }}</td>
                    <td>
                      @if($lesson->media)
                        @if($isImage)
                          <img src="{{ asset('storage/' . $lesson->media) }}" alt="{{ $lesson->title }}"
                            class="img-thumbnail rounded shadow-sm" style="width: 80px; height: auto;">
                        @elseif($isVideo)
                          <video controls class="rounded" style="width: 100%; max-width: 200px; max-height: 150px;">
                            <source src="{{ asset('storage/' . $lesson->media) }}" type="video/{{ $mediaExt }}">
                            Browser Anda tidak mendukung pemutaran video.
                          </video>
                        @else
                          <span class="text-muted small fst-italic">Format tidak didukung</span>
                        @endif
                      @else
                        <span class="text-muted small fst-italic">Tidak ada</span>
                      @endif
                    </td>

                    <td>
                      @if($lesson->duration)
                        @php
                          $seconds = $lesson->duration;
                          if ($seconds >= 3600) {
                            $hours = floor($seconds / 3600);
                            $minutes = floor(($seconds % 3600) / 60);
                            $durationFormatted = $hours . ' jam' . ($minutes > 0 ? ' ' . $minutes . ' menit' : '');
                          } elseif ($seconds >= 60) {
                            $minutes = floor($seconds / 60);
                            $remainingSeconds = $seconds % 60;
                            $durationFormatted = $minutes . ' menit' . ($remainingSeconds > 0 ? ' ' . $remainingSeconds . ' detik' : '');
                          } else {
                            $durationFormatted = $seconds . ' detik';
                          }
                        @endphp
                        <span class="badge bg-info text-dark px-3 py-2 rounded-pill shadow-sm">
                          <i class="fas fa-clock me-1"></i> {{ $durationFormatted }}
                        </span>
                      @else
                        <span class="badge bg-secondary px-3 py-2 rounded-pill">-</span>
                      @endif
                    </td>
                    <td>
                      @if($lesson->is_preview)
                        <span class="badge bg-success px-3 py-2 rounded-pill"><i class="fas fa-check-circle me-1"></i> Ya</span>
                      @else
                        <span class="badge bg-secondary px-3 py-2 rounded-pill">Tidak</span>
                      @endif
                    </td>
                    <td>{{ $lesson->order }}</td>
                    <td class="text-center">
                      <div class="d-flex justify-content-center gap-2 flex-nowrap">
                        {{-- Lihat --}}
                        <a href="{{ route('admin.lessons.show', $lesson) }}"
                          class="btn btn-sm btn-outline-info shadow-sm rounded-3" title="Lihat">
                          <i class="fas fa-eye"></i>
                        </a>

                        {{-- Edit --}}
                        <a href="{{ route('admin.lessons.edit', $lesson) }}"
                          class="btn btn-sm btn-outline-warning shadow-sm rounded-3" title="Edit">
                          <i class="fas fa-edit"></i>
                        </a>

                        {{-- Hapus --}}
                        <button type="button" class="btn btn-sm btn-outline-danger shadow-sm rounded-3" data-bs-toggle="modal"
                          data-bs-target="#modalHapus{{ $lesson->id }}" title="Hapus">
                          <i class="fas fa-trash-alt"></i>
                        </button>

                        {{-- Modal Konfirmasi Hapus --}}
                        <div class="modal fade" id="modalHapus{{ $lesson->id }}" tabindex="-1"
                          aria-labelledby="modalHapusLabel{{ $lesson->id }}" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 shadow">
                              <div class="modal-header border-0">
                                <h5 class="modal-title">
                                  <i class="fas fa-exclamation-triangle text-danger me-2"></i>Konfirmasi Hapus
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                              </div>
                              <div class="modal-body">
                                Apakah Anda yakin ingin menghapus materi <strong>{{ $lesson->title }}</strong>?
                              </div>
                              <div class="modal-footer border-0">
                                <button type="button" class="btn btn-secondary rounded-3 px-3"
                                  data-bs-dismiss="modal">Batal</button>
                                <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" class="m-0"
                                  onsubmit="return showSpinner(this, {{ $lesson->id }})">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-danger rounded-3 px-3 d-flex align-items-center gap-2"
                                    id="btnDelete{{ $lesson->id }}">
                                    <span class="spinner-border spinner-border-sm me-2 d-none" role="status"
                                      aria-hidden="true" id="spinner{{ $lesson->id }}"></span>
                                    <span>Ya, Hapus</span>
                                  </button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        {{-- End Modal --}}
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          {{-- Pagination --}}
          <div class="mt-4 px-3">
            {{ $lessons->withQueryString()->links('vendor.pagination.bootstrap-5') }}
          </div>
        @else
          <div class="alert alert-secondary d-flex align-items-center gap-2 mb-0 rounded-3">
            <i class="fas fa-info-circle"></i>
            <span>Belum ada data materi yang tersedia.</span>
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function showSpinner(form, id) {
      const btn = form.querySelector(`#btnDelete${id}`);
      const spinner = form.querySelector(`#spinner${id}`);
      const btnText = btn.querySelector('span:last-child');

      spinner.classList.remove('d-none');
      btnText.textContent = 'Menghapus...';
      btn.disabled = true;

      return true;
    }
  </script>
@endpush