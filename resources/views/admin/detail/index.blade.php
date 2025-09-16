@extends('templates.app')
@section('title', 'Daftar Kursus Detail')

@section('content')
<div class="container-fluid py-4">

  {{-- Header --}}
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-gradient-primary text-black rounded-circle d-flex align-items-center justify-content-center shadow"
        style="width:48px;height:48px;">
        <i class="fas fa-book-open"></i>
      </div>
    </div>
    <div>
      <h1 class="h4 fw-bold mb-0">Manajemen Kursus Detail</h1>
      <p class="text-muted small mb-0">Kelola kursus, mentor, dan modul pembelajaran</p>
    </div>
  </div>

  {{-- Tombol Tambah --}}
  <div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.detail.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
      <i class="fas fa-plus me-2"></i>Tambah Kursus
    </a>
  </div>

  {{-- Filter --}}
  <div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body">
      <form method="GET" action="{{ route('admin.detail.index') }}" class="row g-3 align-items-end">

        {{-- Search --}}
        <div class="col-md-4">
          <label class="form-label fw-semibold">Cari Kursus</label>
          <input type="text" name="search" value="{{ request('search') }}" 
            class="form-control rounded-pill shadow-sm" placeholder="Judul / Mentor">
        </div>

        {{-- Filter Level --}}
        <div class="col-md-3">
          <label class="form-label fw-semibold">Level</label>
          <select name="level" class="form-select rounded-pill shadow-sm">
            <option value="">Semua</option>
            @foreach($levels as $level)
              <option value="{{ $level->id }}" {{ request('level') == $level->id ? 'selected' : '' }}>
                {{ $level->level }}
              </option>
            @endforeach
          </select>
        </div>

        {{-- Sort Duration --}}
        <div class="col-md-3">
          <label class="form-label fw-semibold">Urutkan Durasi</label>
          <select name="sort" class="form-select rounded-pill shadow-sm">
            <option value="">Default</option>
            <option value="shortest" {{ request('sort') == 'shortest' ? 'selected' : '' }}>Terpendek</option>
            <option value="longest" {{ request('sort') == 'longest' ? 'selected' : '' }}>Terpanjang</option>
          </select>
        </div>

        {{-- Button --}}
        <div class="col-md-2 d-flex gap-2">
          <button type="submit" class="btn btn-primary rounded-pill w-100 shadow-sm">
            <i class="fas fa-filter me-1"></i> Filter
          </button>
          <a href="{{ route('admin.detail.index') }}" class="btn btn-light border rounded-pill w-100 shadow-sm">
            <i class="fas fa-undo me-1"></i> Reset
          </a>
        </div>
      </form>
    </div>
  </div>

  {{-- Alert success --}}
  @if(session('success'))
    <script>
      document.addEventListener('DOMContentLoaded', () => Swal.fire({
        icon: 'success', title: 'Berhasil!', text: @json(session('success')),
        timer: 2500, timerProgressBar: true, showConfirmButton: false,
        background: '#f8fbff', color: '#1e3a8a', iconColor: '#0d6efd',
        customClass: { popup: 'rounded-4 shadow-lg p-4', title: 'fw-bold fs-4 text-primary', htmlContainer: 'mt-2 fs-6' }
      }));
    </script>
  @endif

  {{-- Tabel --}}
  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
      @if($details->count())
        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead class="bg-light text-secondary small text-uppercase">
              <tr>
                <th>No</th>
                <th>Media</th>
                <th>Judul</th>
                <th>Level</th>
                <th>Durasi</th>
                <th>Modul</th>
                <th>Mentor</th>
                <th>Deskripsi</th>
                <th>Hasil</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($details as $detail)
                <tr class="hover-bg-light">
                  {{-- No --}}
                  <td>{{ $loop->iteration + ($details->currentPage() - 1) * $details->perPage() }}</td>

                  {{-- Media --}}
                  <td>
                    @if($detail->course->img)
                      <img src="{{ asset('storage/' . $detail->course->img) }}" alt="cover" 
                        class="rounded shadow-sm" style="width:60px; height:60px; object-fit:cover;">
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>

                  {{-- Judul --}}
                  <td class="fw-semibold">{{ \Illuminate\Support\Str::limit($detail->course->name ?? '-', 40) }}</td>

                  {{-- Level --}}
                  <td>
                    <span class="badge rounded-pill bg-info text-dark">
                      {{ $detail->course->level->level ?? 'N/A' }}
                    </span>
                  </td>

                  {{-- Durasi --}}
                  <td>
                    @if($detail->total_duration)
                      <span class="badge bg-light text-dark border">
                        {{ gmdate('H:i:s', $detail->total_duration) }}
                      </span>
                    @else
                      -
                    @endif
                  </td>

                  {{-- Modul --}}
                  <td>{{ $detail->course->lessons->count() }}</td>

                  {{-- Mentor --}}
                  <td>
                    @if($detail->instructors->isNotEmpty())
                      @foreach($detail->instructors as $ins)
                        <span class="badge bg-primary-subtle text-primary fw-semibold">
                          {{ $ins->user->name }}
                        </span>
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
                        class="btn btn-sm btn-outline-info rounded-pill px-3"><i class="fas fa-eye"></i></a>
                      <a href="{{ route('admin.detail.edit', $detail) }}" 
                        class="btn btn-sm btn-outline-warning rounded-pill px-3"><i class="fas fa-edit"></i></a>
                      <button class="btn btn-sm btn-outline-danger rounded-pill px-3" data-bs-toggle="modal"
                        data-bs-target="#modalHapus{{ $detail->id }}"><i class="fas fa-trash-alt"></i></button>
                    </div>
                  </td>
                </tr>

                {{-- Modal Hapus --}}
                <div class="modal fade" id="modalHapus{{ $detail->id }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4 shadow">
                      <div class="modal-header border-0">
                        <h5 class="modal-title"><i class="fas fa-exclamation-triangle text-danger me-2"></i>Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
                        <p class="mb-0">Apakah Anda yakin ingin menghapus kursus
                          <strong>{{ $detail->course->name ?? '-' }}</strong>?
                        </p>
                      </div>
                      <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light rounded-pill px-3"
                          data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('admin.detail.destroy', $detail) }}" method="POST"
                          onsubmit="return showSpinner(this,{{ $detail->id }})">
                          @csrf @method('DELETE')
                          <button type="submit" class="btn btn-danger rounded-pill px-3 d-flex align-items-center gap-2"
                            id="btnDelete{{ $detail->id }}">
                            <span class="spinner-border spinner-border-sm me-2 d-none" id="spinner{{ $detail->id }}"></span>
                            <span>Ya, Hapus</span>
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="mt-4 px-3">{{ $details->links('vendor.pagination.bootstrap-5') }}</div>
      @else
        <div class="alert alert-light border d-flex align-items-center gap-2 mb-0 rounded-3 shadow-sm">
          <i class="fas fa-info-circle text-secondary"></i> 
          <span>Belum ada data kursus detail.</span>
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
    const btn = form.querySelector('#btnDelete' + id),
          spinner = form.querySelector('#spinner' + id),
          text = btn.querySelector('span:last-child');
    spinner.classList.remove('d-none');
    text.textContent = 'Menghapus...';
    btn.disabled = true;
    return true;
  }
</script>
@endpush
