@extends('layouts.guest')
@section('title','Forum')

@section('content')
<style>
  /* ===== Design Tokens (bisa disesuaikan) ===== */
  :root {
    --bg: #0b0f19;                 /* cocok utk dark UI, adjust kalau pakai light */
    --surface: #111827;
    --surface-2: #0f172a;
    --text: #e5e7eb;
    --muted: #94a3b8;
    --brand: #3b82f6;
    --brand-2: #60a5fa;
    --border: #1f2937;
    --success: #16a34a;
    --warning: #f59e0b;
    --secondary: #64748b;
    --shadow: 0 10px 30px rgba(0,0,0,.25);
    --radius: 14px;
  }

  /* Scope khusus halaman forum supaya tidak ganggu halaman lain */
  .forum-page {
    color: var(--text);
  }
  .forum-page .container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 16px;
  }

  /* Header */
  .forum-header {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 12px;
    align-items: center;
    margin-bottom: 18px;
  }
  .forum-title {
    font-size: clamp(24px, 2vw, 32px);
    font-weight: 800;
    letter-spacing: .2px;
  }

  /* Button minimal (local) */
  .btn {
    display: inline-flex; align-items: center; justify-content: center;
    gap: 8px;
    height: 40px; padding: 0 14px;
    border-radius: 10px; border: 1px solid transparent;
    font-weight: 600; text-decoration: none;
    transition: transform .08s ease, background .2s ease, border-color .2s ease, color .2s ease;
    cursor: pointer;
  }
  .btn:active { transform: translateY(1px); }
  .btn-primary {
    background: linear-gradient(180deg, var(--brand), var(--brand-2));
    color: white;
    box-shadow: var(--shadow);
  }
  .btn-outline {
    background: transparent;
    border-color: var(--brand);
    color: var(--brand-2);
  }
  .btn:hover { filter: brightness(1.06); }

  /* Section Title */
  .section-head {
    display: flex; align-items: center; justify-content: space-between;
    margin: 26px 0 14px;
  }
  .section-head h5 {
    margin: 0; font-size: 16px; letter-spacing: .3px; color: var(--muted);
  }

  /* Kategori Grid */
  .cat-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 14px;
  }
  .cat-card {
    display: block;
    background: linear-gradient(180deg, var(--surface), var(--surface-2));
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 16px;
    text-decoration: none;
    color: var(--text);
    box-shadow: 0 0 0 rgba(0,0,0,0);
    transition: transform .15s ease, box-shadow .2s ease, border-color .2s ease;
    min-height: 110px;
  }
  .cat-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow);
    border-color: rgba(59,130,246,.35);
  }
  .cat-card .title {
    font-weight: 700; margin: 0 0 6px; font-size: 16px;
  }
  .cat-card .desc {
    margin: 0; color: var(--muted); font-size: 13px; line-height: 1.45;
  }

  /* Divider */
  .divider {
    margin: 26px 0;
    height: 1px; background: var(--border);
    border: 0;
  }

  /* Thread List */
  .thread-list {
    display: grid; gap: 10px;
  }
  .thread-item {
    display: block;
    background: linear-gradient(180deg, var(--surface), var(--surface-2));
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 14px 16px;
    text-decoration: none; color: var(--text);
    transition: border-color .2s ease, box-shadow .2s ease, transform .12s ease;
  }
  .thread-item:hover {
    border-color: rgba(59,130,246,.35);
    box-shadow: var(--shadow);
    transform: translateY(-1px);
  }
  .thread-row {
    display: grid; grid-template-columns: 1fr auto; gap: 12px; align-items: start;
  }
  .thread-meta {
    display: inline-flex; gap: 8px; align-items: center; flex-wrap: wrap;
    margin-left: 6px;
    color: var(--muted); font-size: 12px;
  }
  .thread-title {
    font-weight: 700; letter-spacing: .2px;
  }
  .thread-time { color: var(--muted); font-size: 12px; white-space: nowrap; }

  /* Chips (Pinned/Locked) */
  .chip {
    display: inline-flex; align-items: center; gap: 6px;
    height: 22px; padding: 0 8px;
    border-radius: 999px; font-size: 11px; font-weight: 700; letter-spacing: .2px;
  }
  .chip-pinned { background: rgba(245,158,11,.15); color: #fbbf24; border: 1px solid rgba(245,158,11,.35); }
  .chip-locked { background: rgba(100,116,139,.15); color: #cbd5e1; border: 1px solid rgba(100,116,139,.35); }

  /* Empty State */
  .empty {
    color: var(--muted);
    border: 1px dashed var(--border);
    border-radius: var(--radius);
    padding: 18px; text-align: center;
    background: linear-gradient(180deg, var(--surface), var(--surface-2));
  }

  /* Responsive */
  @media (max-width: 640px) {
    .forum-header { grid-template-columns: 1fr; }
    .thread-row { grid-template-columns: 1fr; gap: 6px; }
    .thread-time { text-align: right; }
  }
</style>

<section class="forum-page">
  <div class="container py-4">
    <div class="forum-header">
      <h1 class="forum-title">Forum</h1>

      @auth
        <a href="{{ route('forum.thread.create') }}" class="btn btn-primary">Buat Topik</a>
      @else
        <a href="{{ route('login') }}" class="btn btn-outline">Masuk untuk Buat Topik</a>
      @endauth
    </div>

    <div class="section-head">
      <h5>Kategori</h5>
    </div>

    <div class="cat-grid">
      @foreach($categories as $cat)
        <a class="cat-card" href="{{ route('forum.category',$cat->slug) }}" aria-label="Kategori {{ $cat->name }}">
          <h3 class="title">{{ $cat->name }}</h3>
          <p class="desc">{{ $cat->description }}</p>
        </a>
      @endforeach
    </div>

    <hr class="divider">

    <div class="section-head">
      <h5>Topik Terbaru</h5>
    </div>

    @forelse($threads as $t)
      <a class="thread-item"
         href="{{ route('forum.thread.show',['id'=>$t->id,'slug'=>Str::slug($t->title)]) }}"
         aria-label="Buka topik: {{ $t->title }}">
        <div class="thread-row">
          <div>
            <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
              @if($t->pinned_at)
                <span class="chip chip-pinned">Pinned</span>
              @endif
              @if($t->is_locked)
                <span class="chip chip-locked">Locked</span>
              @endif
              <span class="thread-title">{{ $t->title }}</span>
            </div>
            <div class="thread-meta">
              <span>— {{ $t->category->name }}</span>
              <span>• oleh {{ $t->user->name }}</span>
            </div>
          </div>
          <div class="thread-time">{{ $t->updated_at->diffForHumans() }}</div>
        </div>
      </a>
    @empty
      <div class="empty">Belum ada topik.</div>
    @endforelse
  </div>
</section>
@endsection
