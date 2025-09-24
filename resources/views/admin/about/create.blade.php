@extends('templates.app')

@section('title', 'Tambah Konten About')

@section('content')
  <div class="container-fluid py-4">
    <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center"
      style="width: 40px; height: 40px;">
      <i class="fas fa-plus"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Tambah Konten About</h1>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger rounded-3 shadow-sm">
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
      <li><i class="fas fa-exclamation-circle me-1"></i>{{ $error }}</li>
    @endforeach
    </ul>
    </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body">
      <form action="{{ route('admin.about.store') }}" method="POST" enctype="multipart/form-data" id="createForm">
      @csrf

      <div class="mb-4">
        <label class="form-label fw-semibold">Section</label>
        <input list="section-list" name="section"
        class="form-control rounded-3 shadow-sm @error('section') is-invalid @enderror" value="{{ old('section') }}"
        required>

        <datalist id="section-list">
        @foreach ($sections as $section)
      <option value="{{ $section }}">
      @endforeach
        </datalist>

        @error('section')
      <small class="text-danger d-block mt-1">
      <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
      </small>
      @enderror
      </div>

      <div class="mb-4">
        <label class="form-label fw-semibold">Judul <span class="text-muted">(opsional)</span></label>
        <input type="text" name="title" class="form-control rounded-3 shadow-sm @error('title') is-invalid @enderror"
        value="{{ old('title') }}">
        @error('title')
      <small class="text-danger d-block mt-1">
      <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
      </small>
      @enderror
      </div>

      <div class="mb-4">
        <label class="form-label fw-semibold">Deskripsi <span class="text-muted">(opsional)</span></label>
        <textarea name="description" id="editor" rows="4"
        class="form-control rounded-3 shadow-sm @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
        @error('description')
      <small class="text-danger d-block mt-1">
      <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
      </small>
      @enderror
      </div>


      <div class="mb-4">
        <label class="form-label fw-semibold">Gambar <span class="text-muted">(opsional)</span></label>
        <input type="file" name="image" class="form-control rounded-3 shadow-sm @error('image') is-invalid @enderror">
        @error('image')
      <small class="text-danger d-block mt-1">
      <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
      </small>
      @enderror
      </div>
      <div class="mb-4">
  <label class="form-label fw-semibold">Urutan Tampil <span class="text-muted">(opsional)</span></label>
  <input type="number" name="display_order" class="form-control rounded-3"
         value="{{ old('display_order', $content->display_order ?? null) }}" placeholder="Contoh: 1">
  <div class="form-text">Angka kecil tampil lebih atas. Kosongkan bila tidak perlu.</div>
</div>


      <div class="d-flex justify-content-end mt-4">
        <button type="submit" class="btn btn-success rounded-pill px-4 me-2" id="submitBtn">
        <span id="btnText"><i class="fas fa-save me-2"></i>Simpan</span>
        </button>
        <a href="{{ route('admin.about.index') }}" class="btn btn-secondary rounded-pill px-4">
        <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
      </div>
      </form>
    </div>
    </div>
  </div>
@endsection

@section('scripts')

  <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
  <script>
    document.getElementById('createForm').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');

    btn.disabled = true;
    btnText.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
    });

        ClassicEditor
      .create(document.querySelector('#editor'))
      .catch(error => {
        console.error(error);
      });

    // Tombol submit loading
    document.getElementById('createForm').addEventListener('submit', function () {
      const btn = document.getElementById('submitBtn');
      const btnText = document.getElementById('btnText');

      btn.disabled = true;
      btnText.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
    });
  </script>
@endsection