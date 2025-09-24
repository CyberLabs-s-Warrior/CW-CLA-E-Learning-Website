

<?php $__env->startSection('title','Buat Topik'); ?>

<?php $__env->startPush('styles'); ?>
  <link rel="stylesheet" href="<?php echo e(asset('guest/forum-compose.css')); ?>?v=<?php echo e(filemtime(public_path('guest/forum-compose.css'))); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="compose-wrap" aria-labelledby="composeTitle">
  <div class="compose-container">

    
    <div class="compose-head">
      <div>
        <a href="<?php echo e(route('forum.index')); ?>" class="crumb" aria-label="Kembali ke Forum">
          <i class="fa-solid fa-angle-left"></i> Forum
        </a>
        <h1 id="composeTitle" class="compose-title">Buat Topik</h1>
        <p class="compose-subtitle">Sampaikan pertanyaan, ide, atau diskusi. Buat ringkas dan jelas agar mudah dibantu.</p>
      </div>
    </div>

    
    <?php if($errors->any()): ?>
      <div class="alert alert-danger" role="alert" aria-live="polite">
        <ul class="mb-0">
          <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($error); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="POST"
          action="<?php echo e(route('forum.thread.store')); ?>"
          id="threadForm"
          class="compose-card"
          enctype="multipart/form-data">
      <?php echo csrf_field(); ?>

      
      <div class="field">
        <div class="label">
          <label for="category_id">Kategori</label>
          <span class="hint">Pilih ruang diskusi yang paling pas</span>
        </div>
        <select id="category_id" name="category_id" required
                class="js-selectx <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                data-search="true"
                data-placeholder="— Pilih Kategori —">
          <option value="">— Pilih —</option>
          <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($c->id); ?>" <?php if(old('category_id')==$c->id): echo 'selected'; endif; ?>><?php echo e($c->name); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-msg"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      
      <div class="field">
        <div class="label">
          <label for="title">Judul</label>
          <span class="counter"><span id="titleCount">0</span>/140</span>
        </div>
        <input id="title" type="text" name="title" maxlength="140"
               value="<?php echo e(old('title')); ?>"
               placeholder="Contoh: Cara memahami konsep OOP di PHP?"
               class="<?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
        <div class="hint">Minimal 5 karakter. Buat padat & jelas.</div>
        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-msg"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      
      <div class="field">
        <div class="label">
          <label for="body">Isi</label>
          <span class="counter"><span id="bodyCount">0</span> karakter</span>
        </div>
        <textarea id="body" name="body"
                  class="textarea <?php $__errorArgs = ['body'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                  placeholder="Jelaskan konteks, apa yang sudah dicoba, dan error (jika ada)…" required><?php echo e(old('body')); ?></textarea>
        <div class="hint">Minimal 10 karakter. Sertakan detail agar mudah dibantu.</div>
        <?php $__errorArgs = ['body'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-msg"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      
      <div class="field">
        <div class="label">
          <label for="image">Lampiran Gambar <span class="muted">(opsional)</span></label>
          <span class="hint">JPG/PNG/GIF/WEBP • maks 2MB</span>
        </div>

        <div class="uploader" id="uploader">
          <input id="image" name="image" type="file" accept="image/*" class="uploader__input" aria-label="Pilih gambar">
          <div class="uploader__drop" id="dropzone" tabindex="0">
            <div class="uploader__icon" aria-hidden="true">📎</div>
            <div class="uploader__text">
              Tarik & letakkan gambar di sini, atau <button type="button" class="linklike" id="pickBtn">pilih berkas</button>
            </div>
            <div class="uploader__sub">Maks 1 gambar, ≤ 2MB</div>
          </div>
          <div class="uploader__list" id="previewList" aria-live="polite"></div>
          <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-msg mt-6"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
      </div>

      <div class="actions">
        <button class="btn btn-primary" type="submit">
          <i class="fa-solid fa-paper-plane"></i> Kirim
        </button>
        <a href="<?php echo e(route('forum.index')); ?>" class="btn btn-secondary">Batal</a>
      </div>
    </form>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
  // Counter + Guard
  (function(){
    const title = document.getElementById('title');
    const body  = document.getElementById('body');
    const tc = document.getElementById('titleCount');
    const bc = document.getElementById('bodyCount');
    const form = document.getElementById('threadForm');

    function updateCounts(){
      tc.textContent = (title?.value || '').length;
      bc.textContent = (body?.value  || '').length;
    }
    ['input','change'].forEach(evt=>{
      title?.addEventListener(evt, updateCounts);
      body?.addEventListener(evt, updateCounts);
    });
    updateCounts();

    form?.addEventListener('submit', function(e){
      const titleLen = (title?.value || '').trim().length;
      const bodyLen  = (body?.value  || '').trim().length;
      let ok = true;

      if(titleLen < 5){ title.classList.add('is-invalid'); ok = false; }
      else { title.classList.remove('is-invalid'); }

      if(bodyLen < 10){ body.classList.add('is-invalid'); ok = false; }
      else { body.classList.remove('is-invalid'); }

      if(!ok){ e.preventDefault(); title?.focus(); }
    });
  })();

  // Uploader (single)
  (function(){
    const MAX_SIZE = 2 * 1024 * 1024; // 2MB
    const ACCEPT = ['image/jpeg','image/png','image/gif','image/webp'];

    const input = document.getElementById('image');
    const dropzone = document.getElementById('dropzone');
    const pickBtn = document.getElementById('pickBtn');
    const previewList = document.getElementById('previewList');

    function bytesToSize(bytes){
      if(bytes === 0) return '0 B';
      const k = 1024, units = ['B','KB','MB','GB'];
      const i = Math.floor(Math.log(bytes) / Math.log(k));
      return (bytes / Math.pow(k, i)).toFixed(1) + ' ' + units[i];
    }

    function renderPreview(file){
      previewList.innerHTML = '';
      if(!file) return;

      const url = URL.createObjectURL(file);
      const item = document.createElement('div');
      item.className = 'u-item';

      const thumb = document.createElement('div');
      thumb.className = 'u-thumb';
      const img = document.createElement('img');
      img.src = url; img.alt = file.name; img.loading = 'lazy';
      thumb.appendChild(img);

      const meta = document.createElement('div');
      meta.className = 'u-meta';
      meta.innerHTML = `
        <div class="u-name" title="${file.name}">${file.name}</div>
        <div class="u-size">${bytesToSize(file.size)}</div>
      `;

      const removeBtn = document.createElement('button');
      removeBtn.type = 'button';
      removeBtn.className = 'u-remove';
      removeBtn.innerHTML = '<i class="fa-solid fa-xmark"></i>';
      removeBtn.addEventListener('click', () => {
        input.value = ''; previewList.innerHTML = '';
      });

      item.appendChild(thumb);
      item.appendChild(meta);
      item.appendChild(removeBtn);
      previewList.appendChild(item);
    }

    function validateAndSet(file){
      if(!file) return;
      if(!ACCEPT.includes(file.type)) return alert('Tipe file tidak didukung.');
      if(file.size > MAX_SIZE) return alert('Ukuran melebihi 2MB.');
      renderPreview(file);
    }

    pickBtn?.addEventListener('click', () => input?.click());
    input?.addEventListener('change', (e) => validateAndSet(e.target.files[0]));

    ['dragenter','dragover'].forEach(evt => {
      dropzone?.addEventListener(evt, (e) => {
        e.preventDefault(); e.stopPropagation();
        dropzone.classList.add('is-hover');
      });
    });
    ['dragleave','drop'].forEach(evt => {
      dropzone?.addEventListener(evt, (e) => {
        e.preventDefault(); e.stopPropagation();
        dropzone.classList.remove('is-hover');
      });
    });
    dropzone?.addEventListener('drop', (e) => {
      const files = e.dataTransfer?.files;
      if(files && files.length) { input.files = files; validateAndSet(files[0]); }
    });

    dropzone?.addEventListener('keydown', (e) => {
      if(e.key === 'Enter' || e.key === ' '){
        e.preventDefault(); input?.click();
      }
    });
  })();

  // SelectX (custom select + search)
  (function(){
    function outside(el, evt){ return !el.contains(evt.target); }
    function setText(el, text){ el.textContent = text != null && text !== '' ? text : '—'; }

    function initSelectX(sel){
      if(sel.dataset.enhanced === '1') return;
      sel.dataset.enhanced = '1';

      const wrap = document.createElement('div');
      wrap.className = 'selectx';
      if (sel.classList.contains('is-invalid')) wrap.classList.add('is-invalid');

      const placeholder = sel.dataset.placeholder || (sel.options[0] && sel.options[0].value === '' ? sel.options[0].textContent : '— Pilih —');
      const withSearch = sel.dataset.search === 'true';

      sel.classList.add('selectx__sr-hide');
      sel.parentNode.insertBefore(wrap, sel);
      wrap.appendChild(sel);

      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'selectx__button';
      btn.setAttribute('aria-haspopup','listbox');
      btn.setAttribute('aria-expanded','false');

      const labelSpan = document.createElement('span');
      labelSpan.className = 'selectx__label';
      const chev = document.createElement('span');
      chev.className = 'selectx__chev';
      chev.innerHTML = '<i class="fa-solid fa-chevron-down" aria-hidden="true"></i>';

      btn.appendChild(labelSpan);
      btn.appendChild(chev);
      wrap.appendChild(btn);

      const panel = document.createElement('div');
      panel.className = 'selectx__panel';
      panel.setAttribute('role','listbox');
      wrap.appendChild(panel);

      let searchInput = null;
      if(withSearch){
        const searchWrap = document.createElement('div');
        searchWrap.className = 'selectx__search';
        searchWrap.innerHTML = '<i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>';
        searchInput = document.createElement('input');
        searchInput.type = 'text';
        searchInput.placeholder = 'Cari…';
        searchWrap.appendChild(searchInput);
        panel.appendChild(searchWrap);
      }

      const list = document.createElement('div');
      list.className = 'selectx__list';
      panel.appendChild(list);

      const data = Array.from(sel.options).map(o => ({
        value: o.value,
        label: o.textContent,
        disabled: !!o.disabled
      }));

      let open = false;
      let activeIdx = -1;

      function currentIndex(){
        return data.findIndex(d => d.value === sel.value);
      }

      function updateButtonLabel(){
        const cur = data.find(d => d.value === sel.value);
        setText(labelSpan, cur ? cur.label : placeholder);
      }

      function renderList(filterText=''){
        list.innerHTML = '';
        const items = data.filter(d => {
          if(filterText.trim() === '') return true;
          return d.label.toLowerCase().includes(filterText.toLowerCase());
        });

        if(items.length === 0){
          const empty = document.createElement('div');
          empty.className = 'selectx__empty';
          empty.textContent = 'Tidak ada hasil';
          list.appendChild(empty);
          return;
        }

        items.forEach((d, visualIdx) => {
          const it = document.createElement('button');
          it.type = 'button';
          it.className = 'selectx__item';
          it.setAttribute('role','option');
          it.setAttribute('aria-selected', d.value === sel.value ? 'true' : 'false');
          if(d.disabled){ it.disabled = true; }

          const left = document.createElement('span');
          left.className = 'txt';
          left.textContent = d.label;

          const right = document.createElement('span');
          right.className = 'check';
          right.innerHTML = '<i class="fa-solid fa-check" aria-hidden="true"></i>';

          it.appendChild(left);
          it.appendChild(right);

          it.addEventListener('click', function(e){
            e.preventDefault();
            if(d.disabled) return;
            if(sel.value !== d.value){
              sel.value = d.value;
              sel.dispatchEvent(new Event('change', { bubbles: true }));
            }
            closePanel();
            btn.focus();
          });

          list.appendChild(it);
        });

        const realIdx = items.findIndex(d => d.value === sel.value);
        activeIdx = realIdx;
        syncActiveItem();
      }

      function syncActiveItem(){
        const items = Array.from(list.querySelectorAll('.selectx__item'));
        items.forEach((el, i) => {
          if(i === activeIdx) el.classList.add('is-active'); else el.classList.remove('is-active');
        });
      }

      function openPanel(){
        if(open) return;
        open = true;
        wrap.classList.add('is-open');
        btn.setAttribute('aria-expanded','true');
        if(searchInput){ searchInput.value = ''; }
        renderList('');
        setTimeout(()=>{
          if(searchInput){ searchInput.focus(); }
          else {
            const items = list.querySelectorAll('.selectx__item');
            if(items.length){ items[activeIdx >=0 ? activeIdx : 0].focus(); }
          }
        }, 0);
        document.addEventListener('click', handleDocClick, { capture: true });
        document.addEventListener('keydown', handleGlobalKey);
      }

      function closePanel(){
        if(!open) return;
        open = false;
        wrap.classList.remove('is-open');
        btn.setAttribute('aria-expanded','false');
        document.removeEventListener('click', handleDocClick, { capture: true });
        document.removeEventListener('keydown', handleGlobalKey);
        updateButtonLabel();
      }

      function handleDocClick(e){
        if(!wrap.contains(e.target)) closePanel();
      }

      function handleGlobalKey(e){
        if(!open) return;
        const items = Array.from(list.querySelectorAll('.selectx__item'));
        const max = items.length - 1;

        if(e.key === 'Escape'){
          e.preventDefault(); closePanel(); btn.focus(); return;
        }
        if(e.key === 'ArrowDown'){
          e.preventDefault();
          if(max < 0) return;
          activeIdx = (activeIdx < 0) ? 0 : Math.min(max, activeIdx + 1);
          items[activeIdx].focus(); syncActiveItem(); return;
        }
        if(e.key === 'ArrowUp'){
          e.preventDefault();
          if(max < 0) return;
          activeIdx = (activeIdx <= 0) ? 0 : activeIdx - 1;
          items[activeIdx].focus(); syncActiveItem(); return;
        }
        if(e.key === 'Enter'){
          e.preventDefault();
          if(activeIdx >= 0 && items[activeIdx]){ items[activeIdx].click(); }
        }
      }

      btn.addEventListener('click', function(e){
        e.preventDefault();
        open ? closePanel() : openPanel();
      });

      if(searchInput){
        searchInput.addEventListener('input', function(){
          renderList(this.value || '');
        });
        searchInput.addEventListener('keydown', function(e){
          if(e.key === 'ArrowDown'){
            e.preventDefault();
            const first = list.querySelector('.selectx__item');
            if(first){ activeIdx = 0; first.focus(); syncActiveItem(); }
          }
        });
      }

      sel.addEventListener('change', function(){
        updateButtonLabel();
        if(open){
          const filter = searchInput ? (searchInput.value || '') : '';
          renderList(filter);
        }
      });

      updateButtonLabel();
    }

    document.addEventListener('DOMContentLoaded', function(){
      document.querySelectorAll('select.js-selectx').forEach(initSelectX);
    });
  })();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/forum/thread/create.blade.php ENDPATH**/ ?>