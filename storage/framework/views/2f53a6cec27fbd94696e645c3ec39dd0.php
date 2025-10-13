<?php $__env->startSection('title', $thread->title); ?>

<?php $__env->startPush('styles'); ?>
  
  <link rel="stylesheet" href="<?php echo e(asset('guest/forum-thread.css')); ?>?v=<?php echo e(filemtime(public_path('guest/forum-thread.css'))); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="th-wrap">
  <div class="th-container">

    
    <header class="th-topbar">
      <a href="<?php echo e(route('forum.index')); ?>" class="crumb" aria-label="Kembali ke Forum">
        <i class="fa-solid fa-angle-left"></i> Forum
      </a>
      <div class="th-head">
        <div>
          <div class="th-badges">
            <?php if($thread->pinned_at): ?><span class="chip chip--pinned">Pinned</span><?php endif; ?>
            <?php if($thread->is_locked): ?><span class="chip chip--locked">Locked</span><?php endif; ?>
          </div>
          <h1 class="th-title"><?php echo e($thread->title); ?></h1>
          <div class="th-meta">
            <a class="th-cat" href="<?php echo e(route('forum.category', $thread->category->slug)); ?>"><?php echo e($thread->category->name); ?></a>
            <span class="sep">•</span>
            <span class="author">
              <span class="avatar" aria-hidden="true"><?php echo e(mb_substr($thread->user->name,0,1)); ?></span>
              oleh <?php echo e($thread->user->name); ?>

            </span>
            <span class="sep">•</span>
            <time datetime="<?php echo e($thread->created_at->toIso8601String()); ?>"><?php echo e($thread->created_at->diffForHumans()); ?></time>
          </div>
        </div>

        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'superadmin|admin|instructor')): ?>
        <div class="th-actions">
          <form method="POST" action="<?php echo e($thread->pinned_at ? route('forum.mod.unpin',$thread->id) : route('forum.mod.pin',$thread->id)); ?>">
            <?php echo csrf_field(); ?>
            <button class="btnx <?php echo e($thread->pinned_at ? 'btnx-outline-warn' : 'btnx-warn'); ?>">
              <?php echo e($thread->pinned_at ? 'Unpin' : 'Pin'); ?>

            </button>
          </form>
          <form method="POST" action="<?php echo e($thread->is_locked ? route('forum.mod.unlock',$thread->id) : route('forum.mod.lock',$thread->id)); ?>">
            <?php echo csrf_field(); ?>
            <button class="btnx <?php echo e($thread->is_locked ? 'btnx-outline-sec' : 'btnx-sec'); ?>">
              <?php echo e($thread->is_locked ? 'Unlock' : 'Lock'); ?>

            </button>
          </form>
        </div>
        <?php endif; ?>
      </div>
    </header>

    <hr class="th-divider" aria-hidden="true"/>

    
    <article class="th-card op-card">
      <div class="op-header">
        <span class="op-badge">OP</span>
        <div class="op-author">
          <span class="avatar"><?php echo e(mb_substr($thread->user->name,0,1)); ?></span>
          <div class="op-meta">
            <div class="name"><?php echo e($thread->user->name); ?></div>
            <div class="time"><?php echo e($thread->created_at->format('d M Y H:i')); ?></div>
          </div>
        </div>
      </div>

      <div class="th-body prose">
        <?php echo nl2br(e($thread->body)); ?>

      </div>

      
      <?php if(!empty($thread->image_url)): ?>
        <button type="button" class="iv-trigger op-image" data-view="<?php echo e($thread->image_url); ?>">
          <img src="<?php echo e($thread->image_url); ?>" alt="Lampiran topik: <?php echo e($thread->title); ?>" loading="lazy">
        </button>
      <?php endif; ?>
    </article>

    
    <?php if($thread->bestAnswer && $thread->bestAnswer->post): ?>
      <section class="th-best" id="best-answer">
        <div class="best-head">
          <span class="best-icon" aria-hidden="true">✔</span>
          <div>
            <h6 class="best-title">Jawaban Terbaik</h6>
            <div class="best-sub">oleh <?php echo e($thread->bestAnswer->post->user->name); ?></div>
          </div>
        </div>
        <div class="best-body prose">
          <?php echo nl2br(e($thread->bestAnswer->post->body)); ?>

        </div>
      </section>
    <?php endif; ?>

    
    <div class="th-replies-head">
      <h2 class="th-replies-title">Balasan</h2>
      <a href="#reply-box" class="btnx btnx-outline">Tulis Balasan</a>
    </div>

    <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <article class="reply" id="reply-<?php echo e($p->id); ?>">
        <div class="reply-top">
          <div class="author">
            <span class="avatar"><?php echo e(mb_substr($p->user->name,0,1)); ?></span>
            <div class="meta">
              <div class="name"><?php echo e($p->user->name); ?></div>
              <div class="time"><?php echo e($p->created_at->diffForHumans()); ?></div>
            </div>
          </div>

          <div class="r-actions">
            <?php if(auth()->guard()->check()): ?>
              <?php if(auth()->id()===$thread->user_id || auth()->user()->hasAnyRole(['superadmin','admin','instructor'])): ?>
                <form method="POST" action="<?php echo e(route('forum.thread.resolve',['id'=>$thread->id,'postId'=>$p->id])); ?>">
                  <?php echo csrf_field(); ?>
                  <button class="btnx btnx-outline-warn" title="Tandai sebagai jawaban terbaik">Tandai Terbaik</button>
                </form>
              <?php endif; ?>
            <?php endif; ?>
            <a class="btnx btnx-outline" href="#reply-<?php echo e($p->id); ?>" title="Salin tautan">#</a>
          </div>
        </div>

        <div class="reply-body prose">
          <?php echo nl2br(e($p->body)); ?>

        </div>

        
        <?php if(!empty($p->image_url)): ?>
          <button type="button" class="iv-trigger reply-image" data-view="<?php echo e($p->image_url); ?>">
            <img src="<?php echo e($p->image_url); ?>" alt="Lampiran balasan oleh <?php echo e($p->user->name); ?>" loading="lazy">
          </button>
        <?php endif; ?>
      </article>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div class="alert alert-muted">Belum ada balasan.</div>
    <?php endif; ?>

    <div class="th-pagination">
      <?php echo e($posts->links()); ?>

    </div>

    
    <div id="reply-box"></div>
    <?php if(auth()->guard()->check()): ?>
      <?php if(!$thread->is_locked): ?>
        <div class="composer th-card">
          <form method="POST" action="<?php echo e(route('forum.post.store',$thread->id)); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <label class="form-label">Tulis Balasan</label>
            <textarea name="body" class="textarea" required placeholder="Ketik jawabanmu di sini…"></textarea>

            
            <div class="field mt-8">
              <div class="label">
                <label for="reply_image">Lampiran Gambar <span class="muted">(opsional)</span></label>
                <span class="hint">JPG/PNG/GIF/WEBP • maks 2MB</span>
              </div>

              <input id="reply_image" name="image" type="file" accept="image/*" class="file-one" aria-label="Pilih gambar">
            </div>

            <div class="compose-actions">
              <button class="btnx btn-primary">Kirim</button>
            </div>
          </form>
        </div>
      <?php else: ?>
        <div class="alert alert-muted">Topik ini terkunci. Tidak dapat dibalas.</div>
      <?php endif; ?>
    <?php else: ?>
      <div class="alert alert-info">Masuk untuk menulis balasan.</div>
    <?php endif; ?>

  </div>

  
  <div class="img-viewer" id="imgViewer" hidden>
    <button class="iv-close" id="ivClose" aria-label="Tutup pratinjau">✕</button>
    <img id="ivImg" alt="Pratinjau lampiran">
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
  (function(){
    // ===== Image Viewer (klik gambar → overlay) =====
    const viewer = document.getElementById('imgViewer');
    const ivImg  = document.getElementById('ivImg');
    const ivClose= document.getElementById('ivClose');

    document.querySelectorAll('.iv-trigger').forEach(btn=>{
      btn.addEventListener('click', ()=>{
        const src = btn.getAttribute('data-view');
        if(!src) return;
        ivImg.src = src;
        viewer.hidden = false;
        viewer.classList.add('show');
        document.body.style.overflow = 'hidden';
      });
    });
    function closeViewer(){
      viewer.classList.remove('show');
      setTimeout(()=>{ viewer.hidden = true; ivImg.src=''; document.body.style.overflow=''; }, 120);
    }
    ivClose?.addEventListener('click', closeViewer);
    viewer?.addEventListener('click', (e)=>{ if(e.target === viewer) closeViewer(); });
    document.addEventListener('keydown', (e)=>{ if(e.key === 'Escape' && !viewer.hidden) closeViewer(); });
  })();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/forum/thread/show.blade.php ENDPATH**/ ?>