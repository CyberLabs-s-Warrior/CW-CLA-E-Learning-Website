@extends('layouts.guest')
@section('title', $thread->title)

@section('content')
<style>
  /* ===== Tokens (gampang diubah) ===== */
  :root{
    --bg:#0b0f19; --surface:#111827; --surface-2:#0f172a;
    --text:#e5e7eb; --muted:#94a3b8; --brand:#3b82f6;
    --border:#1f2937; --success:#16a34a; --warning:#f59e0b;
    --secondary:#64748b; --radius:14px; --shadow:0 10px 30px rgba(0,0,0,.25);
  }
  .thread-page{color:var(--text);}
  .thread-page .container{max-width:900px;margin:0 auto;padding:0 16px;}

  /* Header */
  .th-head{display:grid;grid-template-columns:1fr auto;gap:12px;align-items:start}
  .th-title{margin:0;font-size:clamp(22px,2.2vw,30px);font-weight:800;letter-spacing:.2px}
  .th-meta{color:var(--muted);font-size:12px;margin-top:6px}
  .chip{display:inline-flex;align-items:center;height:22px;padding:0 8px;border-radius:999px;
    font-size:11px;font-weight:800;letter-spacing:.2px;border:1px solid transparent}
  .chip-pin{background:rgba(245,158,11,.15);color:#fbbf24;border-color:rgba(245,158,11,.35)}
  .chip-lock{background:rgba(100,116,139,.15);color:#cbd5e1;border-color:rgba(100,116,139,.35)}

  /* Buttons */
  .btnx{display:inline-flex;align-items:center;justify-content:center;height:36px;padding:0 12px;
    border-radius:10px;border:1px solid transparent;font-weight:700;text-decoration:none;cursor:pointer;
    transition:transform .08s ease,filter .2s ease,border-color .2s ease}
  .btnx:active{transform:translateY(1px)}
  .btnx-warn{background:linear-gradient(180deg,#fbbf24,#f59e0b);color:#111827}
  .btnx-outline-warn{background:transparent;border-color:#f59e0b;color:#fbbf24}
  .btnx-sec{background:#334155;color:#e5e7eb}
  .btnx-outline-sec{background:transparent;border-color:#94a3b8;color:#cbd5e1}

  /* Blocks */
  .block{background:linear-gradient(180deg,var(--surface),var(--surface-2));border:1px solid var(--border);
    border-radius:var(--radius);box-shadow:0 0 0 rgba(0,0,0,0)}
  .op-post{padding:16px}
  .divider{height:1px;background:var(--border);border:0;margin:16px 0}

  /* Best Answer */
  .best{border:1px solid rgba(22,163,74,.4);background:linear-gradient(180deg,rgba(22,163,74,.12),rgba(22,163,74,.08));padding:16px;border-radius:var(--radius)}
  .best h6{margin:0 0 6px;font-size:13px;color:#86efac;letter-spacing:.2px}
  .best .who{color:var(--muted);font-size:12px}
  .best .content{margin-top:8px}

  /* Replies */
  .replies{display:grid;gap:10px}
  .reply{padding:14px 16px;border:1px solid var(--border);border-radius:var(--radius);
    background:linear-gradient(180deg,var(--surface),var(--surface-2));transition:border-color .2s ease, box-shadow .2s ease, transform .12s ease}
  .reply:hover{border-color:rgba(59,130,246,.35);box-shadow:var(--shadow);transform:translateY(-1px)}
  .reply-top{display:flex;justify-content:space-between;gap:10px;align-items:center}
  .reply-meta{color:var(--muted);font-size:12px}
  .reply-body{margin-top:8px;line-height:1.6}

  /* Composer */
  .composer{margin-top:16px}
  .form-label{display:block;margin-bottom:8px;font-weight:700;color:var(--muted)}
  .textarea{width:100%;min-height:120px;border-radius:12px;border:1px solid var(--border);
    background:var(--surface-2);color:var(--text);padding:10px 12px;outline:none}
  .textarea:focus{border-color:rgba(59,130,246,.45);box-shadow:0 0 0 3px rgba(59,130,246,.15)}
  .btn-primary{background:linear-gradient(180deg,var(--brand),#60a5fa);color:#fff;border:0}
  .alert{padding:12px 14px;border-radius:12px}
  .alert-info{background:rgba(59,130,246,.1);border:1px solid rgba(59,130,246,.35);color:#bfdbfe}
  .alert-muted{background:rgba(100,116,139,.12);border:1px solid rgba(100,116,139,.35);color:#cbd5e1}

  /* Stack moderator buttons neatly on small screens */
  .th-actions{display:flex;gap:8px;flex-wrap:wrap}
  @media (max-width:640px){.th-head{grid-template-columns:1fr}.th-actions{justify-content:flex-start}}
</style>

<section class="thread-page">
  <div class="container py-4">

    {{-- Header --}}
    <div class="th-head">
      <div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:6px;">
          @if($thread->pinned_at)<span class="chip chip-pin">Pinned</span>@endif
          @if($thread->is_locked)<span class="chip chip-lock">Locked</span>@endif
        </div>
        <h1 class="th-title">{{ $thread->title }}</h1>
        <div class="th-meta">
          {{ $thread->category->name }} • oleh {{ $thread->user->name }} • {{ $thread->created_at->diffForHumans() }}
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

    <hr class="divider">

    {{-- Post Pertama (OP) --}}
    <article class="op-post block">
      <h6 class="th-meta" style="margin:0 0 8px">OP</h6>
      <div class="reply-body">{{ $thread->body }}</div>
    </article>

    {{-- Jawaban Terbaik (jika ada) --}}
    @if($thread->bestAnswer && $thread->bestAnswer->post)
      <div class="best" style="margin-top:12px">
        <h6>Jawaban Terbaik</h6>
        <div class="who">oleh {{ $thread->bestAnswer->post->user->name }}</div>
        <div class="content">{{ $thread->bestAnswer->post->body }}</div>
      </div>
    @endif

    {{-- Daftar Balasan --}}
    <h5 style="margin:24px 0 12px;color:var(--muted);letter-spacing:.3px;">Balasan</h5>

    @forelse($posts as $p)
      <div class="reply">
        <div class="reply-top">
          <div class="reply-meta">oleh {{ $p->user->name }} • {{ $p->created_at->diffForHumans() }}</div>
          @auth
            @if(auth()->id()===$thread->user_id || auth()->user()->hasAnyRole(['superadmin','admin','instructor']))
              <form method="POST" action="{{ route('forum.thread.resolve',['id'=>$thread->id,'postId'=>$p->id]) }}">
                @csrf
                <button class="btnx btnx-outline-warn" title="Tandai sebagai jawaban terbaik">Tandai Jawaban Terbaik</button>
              </form>
            @endif
          @endauth
        </div>
        <div class="reply-body">{{ $p->body }}</div>
      </div>
    @empty
      <div class="alert alert-muted">Belum ada balasan.</div>
    @endforelse

    <div class="mt-3">
      {{ $posts->links() }}
    </div>

    {{-- Form Balas --}}
    @auth
      @if(!$thread->is_locked)
        <div class="composer block">
          <form method="POST" action="{{ route('forum.post.store',$thread->id) }}">
            @csrf
            <label class="form-label">Tulis Balasan</label>
            <textarea name="body" class="textarea" required></textarea>
            <div style="margin-top:10px;display:flex;gap:8px;align-items:center">
              <button class="btnx btn-primary">Kirim</button>
            </div>
          </form>
        </div>
      @else
        <div class="alert alert-muted" style="margin-top:16px">Topik ini terkunci. Tidak dapat dibalas.</div>
      @endif
    @else
      <div class="alert alert-info" style="margin-top:16px">Masuk untuk menulis balasan.</div>
    @endauth
  </div>
</section>
@endsection
