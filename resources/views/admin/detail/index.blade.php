@extends('templates.app')
@section('title', 'Daftar Kursus Detail')

@section('content')
  <div class="container-fluid py-4">
    <div class="d-flex align-items-center mb-4">
      <div class="me-2">
        <div
          class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm"
          style="width:40px;height:40px;">
          <i class="fas fa-book-open"></i>
        </div>
      </div>
      <h1 class="h4 fw-semibold mb-0">Manajemen Kursus Detail</h1>
    </div>

    <div class="d-flex justify-content-end mb-3">
      <a href="{{ route('admin.detail.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
        <i class="fas fa-plus me-2"></i>Tambah Kursus
      </a>
    </div>

    @if(session('success'))
      <script>
        document.addEventListener('DOMContentLoaded', () => Swal.fire({
          icon: 'success', title: 'Berhasil!', text: @json(session('success')),
          timer: 2500, timerProgressBar: true, showConfirmButton: false,
          background: 'linear-gradient(145deg,#e6f0ff,#f8fbff)', color: '#1e3a8a', iconColor: '#0d6efd',
          customClass: { popup: 'rounded-4 shadow-lg p-4', title: 'fw-bold fs-4 text-primary', htmlContainer: 'mt-2 fs-6' }
        }));
      </script>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
      <div class="card-body p-0">
        @if($details->count())
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th>No</th>
                  <th>Media</th>
                  <th>Judul</th>
                  <th>Level</th>
                  <th>Duration</th>
                  <th>Modul</th>
                  <th>Mentor</th>
                  <th>Deskripsi</th>
                  <th>Hasil</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($details as $detail)
                  <tr>
                    {{-- No --}}
                    <td>{{ $loop->iteration + ($details->currentPage() - 1) * $details->perPage() }}</td>

                    {{-- Media --}}
                    <td>
                      @if($detail->course->img)
                        <img src="{{ asset('storage/' . $detail->course->img) }}" alt="cover" class="rounded shadow-sm"
                          style="width:60px; height:60px; object-fit:cover;">
                      @else
                        <span class="text-muted">-</span>
                      @endif
                    </td>

                    {{-- Judul --}}
                    <td class="fw-semibold">{{ \Illuminate\Support\Str::limit($detail->course->name ?? '-', 40) }}</td>

                    {{-- Level --}}
                    <td>{{ $detail->course->level->level ?? 'Tidak ada level' }}</td>

                    {{-- Duration --}}
                    <td>{{ $detail->course->formatted_duration ?? '-' }}</td>

                    {{-- Modul (lessons) --}}
                    <td>
                      <ul class="mb-0 small text-muted ps-3">
                        @foreach($detail->course->lessons as $lesson)
                          <li>{{ $lesson->title }} ({{ $lesson->formatted_duration }})</li>
                        @endforeach
                      </ul>
                    </td>

                    <td>
                      @if($detail->instructors->isNotEmpty())
                        @foreach($detail->instructors as $ins)
                          <span class="badge bg-primary">{{ $ins->user->name }}</span>
                        @endforeach
                      @else
                        <span class="text-muted">-</span>
                      @endif
                    </td>

                    {{-- Deskripsi --}}
                    <td>{!! \Illuminate\Support\Str::limit($detail->description, 75) !!}</td>

                    {{-- Hasil --}}
                    <td>{!! \Illuminate\Support\Str::limit($detail->outcomes, 75) !!}</td>

                    {{-- Aksi --}}
                    <td class="text-center">
                      <div class="d-flex flex-wrap justify-content-center gap-2">
                        <a href="{{ route('admin.detail.show', $detail) }}"
                          class="btn btn-sm btn-outline-info rounded-pill px-3 shadow-sm"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.detail.edit', $detail) }}"
                          class="btn btn-sm btn-outline-warning rounded-pill px-3 shadow-sm"><i class="fas fa-edit"></i></a>
                        <button class="btn btn-sm btn-outline-danger rounded-pill px-3 shadow-sm" data-bs-toggle="modal"
                          data-bs-target="#modalHapus{{ $detail->id }}"><i class="fas fa-trash-alt"></i></button>

                        {{-- Modal Hapus --}}
                        <div class="modal fade" id="modalHapus{{ $detail->id }}" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 shadow">
                              <div class="modal-header border-0">
                                <h5 class="modal-title"><i class="fas fa-exclamation-triangle text-danger me-2"></i>Konfirmasi
                                  Hapus</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>
                              <div class="modal-body">
                                <p class="mb-0">Apakah Anda yakin ingin menghapus kursus
                                  <strong>{{ $detail->course->name ?? '-' }}</strong>?
                                </p>
                              </div>
                              <div class="modal-footer border-0">
                                <button type="button" class="btn btn-secondary rounded-pill px-3"
                                  data-bs-dismiss="modal">Batal</button>
                                <form action="{{ route('admin.detail.destroy', $detail) }}" method="POST"
                                  onsubmit="return showSpinner(this,{{ $detail->id }})">
                                  @csrf @method('DELETE')
                                  <button type="submit"
                                    class="btn btn-danger rounded-pill px-3 d-flex align-items-center gap-2"
                                    id="btnDelete{{ $detail->id }}">
                                    <span class="spinner-border spinner-border-sm me-2 d-none"
                                      id="spinner{{ $detail->id }}"></span>
                                    <span>Ya, Hapus</span>
                                  </button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="mt-4 px-3">{{ $details->links('vendor.pagination.bootstrap-5') }}</div>
        @else
          <div class="alert alert-secondary d-flex align-items-center gap-2 mb-0 rounded-3">
            <i class="fas fa-info-circle"></i> <span>Belum ada data kursus detail.</span>
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
      const btn = form.querySelector('#btnDelete' + id), spinner = form.querySelector('#spinner' + id), text = btn.querySelector('span:last-child');
      spinner.classList.remove('d-none'); text.textContent = 'Menghapus...'; btn.disabled = true; return true;
    }
  </script>
@endpush