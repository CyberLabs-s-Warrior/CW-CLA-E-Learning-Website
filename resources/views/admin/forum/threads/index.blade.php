@extends('templates.app')
@section('title','Forum — Threads')

@section('content')
<style>
  .chip{display:inline-flex;align-items:center;height:22px;padding:0 8px;border-radius:999px;font-size:11px;font-weight:800}
  .chip-pin{background:rgba(245,158,11,.15);color:#92400e;border:1px solid rgba(245,158,11,.35)}
  .chip-lock{background:rgba(100,116,139,.15);color:#334155;border:1px solid rgba(100,116,139,.35)}
  .filters .form-control, .filters .form-select{min-width: 160px;}
  .table td { vertical-align: middle; }
  .ellipsis { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
  .modal-lg { max-width: 960px; }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="mb-0 fw-bold">Threads</h1>
  <div class="d-flex gap-2">
    <a href="{{ route('forum.index') }}" class="btn btn-outline-primary" target="_blank">
      <i class="fa fa-external-link-alt me-1"></i> Lihat Forum Publik
    </a>
    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#trashThreadsModal">
      <i class="fa fa-trash me-1"></i> Tong Sampah
    </button>
  </div>
</div>

@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

<div class="card mb-3">
  <div class="card-body">
    <form method="GET" class="row g-2 align-items-end filters">
      <div class="col-12 col-md-auto">
        <label class="form-label">Cari</label>
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="judul / isi">
      </div>
      <div class="col-12 col-md-auto">
        <label class="form-label">Kategori</label>
        <select name="category_id" class="form-select">
          <option value="">Semua</option>
          @foreach($categories as $c)
            <option value="{{ $c->id }}" @selected(request('category_id')==$c->id)>{{ $c->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-12 col-md-auto">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="">Semua</option>
          <option value="pinned" @selected(request('status')=='pinned')>Pinned</option>
          <option value="locked" @selected(request('status')=='locked')>Locked</option>
          <option value="trashed" @selected(request('status')=='trashed')>Trashed</option>
          <option value="all" @selected(request('status')=='all')>All (+trashed)</option>
        </select>
      </div>
      <div class="col-12 col-md-auto">
        <button class="btn btn-primary">Filter</button>
        <a href="{{ route('admin.forum.threads.index') }}" class="btn btn-outline-secondary">Reset</a>
      </div>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-body table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
          <th>Judul</th>
          <th>Kategori</th>
          <th>Pembuat</th>
          <th>Balasan</th>
          <th>Update Terakhir</th>
          <th>Status</th>
          <th style="width: 320px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
      @forelse($threads as $t)
        <tr @if($t->trashed()) class="table-warning" @endif>
          <td>
            <div class="fw-semibold">{{ $t->title }}</div>
            <div class="text-muted small ellipsis">{{ Str::limit($t->body, 120) }}</div>
          </td>
          <td>{{ $t->category->name ?? '-' }}</td>
          <td>{{ $t->user->name ?? '-' }}</td>
          <td>{{ $t->posts_count }}</td>
          <td class="text-muted small">{{ $t->updated_at->format('d M Y H:i') }}</td>
          <td>
            @if($t->pinned_at)<span class="chip chip-pin me-1">Pinned</span>@endif
            @if($t->is_locked)<span class="chip chip-lock">Locked</span>@endif
            @if($t->trashed())<span class="badge text-bg-secondary ms-1">Deleted</span>@endif
          </td>
          <td>
            <div class="d-flex flex-wrap gap-2">
              <a class="btn btn-sm btn-outline-primary"
                 href="{{ route('forum.thread.show',['id'=>$t->id,'slug'=>\Illuminate\Support\Str::slug($t->title)]) }}"
                 target="_blank">View</a>

              {{-- Pin/Unpin (moderator routes) --}}
              <form method="POST" action="{{ $t->pinned_at ? route('forum.mod.unpin',$t->id) : route('forum.mod.pin',$t->id) }}">
                @csrf
                <button class="btn btn-sm {{ $t->pinned_at ? 'btn-outline-warning':'btn-warning' }}">
                  {{ $t->pinned_at ? 'Unpin':'Pin' }}
                </button>
              </form>

              {{-- Lock/Unlock --}}
              <form method="POST" action="{{ $t->is_locked ? route('forum.mod.unlock',$t->id) : route('forum.mod.lock',$t->id) }}">
                @csrf
                <button class="btn btn-sm {{ $t->is_locked ? 'btn-outline-secondary':'btn-secondary' }}">
                  {{ $t->is_locked ? 'Unlock':'Lock' }}
                </button>
              </form>

              {{-- Delete / Restore --}}
              @if(!$t->trashed())
                <form method="POST" action="{{ route('admin.forum.threads.destroy',$t->id) }}"
                      onsubmit="return confirm('Arsipkan thread ini?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash me-1"></i> Hapus</button>
                </form>
              @else
                <form method="POST" action="{{ route('admin.forum.threads.restore',$t->id) }}">
                  @csrf
                  <button class="btn btn-sm btn-success">Pulihkan</button>
                </form>
              @endif
            </div>
          </td>
        </tr>
      @empty
        <tr><td colspan="7" class="text-muted">Belum ada thread.</td></tr>
      @endforelse
      </tbody>
    </table>
    {{ $threads->links() }}
  </div>
</div>

{{-- ========== Modal Tong Sampah (Threads) ========== --}}
<div class="modal fade" id="trashThreadsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-trash me-2"></i>Tong Sampah — Threads</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="tt-select-all">
            <label class="form-check-label" for="tt-select-all">Pilih Semua</label>
          </div>
          <div class="d-flex gap-2">
            <button class="btn btn-sm btn-success" id="tt-restore"><i class="fa fa-undo me-1"></i>Pulihkan</button>
            <button class="btn btn-sm btn-danger"  id="tt-force"><i class="fa fa-times me-1"></i>Hapus Permanen</button>
          </div>
        </div>
        <div class="table-responsive border rounded">
          <table class="table align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th style="width:32px;"></th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Author</th>
                <th>Deleted</th>
              </tr>
            </thead>
            <tbody id="tt-body">
              <tr><td colspan="5" class="text-muted py-4 text-center">Memuat…</td></tr>
            </tbody>
          </table>
        </div>
        <div class="small text-muted mt-2">Catatan: Hapus permanen tidak bisa dibatalkan.</div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
(function(){
  const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

  // ====== Trash Threads Modal ======
  const modalEl  = document.getElementById('trashThreadsModal');
  const tbody    = document.getElementById('tt-body');
  const selAll   = document.getElementById('tt-select-all');
  const btnRes   = document.getElementById('tt-restore');
  const btnForce = document.getElementById('tt-force');

  modalEl?.addEventListener('shown.bs.modal', loadTrashedThreads);

  async function loadTrashedThreads(){
    tbody.innerHTML = `<tr><td colspan="5" class="text-muted py-4 text-center">Memuat…</td></tr>`;
    try{
      const res = await fetch(`{{ route('admin.forum.threads.trashedList') }}`);
      const json = await res.json();
      renderTrashed(json.data || []);
    }catch(e){
      tbody.innerHTML = `<tr><td colspan="5" class="text-danger py-4 text-center">Gagal memuat.</td></tr>`;
    }
  }

  function renderTrashed(items){
    if(!items.length){
      tbody.innerHTML = `<tr><td colspan="5" class="text-muted py-4 text-center">Kosong.</td></tr>`;
      return;
    }
    tbody.innerHTML = items.map(it => `
      <tr>
        <td><input class="form-check-input tt-row" type="checkbox" value="${it.id}"></td>
        <td class="fw-semibold">${escapeHtml(it.title || '-')}</td>
        <td>${escapeHtml(it.category || '-')}</td>
        <td>${escapeHtml(it.author || '-')}</td>
        <td class="text-muted small">${escapeHtml(it.deleted_at || '-')}</td>
      </tr>
    `).join('');
    selAll.checked = false;
  }

  selAll?.addEventListener('change', () => {
    tbody.querySelectorAll('.tt-row').forEach(cb => cb.checked = selAll.checked);
  });

  btnRes?.addEventListener('click', () => bulkAction('restore'));
  btnForce?.addEventListener('click', () => {
    if(confirm('Hapus permanen item terpilih? Tindakan ini tidak bisa dibatalkan.')){
      bulkAction('force');
    }
  });

  async function bulkAction(kind){
    const ids = Array.from(tbody.querySelectorAll('.tt-row:checked')).map(cb => Number(cb.value));
    if(!ids.length) return alert('Belum ada yang dipilih.');

    const url = kind === 'restore'
      ? `{{ route('admin.forum.threads.bulkRestore') }}`
      : `{{ route('admin.forum.threads.bulkForceDelete') }}`;

    const res = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
      body: JSON.stringify({ ids })
    });

    if(res.ok){
      await loadTrashedThreads();
      // refresh page data
      location.reload();
    }else{
      alert('Gagal memproses.');
    }
  }

  function escapeHtml(s){
    return (s||'').toString().replace(/[&<>"']/g, m => ({
      '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'
    }[m]));
  }
})();
</script>
@endpush
@endsection
