@extends('templates.app')
@section('title','Forum — Posts')

@section('content')
<style>
  .filters .form-control, .filters .form-select { min-width: 220px; }
  .table td { vertical-align: middle; }
  .ellipsis { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; max-width: 560px; }
  .table thead th { position: sticky; top: 0; z-index: 1; background: var(--bs-table-bg, #fff); }
  .row-deleted { opacity: .85; }
  .modal-lg { max-width: 960px; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h3 mb-0 fw-bold text-dark">Posts</h1>
  <div class="d-flex gap-2">
    <a href="{{ route('forum.index') }}" class="btn btn-outline-primary shadow-sm" target="_blank">
      <i class="fa fa-external-link-alt me-1"></i> Lihat Forum Publik
    </a>
    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#trashPostsModal">
      <i class="fa fa-trash me-1"></i> Tong Sampah
    </button>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
    <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

{{-- Filter --}}
<div class="card mb-3 shadow-sm border-0">
  <div class="card-body">
    <form method="GET" class="row g-3 align-items-end filters">
      <div class="col-12 col-md-auto">
        <label class="form-label">Cari</label>
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="isi balasan">
      </div>
      <div class="col-12 col-md-auto">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="">Semua</option>
          <option value="trashed" @selected(request('status')=='trashed')>Trashed</option>
          <option value="all" @selected(request('status')=='all')>All (+trashed)</option>
        </select>
      </div>
      <div class="col-12 col-md-auto">
        <button class="btn btn-primary"><i class="fa fa-filter me-1"></i> Filter</button>
        <a href="{{ route('admin.forum.posts.index') }}" class="btn btn-outline-secondary">Reset</a>
      </div>
      @if(request('q') || request('status'))
        <div class="col-12">
          <div class="small text-muted">
            Menampilkan hasil untuk:
            @if(request('q')) <span class="badge text-bg-light me-1">q: “{{ request('q') }}”</span>@endif
            @if(request('status')) <span class="badge text-bg-light">status: {{ request('status') }}</span>@endif
          </div>
        </div>
      @endif
    </form>
  </div>
</div>

{{-- Tabel --}}
<div class="card shadow-sm border-0">
  <div class="card-header bg-light fw-semibold">Daftar Post</div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-secondary">
          <tr>
            <th>Cuplikan</th>
            <th>Thread</th>
            <th>Pembuat</th>
            <th>Waktu</th>
            <th>Status</th>
            <th class="text-center" style="width:260px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($posts as $p)
            @php
              $threadUrl = $p->thread
                ? route('forum.thread.show', ['id'=>$p->thread->id, 'slug'=>\Illuminate\Support\Str::slug($p->thread->title)])
                : null;
            @endphp
            <tr class="{{ $p->trashed() ? 'table-warning row-deleted' : '' }}">
              <td><div class="ellipsis">{{ Str::limit($p->body, 200) }}</div></td>
              <td>
                @if($p->thread)
                  <a href="{{ $threadUrl }}" target="_blank" class="text-decoration-none">
                    {{ Str::limit($p->thread->title, 70) }}
                    <i class="fa fa-external-link-alt ms-1 small text-muted"></i>
                  </a>
                @else <span class="text-muted">-</span> @endif
              </td>
              <td>{{ $p->user->name ?? '-' }}</td>
              <td class="text-muted small"><i class="fa fa-clock me-1"></i>{{ $p->created_at->format('d M Y H:i') }}</td>
              <td>
                @if($p->trashed())
                  <span class="badge text-bg-secondary">Deleted</span>
                @else
                  <span class="badge text-bg-success">Aktif</span>
                @endif
              </td>
              <td class="text-center">
                <div class="d-flex flex-wrap gap-2 justify-content-center">
                  @if($p->thread)
                    <a class="btn btn-sm btn-outline-primary" href="{{ $threadUrl }}" target="_blank">
                      <i class="fa fa-eye me-1"></i> Lihat
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-dark"
                            data-copy="{{ $threadUrl }}" onclick="copyLink(this)">
                      <i class="fa fa-link me-1"></i> Copy Link
                    </button>
                  @endif

                  @if(!$p->trashed())
                    <form method="POST" action="{{ route('admin.forum.posts.destroy',$p->id) }}"
                          onsubmit="return confirm('Arsipkan balasan ini?')"
                          class="inline-action">
                      @csrf @method('DELETE')
                      <button class="btn btn-sm btn-outline-danger">
                        <i class="fa fa-trash me-1"></i> Hapus
                      </button>
                    </form>
                  @else
                    <form method="POST" action="{{ route('admin.forum.posts.restore',$p->id) }}" class="inline-action">
                      @csrf
                      <button class="btn btn-sm btn-success">
                        <span class="action-label"><i class="fa fa-undo me-1"></i> Pulihkan</span>
                        <span class="action-loading d-none">
                          <span class="spinner-border spinner-border-sm me-2"></span>Memproses…
                        </span>
                      </button>
                    </form>
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted py-5">
                <i class="fa fa-comments me-2"></i> Belum ada post.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div class="card-footer">
    {{ $posts->links() }}
  </div>
</div>

{{-- ========== Modal Tong Sampah (Posts) ========== --}}
<div class="modal fade" id="trashPostsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-trash me-2"></i>Tong Sampah — Posts</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="tp-select-all">
            <label class="form-check-label" for="tp-select-all">Pilih Semua</label>
          </div>
          <div class="d-flex gap-2">
            <button class="btn btn-sm btn-success" id="tp-restore"><i class="fa fa-undo me-1"></i>Pulihkan</button>
            <button class="btn btn-sm btn-danger"  id="tp-force"><i class="fa fa-times me-1"></i>Hapus Permanen</button>
          </div>
        </div>
        <div class="table-responsive border rounded">
          <table class="table align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th style="width:32px;"></th>
                <th>Thread</th>
                <th>Author</th>
                <th>Cuplikan</th>
                <th>Deleted</th>
              </tr>
            </thead>
            <tbody id="tp-body">
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
  // Copy to clipboard
  function copyLink(btn) {
    const link = btn.getAttribute('data-copy');
    if (!link) return;
    navigator.clipboard?.writeText(link).then(() => {
      const original = btn.innerHTML;
      btn.innerHTML = '<i class="fa fa-check me-1"></i> Copied!';
      btn.disabled = true;
      setTimeout(() => { btn.innerHTML = original; btn.disabled = false; }, 1400);
    });
  }

  // Anti double-submit (untuk tombol dalam form aksi kecil)
  document.querySelectorAll('form.inline-action').forEach(f => {
    f.addEventListener('submit', function() {
      const btn = f.querySelector('button');
      const label = btn?.querySelector('.action-label');
      const loading = btn?.querySelector('.action-loading');
      btn?.setAttribute('disabled', 'disabled');
      if (label && loading) { label.classList.add('d-none'); loading.classList.remove('d-none'); }
    });
  });

  (function(){
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // ====== Trash Posts Modal ======
    const modalEl  = document.getElementById('trashPostsModal');
    const tbody    = document.getElementById('tp-body');
    const selAll   = document.getElementById('tp-select-all');
    const btnRes   = document.getElementById('tp-restore');
    const btnForce = document.getElementById('tp-force');

    modalEl?.addEventListener('shown.bs.modal', loadTrashedPosts);

    async function loadTrashedPosts(){
      tbody.innerHTML = `<tr><td colspan="5" class="text-muted py-4 text-center">Memuat…</td></tr>`;
      try{
        const res = await fetch(`{{ route('admin.forum.posts.trashedList') }}`);
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
          <td><input class="form-check-input tp-row" type="checkbox" value="${it.id}"></td>
          <td class="fw-semibold">${escapeHtml(it.thread || '-')}</td>
          <td>${escapeHtml(it.author || '-')}</td>
          <td>${escapeHtml(it.excerpt || '-')}</td>
          <td class="text-muted small">${escapeHtml(it.deleted_at || '-')}</td>
        </tr>
      `).join('');
      selAll.checked = false;
    }

    selAll?.addEventListener('change', () => {
      tbody.querySelectorAll('.tp-row').forEach(cb => cb.checked = selAll.checked);
    });

    btnRes?.addEventListener('click', () =>
  bulkAction('restore', '#tp-body', {
    restore: `{{ route('admin.forum.posts.bulkRestore') }}`,
    force:   `{{ route('admin.forum.posts.bulkForceDelete') }}`
  })
);
    btnForce?.addEventListener('click', () => {
  if (confirm('Hapus permanen item terpilih? Tindakan ini tidak bisa dibatalkan.')) {
    bulkAction('force', '#tp-body', {
      restore: `{{ route('admin.forum.posts.bulkRestore') }}`,
      force:   `{{ route('admin.forum.posts.bulkForceDelete') }}`
    });
  }
});

async function bulkAction(kind, bodySelector, urls) {
  const meta = document.querySelector('meta[name="csrf-token"]');
  const token = meta ? meta.content : null;

  const tbody = document.querySelector(bodySelector);
  const ids = Array.from(tbody.querySelectorAll('input[type="checkbox"]:checked'))
    .map(cb => Number(cb.value));

  if (!ids.length) { alert('Belum ada yang dipilih.'); return; }

  const url = kind === 'restore' ? urls.restore : urls.force;

  try {
    const res = await fetch(url, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token || ''   // <= penting
      },
      credentials: 'same-origin',      // <= aman untuk kirim cookie session kalau perlu
      body: JSON.stringify({ ids })
    });

    if (!res.ok) {
      const text = await res.text();
      // Biar jelas apa yang salah:
      console.error('Bulk action error', res.status, text);

      if (res.status === 419)       alert('Gagal memproses (CSRF 419). Pastikan meta CSRF ada di layout.');
      else if (res.status === 403)  alert('Gagal memproses (403). Akses butuh role admin/superadmin.');
      else if (res.status === 404)  alert('Gagal memproses (404). Route tidak ditemukan.');
      else                          alert('Gagal memproses. (HTTP ' + res.status + ')');
      return;
    }

    // sukses
    location.reload();
  } catch (e) {
    console.error(e);
    alert('Gagal memproses (network error).');
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
