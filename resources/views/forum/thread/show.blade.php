{{-- resources/views/forum/thread/show.blade.php --}}
@extends('layouts.guest')
@section('title', $thread->title)

@push('styles')
  {{-- cache-busting agar update CSS langsung terbaca --}}
  <link rel="stylesheet" href="{{ asset('guest/forum-thread.css') }}?v={{ filemtime(public_path('guest/forum-thread.css')) }}">
@endpush

@section('content')
<section class="th-wrap">
  <div class="th-container">

    {{-- Breadcrumb + Header --}}
    <header class="th-topbar">
      <a href="{{ route('forum.index') }}" class="crumb" aria-label="Kembali ke Forum">
        <i class="fa-solid fa-angle-left"></i> Forum
      </a>
      <div class="th-head">
        <div>
          <div class="th-badges">
            @if($thread->pinned_at)<span class="chip chip--pinned">Pinned</span>@endif
            @if($thread->is_locked)<span class="chip chip--locked">Locked</span>@endif
          </div>
          <h1 class="th-title">{{ $thread->title }}</h1>
          <div class="th-meta">
            <a class="th-cat" href="{{ route('forum.category', $thread->category->slug) }}">{{ $thread->category->name }}</a>
            <span class="sep">•</span>
            <span class="author">
              <span class="avatar" aria-hidden="true">{{ mb_substr($thread->user->name,0,1) }}</span>
              oleh {{ $thread->user->name }}
            </span>
            <span class="sep">•</span>
            <time datetime="{{ $thread->created_at->toIso8601String() }}">{{ $thread->created_at->diffForHumans() }}</time>
          </div>
        </div>

        @role('superadmin|admin|instructor')
        <div class="th-actions">
          <form method="POST" action="{{ $thread->pinned_at ? route('forum.mod.unpin',$thread->id) : route('forum.mod.pin',$thread->id) }}">
            @csrf
            <button class="btnx {{ $thread->pinned_at ? 'btnx-outline-warn' : 'btnx-warn' }}">
              {{ $thread->pinned_at ? 'Unpin' : 'Pin' }}
            </button>
          </form>
          <form method="POST" action="{{ $thread->is_locked ? route('forum.mod.unlock',$thread->id) : route('forum.mod.lock',$thread->id) }}">
            @csrf
            <button class="btnx {{ $thread->is_locked ? 'btnx-outline-sec' : 'btnx-sec' }}">
              {{ $thread->is_locked ? 'Unlock' : 'Lock' }}
            </button>
          </form>
        </div>
        @endrole
      </div>
    </header>

    <hr class="th-divider" aria-hidden="true"/>

    {{-- OP (post pertama / isi topik) --}}
    <article class="th-card op-card">
      <div class="op-header">
        <span class="op-badge">OP</span>
        <div class="op-author">
          <span class="avatar">{{ mb_substr($thread->user->name,0,1) }}</span>
          <div class="op-meta">
            <div class="name">{{ $thread->user->name }}</div>
            <div class="time">{{ $thread->created_at->format('d M Y H:i') }}</div>
          </div>
        </div>
      </div>

      <div class="th-body prose">
        {!! nl2br(e($thread->body)) !!}
      </div>

      {{-- Gambar OP (jika ada) --}}
      @if(!empty($thread->image_url))
        <button type="button" class="iv-trigger op-image" data-view="{{ $thread->image_url }}">
          <img src="{{ $thread->image_url }}" alt="Lampiran topik: {{ $thread->title }}" loading="lazy">
        </button>
      @endif
    </article>

    {{-- Jawaban Terbaik (jika ada) --}}
    @if($thread->bestAnswer && $thread->bestAnswer->post)
      <section class="th-best" id="best-answer">
        <div class="best-head">
          <span class="best-icon" aria-hidden="true">✔</span>
          <div>
            <h6 class="best-title">Jawaban Terbaik</h6>
            <div class="best-sub">oleh {{ $thread->bestAnswer->post->user->name }}</div>
          </div>
        </div>
        <div class="best-body prose">
          {!! nl2br(e($thread->bestAnswer->post->body)) !!}
        </div>
      </section>
    @endif

    {{-- Balasan --}}
    <div class="th-replies-head">
      <h2 class="th-replies-title">Balasan</h2>
      <a href="#reply-box" class="btnx btnx-outline">Tulis Balasan</a>
    </div>

    @forelse($posts as $p)
      <article class="reply" id="reply-{{ $p->id }}">
        <div class="reply-top">
          <div class="author">
            <span class="avatar">{{ mb_substr($p->user->name,0,1) }}</span>
            <div class="meta">
              <div class="name">{{ $p->user->name }}</div>
              <div class="time">{{ $p->created_at->diffForHumans() }}</div>
            </div>
          </div>

          <div class="r-actions">
            @auth
              @if(auth()->id()===$thread->user_id || auth()->user()->hasAnyRole(['superadmin','admin','instructor']))
                <form method="POST" action="{{ route('forum.thread.resolve',['id'=>$thread->id,'postId'=>$p->id]) }}">
                  @csrf
                  <button class="btnx btnx-outline-warn" title="Tandai sebagai jawaban terbaik">Tandai Terbaik</button>
                </form>
              @endif
            @endauth
            <a class="btnx btnx-outline" href="#reply-{{ $p->id }}" title="Salin tautan">#</a>
          </div>
        </div>

        <div class="reply-body prose">
          {!! nl2br(e($p->body)) !!}
        </div>

        {{-- Gambar balasan (jika ada) --}}
        @if(!empty($p->image_url))
          <button type="button" class="iv-trigger reply-image" data-view="{{ $p->image_url }}">
            <img src="{{ $p->image_url }}" alt="Lampiran balasan oleh {{ $p->user->name }}" loading="lazy">
          </button>
        @endif
      </article>
    @empty
      <div class="alert alert-muted">Belum ada balasan.</div>
    @endforelse

    <div class="th-pagination">
      {{ $posts->links() }}
    </div>

    {{-- Composer Balasan --}}
    <div id="reply-box"></div>
    @auth
      @if(!$thread->is_locked)
        <div class="composer th-card">
          <form method="POST" action="{{ route('forum.post.store',$thread->id) }}" enctype="multipart/form-data">
            @csrf
            <label class="form-label">Tulis Balasan</label>
            <textarea name="body" class="textarea" required placeholder="Ketik jawabanmu di sini…"></textarea>

            {{-- Lampiran gambar (opsional, SINGLE) --}}
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
      @else
        <div class="alert alert-muted">Topik ini terkunci. Tidak dapat dibalas.</div>
      @endif
    @else
      <div class="alert alert-info">Masuk untuk menulis balasan.</div>
    @endauth

  </div>

  {{-- Image Viewer Overlay --}}
  <div class="img-viewer" id="imgViewer" hidden>
    <button class="iv-close" id="ivClose" aria-label="Tutup pratinjau">✕</button>
    <img id="ivImg" alt="Pratinjau lampiran">
  </div>
</section>
@endsection

@push('scripts')
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
@endpush
