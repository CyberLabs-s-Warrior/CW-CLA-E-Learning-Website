@extends('layouts.guest')
@section('title','Buat Topik')

@section('content')
<style>
  :root{
    --bg:#0b0f19; --surface:#111827; --surface-2:#0f172a;
    --text:#e5e7eb; --muted:#94a3b8; --brand:#3b82f6;
    --danger:#ef4444; --border:#1f2937; --radius:14px; --shadow:0 10px 30px rgba(0,0,0,.25);
  }
  .compose-page{color:var(--text)}
  .compose-page .container{max-width:820px;margin:0 auto;padding:0 16px}

  .title{font-size:clamp(22px,2.2vw,30px);font-weight:800;letter-spacing:.2px;margin:0 0 12px}

  .card{
    background:linear-gradient(180deg,var(--surface),var(--surface-2));
    border:1px solid var(--border); border-radius:var(--radius); box-shadow:0 0 0 rgba(0,0,0,0);
    padding:18px;
  }

  /* Alerts */
  .alert{padding:12px 14px;border-radius:12px;margin-bottom:12px}
  .alert-danger{background:rgba(239,68,68,.1); border:1px solid rgba(239,68,68,.35); color:#fecaca}

  /* Form */
  .field{margin-bottom:14px}
  .label{display:flex;justify-content:space-between;align-items:flex-end; gap:8px;
         font-weight:700;color:var(--muted);margin-bottom:8px}
  .hint{font-weight:500;color:var(--muted);font-size:12px}
  .counter{font-size:12px;color:var(--muted)}
  select, input[type="text"], .textarea{
    width:100%; border-radius:12px; border:1px solid var(--border);
    background:var(--surface-2); color:var(--text);
    padding:10px 12px; outline:none; transition:box-shadow .15s ease, border-color .15s ease;
  }
  select:focus, input[type="text"]:focus, .textarea:focus{
    border-color:rgba(59,130,246,.45); box-shadow:0 0 0 3px rgba(59,130,246,.15)
  }
  .is-invalid{ border-color: rgba(239,68,68,.65) !important; box-shadow:0 0 0 3px rgba(239,68,68,.15) !important; }
  .error-msg{margin-top:6px; color:#fecaca; font-size:12px}

  .textarea{min-height:180px; resize:vertical}

  /* Buttons */
  .actions{display:flex;gap:10px;flex-wrap:wrap;margin-top:10px}
  .btn{
    display:inline-flex;align-items:center;justify-content:center;gap:8px;
    height:40px;padding:0 14px;border-radius:10px;border:1px solid transparent;
    font-weight:700;cursor:pointer;text-decoration:none;
    transition:transform .08s ease, filter .2s ease;
  }
  .btn:active{transform:translateY(1px)}
  .btn-primary{background:linear-gradient(180deg,var(--brand),#60a5fa);color:#fff}
  .btn-secondary{background:#334155;color:#e5e7eb}
</style>

<section class="compose-page">
  <div class="container py-4">
    <h1 class="title">Buat Topik</h1>

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('forum.thread.store') }}" class="card" id="threadForm">
      @csrf

      {{-- Kategori --}}
      <div class="field">
        <div class="label">
          <label for="category_id">Kategori</label>
          <span class="hint">Pilih ruang diskusi yang paling pas</span>
        </div>
        <select id="category_id" name="category_id" required
          class="@error('category_id') is-invalid @enderror">
          <option value="">— Pilih —</option>
          @foreach($categories as $c)
            <option value="{{ $c->id }}" @selected(old('category_id')==$c->id)>{{ $c->name }}</option>
          @endforeach
        </select>
        @error('category_id') <div class="error-msg">{{ $message }}</div> @enderror
      </div>

      {{-- Judul --}}
      <div class="field">
        <div class="label">
          <label for="title">Judul</label>
          <span class="counter"><span id="titleCount">0</span>/140</span>
        </div>
        <input id="title" type="text" name="title" maxlength="140"
               value="{{ old('title') }}"
               placeholder="Contoh: Cara memahami konsep OOP di PHP?"
               class="@error('title') is-invalid @enderror" required>
        <div class="hint">Minimal 5 karakter. Buat padat & jelas.</div>
        @error('title') <div class="error-msg">{{ $message }}</div> @enderror
      </div>

      {{-- Isi --}}
      <div class="field">
        <div class="label">
          <label for="body">Isi</label>
          <span class="counter"><span id="bodyCount">0</span> karakter</span>
        </div>
        <textarea id="body" name="body" class="textarea @error('body') is-invalid @enderror"
                  placeholder="Jelaskan konteks, apa yang sudah dicoba, dan error (jika ada)..." required>{{ old('body') }}</textarea>
        <div class="hint">Minimal 10 karakter. Sertakan detail agar mudah dibantu.</div>
        @error('body') <div class="error-msg">{{ $message }}</div> @enderror
      </div>

      <div class="actions">
        <button class="btn btn-primary" type="submit">Kirim</button>
        <a href="{{ route('forum.index') }}" class="btn btn-secondary">Batal</a>
      </div>
    </form>
  </div>
</section>

<script>
  (function(){
    const title = document.getElementById('title');
    const body = document.getElementById('body');
    const tc = document.getElementById('titleCount');
    const bc = document.getElementById('bodyCount');
    const form = document.getElementById('threadForm');

    function updateCounts(){
      tc.textContent = (title?.value || '').length;
      bc.textContent = (body?.value || '').length;
    }
    ['input','change'].forEach(evt=>{
      title?.addEventListener(evt, updateCounts);
      body?.addEventListener(evt, updateCounts);
    });
    updateCounts();

    // Client-side guard ringan sesuai blueprint (tidak mengganti validasi server)
    form?.addEventListener('submit', function(e){
      const titleLen = (title?.value || '').trim().length;
      const bodyLen  = (body?.value  || '').trim().length;
      let ok = true;

      // min 5 judul, min 10 body
      if(titleLen < 5){
        title.classList.add('is-invalid'); ok = false;
      } else { title.classList.remove('is-invalid'); }
      if(bodyLen < 10){
        body.classList.add('is-invalid'); ok = false;
      } else { body.classList.remove('is-invalid'); }

      if(!ok){
        e.preventDefault();
        title?.focus();
      }
    });
  })();
</script>
@endsection
