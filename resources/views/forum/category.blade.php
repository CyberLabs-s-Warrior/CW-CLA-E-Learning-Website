@extends('layouts.guest')
@section('title','Forum - '.$category->name)

@section('content')
<style>
  /* ====== Tokens (ubah gampang) ====== */
  :root {
    --bg: #0b0f19;
    --surface: #111827;
    --surface-2: #0f172a;
    --text: #e5e7eb;
    --muted: #94a3b8;
    --brand: #3b82f6;
    --border: #1f2937;
    --warning: #f59e0b;
    --secondary: #64748b;
    --shadow: 0 10px 30px rgba(0,0,0,.25);
    --radius: 14px;
  }
  .forum-cat { color: var(--text); }
  .forum-cat .container { max-width: 1100px; margin: 0 auto; padding: 0 16px; }

  /* Header */
  .fc-head {
    display: grid; grid-template-columns: 1fr auto; gap: 12px; align-items: center;
    margin-bottom: 10px;
  }
  .fc-title { font-size: clamp(22px, 2vw, 30px); font-weight: 800; letter-spacing: .2px; margin: 0; }
  .fc-desc { color: var(--muted); margin: 0 0 16px; }

  /* Buttons (local minimal) */
  .btnx {
    display:inline-flex; align-items:center; justify-content:center;
    height:40px; padding:0 14px; border-radius:10px; border:1px solid transparent;
    font-weight:700; text-decoration:none; cursor:pointer;
    transition: transform .08s ease, filter .2s ease, border-color .2s ease;
  }
  .btnx:active { transform: translateY(1px); }
  .btnx-primary { background: linear-gradient(180deg, var(--brand), #60a5fa); color:#fff; box-shadow: var(--shadow); }

  /* Thread list */
  .threads { display: grid; gap: 10px; }
  .thread {
    display:block; text-decoration:none; color: var(--text);
    background: linear-gradient(180deg, var(--surface), var(--surface-2));
    border:1px solid var(--border); border-radius: var(--radius);
    padding:14px 16px; transition: border-color .2s ease, box-shadow .2s ease, transform .12s ease;
  }
  .thread:hover { border-color: rgba(59,130,246,.35); box-shadow: var(--shadow); transform: translateY(-1px); }
  .thread-top { display:flex; gap:8px; align-items:center; flex-wrap:wrap; }
  .thread-title { font-weight:800; letter-spacing:.2px; }
  .thread-meta { color: var(--muted); font-size: 12px; margin-top: 6px; }

  /* Chips */
  .chip {
    display:inline-flex; align-items:center; height:22px; padding:0 8px;
    border-radius:999px; font-size:11px; font-weight:800; letter-spacing:.2px;
    border:1px solid transparent;
  }
  .chip-pin   { background: rgba(245,158,11,.15); color:#fbbf24; border-color: rgba(245,158,11,.35); }
  .chip-lock  { background: rgba(100,116,139,.15); color:#cbd5e1; border-color: rgba(100,116,139,.35); }

  /* Empty */
  .empty {
    color: var(--muted); background: linear-gradient(180deg, var(--surface), var(--surface-2));
    border:1px dashed var(--border); border-radius: var(--radius);
    padding:18px; text-align:center;
  }

  /* Pagination (opsional, sentuhan ringan) */
  .pagination { display:flex; gap:8px; flex-wrap:wrap; margin-top:14px; }
  .pagination a, .pagination span {
    display:inline-block; min-width:34px; text-align:center; padding:6px 10px;
    border-radius:10px; border:1px solid var(--border); color:var(--muted); text-decoration:none;
    background: var(--surface-2);
  }
  .pagination .active span { background: var(--brand); color:#fff; border-color:transparent; }

  @media (max-width: 640px) {
    .fc-head { grid-template-columns: 1fr; }
  }
</style>

<section class="forum-cat">
  <div class="container py-4">
    <header class="fc-head">
      <h1 class="fc-title">{{ $category->name }}</h1>
      @auth
        <a href="{{ route('forum.thread.create') }}" class="btnx btnx-primary">Buat Topik</a>
      @endauth
    </header>

    @if($category->description)
      <p class="fc-desc">{{ $category->description }}</p>
    @endif

    @if($threads->count())
      <div class="threads">
        @foreach($threads as $t)
          <a class="thread" href="{{ route('forum.thread.show',['id'=>$t->id,'slug'=>Str::slug($t->title)]) }}"
             aria-label="Buka topik: {{ $t->title }}">
            <div class="thread-top">
              @if($t->pinned_at) <span class="chip chip-pin">Pinned</span> @endif
              @if($t->is_locked) <span class="chip chip-lock">Locked</span> @endif
              <span class="thread-title">{{ $t->title }}</span>
            </div>
            <div class="thread-meta">oleh {{ $t->user->name }} • {{ $t->updated_at->diffForHumans() }}</div>
          </a>
        @endforeach
      </div>

      {{-- pagination default Laravel --}}
      <div class="mt-3">
        {{ $threads->links() }}
      </div>
    @else
      <div class="empty">Belum ada topik di kategori ini.</div>
    @endif
  </div>
</section>
@endsection
