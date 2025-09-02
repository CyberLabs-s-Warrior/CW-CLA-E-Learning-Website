@extends('templates.app')
@section('title','Karya Member')

@section('content')
@php
  $q        = request('q', '');
  $sort     = request('sort', 'latest');   // latest|oldest|title
  $perPage  = (int) request('per_page', 10);
  $perPage  = in_array($perPage, [10,20,30,50]) ? $perPage : 10;
@endphp

<div class="container-fluid py-3 py-md-4">
  <!-- Header -->
  <div class="d-flex flex-column flex-md-row align-items-md-center gap-2 mb-3">
    <div>
      <h1 class="h4 mb-0">Karya Member</h1>
      <div class="text-muted small">Kelola karya yang dibuat oleh student. Gunakan pencarian & filter untuk mempercepat.</div>
    </div>
    <a href="{{ route('admin.showcases.create') }}" class="btn btn-primary ms-md-auto">
      <i class="fas fa-plus me-2"></i> Tambah Karya
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success rounded-3"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>
  @endif

  <!-- Toolbar: Search + Filters -->
  <form method="GET" action="{{ route('admin.showcases.index') }}" id="filterForm" class="card border-0 shadow-sm rounded-4 mb-3">
    <div class="card-body p-3 p-md-3">
      <div class="row g-2 align-items-center">
        <div class="col-12 col-lg-6">
          <div class="input-group">
            <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
            <input
              type="search"
              name="q"
              id="searchInput"
              value="{{ $q }}"
              class="form-control"
              placeholder="Cari judul atau nama student…"
              autocomplete="off">
            @if($q !== '')
              <button type="button" class="btn btn-outline-secondary" id="btnClear" title="Bersihkan">
                <i class="fas fa-times"></i>
              </button>
            @endif
          </div>
        </div>

        <div class="col-6 col-lg-2">
          <select name="sort" class="form-select" onchange="document.getElementById('filterForm').submit()">
            <option value="latest"  {{ $sort==='latest' ? 'selected' : '' }}>Terbaru</option>
            <option value="oldest"  {{ $sort==='oldest' ? 'selected' : '' }}>Terlama</option>
            <option value="title"   {{ $sort==='title'  ? 'selected' : '' }}>Judul A–Z</option>
          </select>
        </div>

        <div class="col-6 col-lg-2">
          <select name="per_page" class="form-select" onchange="document.getElementById('filterForm').submit()">
            @foreach([10,20,30,50] as $n)
              <option value="{{ $n }}" {{ $perPage===$n ? 'selected' : '' }}>{{ $n }}/hal</option>
            @endforeach
          </select>
        </div>

        <div class="col-12 col-lg-2 text-lg-end">
          <button class="btn btn-outline-primary w-100">
            <i class="fas fa-filter me-2"></i>Terapkan
          </button>
        </div>
      </div>

      @if($q !== '')
        <div class="mt-2 small text-muted">
          Menampilkan hasil untuk: <span class="fw-semibold">“{{ $q }}”</span>
        </div>
      @endif
    </div>
  </form>

  <!-- Tabel -->
  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width:92px;">Cover</th>
              <th>Judul</th>
              <th style="width:22%;">Pembuat</th>
              <th style="width:14%;">Dibuat</th>
              <th class="text-end" style="width:120px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
          @forelse($showcases as $s)
            <tr>
              <td>
                <div class="ratio ratio-16x9 rounded overflow-hidden bg-light" style="width: 88px;">
                  <img
                    src="{{ $s->image_path ? asset('storage/'.$s->image_path) : asset('images/default.png') }}"
                    class="w-100 h-100 object-fit-cover"
                    onerror="this.src='{{ asset('images/default.png') }}';"
                    alt="cover">
                </div>
              </td>
              <td>
                <div class="fw-semibold">{{ $s->title }}</div>
                <div class="text-muted small text-truncate" style="max-width:460px;">
                  {{ Str::limit(strip_tags($s->description), 120) }}
                </div>
              </td>
              <td>
                <div>{{ $s->user->name ?? '-' }}</div>
                <div class="text-muted small">{{ $s->user->email ?? '' }}</div>
              </td>
              <td>
                <div>{{ $s->created_at?->format('d M Y') }}</div>
                <div class="text-muted small">{{ $s->created_at?->diffForHumans() }}</div>
              </td>
              <td class="text-end">
                <a href="{{ route('admin.showcases.edit', $s) }}" class="btn btn-sm btn-outline-warning">
                  <i class="fas fa-pen"></i>
                </a>
                <form action="{{ route('admin.showcases.destroy', $s) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Hapus karya ini?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-muted py-5">
                <div class="mb-2"><i class="far fa-folder-open fa-2x"></i></div>
                Belum ada data. <a href="{{ route('admin.showcases.create') }}">Tambah karya pertama</a>.
              </td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>

    @if($showcases->hasPages())
      <div class="card-footer d-flex flex-column flex-md-row align-items-md-center gap-2 justify-content-between">
        <div class="small text-muted">
          Menampilkan {{ $showcases->firstItem() }}–{{ $showcases->lastItem() }} dari {{ $showcases->total() }} data
        </div>
        <div>
          {{ $showcases->appends(request()->query())->links() }}
        </div>
      </div>
    @endif
  </div>
</div>
@endsection

@push('styles')
<style>
  .rounded-4{ border-radius: 1rem; }
  .object-fit-cover{ object-fit: cover; }
</style>
@endpush

@push('scripts')
<script>
  // Clear search
  document.getElementById('btnClear')?.addEventListener('click', function(){
    const q = document.getElementById('searchInput');
    q.value = '';
    q.form.submit();
  });

  // Debounce submit when typing search
  (function(){
    const input = document.getElementById('searchInput');
    if(!input) return;
    let t = null;
    input.addEventListener('input', function(){
      clearTimeout(t);
      t = setTimeout(() => input.form.submit(), 450);
    });
  })();
</script>
@endpush
