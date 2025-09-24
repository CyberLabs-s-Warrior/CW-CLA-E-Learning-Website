
<?php $__env->startSection('title','Forum — Threads'); ?>

<?php $__env->startSection('content'); ?>
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
    <a href="<?php echo e(route('forum.index')); ?>" class="btn btn-outline-primary" target="_blank">
      <i class="fa fa-external-link-alt me-1"></i> Lihat Forum Publik
    </a>
    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#trashThreadsModal">
      <i class="fa fa-trash me-1"></i> Tong Sampah
    </button>
  </div>
</div>

<?php if(session('success')): ?> <div class="alert alert-success"><?php echo e(session('success')); ?></div> <?php endif; ?>

<div class="card mb-3">
  <div class="card-body">
    <form method="GET" class="row g-2 align-items-end filters">
      <div class="col-12 col-md-auto">
        <label class="form-label">Cari</label>
        <input type="text" name="q" value="<?php echo e(request('q')); ?>" class="form-control" placeholder="judul / isi">
      </div>
      <div class="col-12 col-md-auto">
        <label class="form-label">Kategori</label>
        <select name="category_id" class="form-select">
          <option value="">Semua</option>
          <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($c->id); ?>" <?php if(request('category_id')==$c->id): echo 'selected'; endif; ?>><?php echo e($c->name); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
      <div class="col-12 col-md-auto">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="">Semua</option>
          <option value="pinned" <?php if(request('status')=='pinned'): echo 'selected'; endif; ?>>Pinned</option>
          <option value="locked" <?php if(request('status')=='locked'): echo 'selected'; endif; ?>>Locked</option>
          <option value="trashed" <?php if(request('status')=='trashed'): echo 'selected'; endif; ?>>Trashed</option>
          <option value="all" <?php if(request('status')=='all'): echo 'selected'; endif; ?>>All (+trashed)</option>
        </select>
      </div>
      <div class="col-12 col-md-auto">
        <button class="btn btn-primary">Filter</button>
        <a href="<?php echo e(route('admin.forum.threads.index')); ?>" class="btn btn-outline-secondary">Reset</a>
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
      <?php $__empty_1 = true; $__currentLoopData = $threads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr <?php if($t->trashed()): ?> class="table-warning" <?php endif; ?>>
          <td>
            <div class="fw-semibold"><?php echo e($t->title); ?></div>
            <div class="text-muted small ellipsis"><?php echo e(Str::limit($t->body, 120)); ?></div>
          </td>
          <td><?php echo e($t->category->name ?? '-'); ?></td>
          <td><?php echo e($t->user->name ?? '-'); ?></td>
          <td><?php echo e($t->posts_count); ?></td>
          <td class="text-muted small"><?php echo e($t->updated_at->format('d M Y H:i')); ?></td>
          <td>
            <?php if($t->pinned_at): ?><span class="chip chip-pin me-1">Pinned</span><?php endif; ?>
            <?php if($t->is_locked): ?><span class="chip chip-lock">Locked</span><?php endif; ?>
            <?php if($t->trashed()): ?><span class="badge text-bg-secondary ms-1">Deleted</span><?php endif; ?>
          </td>
          <td>
            <div class="d-flex flex-wrap gap-2">
              <a class="btn btn-sm btn-outline-primary"
                 href="<?php echo e(route('forum.thread.show',['id'=>$t->id,'slug'=>\Illuminate\Support\Str::slug($t->title)])); ?>"
                 target="_blank">View</a>

              
              <form method="POST" action="<?php echo e($t->pinned_at ? route('forum.mod.unpin',$t->id) : route('forum.mod.pin',$t->id)); ?>">
                <?php echo csrf_field(); ?>
                <button class="btn btn-sm <?php echo e($t->pinned_at ? 'btn-outline-warning':'btn-warning'); ?>">
                  <?php echo e($t->pinned_at ? 'Unpin':'Pin'); ?>

                </button>
              </form>

              
              <form method="POST" action="<?php echo e($t->is_locked ? route('forum.mod.unlock',$t->id) : route('forum.mod.lock',$t->id)); ?>">
                <?php echo csrf_field(); ?>
                <button class="btn btn-sm <?php echo e($t->is_locked ? 'btn-outline-secondary':'btn-secondary'); ?>">
                  <?php echo e($t->is_locked ? 'Unlock':'Lock'); ?>

                </button>
              </form>

              
              <?php if(!$t->trashed()): ?>
                <form method="POST" action="<?php echo e(route('admin.forum.threads.destroy',$t->id)); ?>"
                      onsubmit="return confirm('Arsipkan thread ini?')">
                  <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                  <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash me-1"></i> Hapus</button>
                </form>
              <?php else: ?>
                <form method="POST" action="<?php echo e(route('admin.forum.threads.restore',$t->id)); ?>">
                  <?php echo csrf_field(); ?>
                  <button class="btn btn-sm btn-success">Pulihkan</button>
                </form>
              <?php endif; ?>
            </div>
          </td>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="7" class="text-muted">Belum ada thread.</td></tr>
      <?php endif; ?>
      </tbody>
    </table>
    <?php echo e($threads->links()); ?>

  </div>
</div>


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

<?php $__env->startPush('scripts'); ?>
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
      const res = await fetch(`<?php echo e(route('admin.forum.threads.trashedList')); ?>`);
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

  btnRes?.addEventListener('click', () =>
  bulkAction('restore', '#tt-body', {
    restore: `<?php echo e(route('admin.forum.threads.bulkRestore')); ?>`,
    force:   `<?php echo e(route('admin.forum.threads.bulkForceDelete')); ?>`
  })
);
  btnForce?.addEventListener('click', () => {
  if (confirm('Hapus permanen item terpilih? Tindakan ini tidak bisa dibatalkan.')) {
    bulkAction('force', '#tt-body', {
      restore: `<?php echo e(route('admin.forum.threads.bulkRestore')); ?>`,
      force:   `<?php echo e(route('admin.forum.threads.bulkForceDelete')); ?>`
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
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('templates.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/admin/forum/threads/index.blade.php ENDPATH**/ ?>