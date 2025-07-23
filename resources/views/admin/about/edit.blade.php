@extends('templates.app')

@section('title', 'Edit Konten About')

@section('content')
<div class="container-fluid py-4">
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
        <i class="fas fa-pen"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Edit Konten About</h1>
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
      <form id="editForm" action="{{ route('admin.about.update', $content->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
          <label class="form-label fw-semibold">Section <span class="text-danger">*</span></label>
          <input list="section-list" name="section" id="section"
                 class="form-control rounded-3 shadow-sm @error('section') is-invalid @enderror"
                 value="{{ old('section', $content->section) }}" placeholder="Ketik atau pilih section..." required>
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
          <div class="form-text text-muted mt-1">Anda bisa memilih dari daftar atau mengetik section baru.</div>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">Judul <span class="text-muted">(opsional)</span></label>
          <input type="text" name="title"
                 class="form-control rounded-3 shadow-sm @error('title') is-invalid @enderror"
                 value="{{ old('title', $content->title) }}">
          @error('title')
            <small class="text-danger d-block mt-1">
              <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
            </small>
          @enderror
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">Deskripsi <span class="text-muted">(opsional)</span></label>
          <textarea name="description" rows="4"
                    class="form-control rounded-3 shadow-sm @error('description') is-invalid @enderror">{{ old('description', $content->description) }}</textarea>
          @error('description')
            <small class="text-danger d-block mt-1">
              <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
            </small>
          @enderror
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">Gambar Saat Ini</label><br>
          @if($content->image)
            <img src="{{ asset('storage/' . $content->image) }}" class="img-thumbnail rounded shadow-sm mt-2" width="120" alt="Current Image">
          @else
            <p class="text-muted mt-2">Tidak ada gambar.</p>
          @endif
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">Ganti Gambar (opsional)</label>
          <input type="file" name="image"
                 class="form-control rounded-3 shadow-sm @error('image') is-invalid @enderror">
          @error('image')
            <small class="text-danger d-block mt-1">
              <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
            </small>
          @enderror
        </div>

        <div class="d-flex justify-content-end mt-4">
          <button type="submit" id="submitBtn" class="btn btn-success rounded-pill px-4 me-2 d-flex align-items-center gap-2">
            <span id="spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            <span id="btnText"><i class="fas fa-save me-1"></i>Update</span>
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
<script>
  document.getElementById('editForm').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    document.getElementById('spinner').classList.remove('d-none');
    document.getElementById('btnText').textContent = 'Menyimpan...';
    btn.disabled = true;
  });
</script>
@endsection
