@extends('templates.app') {{-- ganti sesuai layout adminmu --}}

@section('content')
<div class="container py-4" style="max-width: 800px">
  <h1 class="h4 mb-3">Tambah Testimoni</h1>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.testimoni.store') }}" method="POST">
        @csrf

        <div class="mb-3">
          <label for="user_id" class="form-label">Pilih Student</label>
          <select name="user_id" id="user_id" class="form-select" required>
            <option value="">-- pilih --</option>
            @foreach($students as $u)
              <option value="{{ $u->id }}" @selected(old('user_id')==$u->id)>{{ $u->name }}</option>
            @endforeach
          </select>
          @error('user_id') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
          <label for="content" class="form-label">Ulasan</label>
          <textarea name="content" id="content" rows="5" class="form-control" required>{{ old('content') }}</textarea>
          @error('content') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="form-check form-switch mb-3">
        {{-- fallback saat unchecked --}}
        <input type="hidden" name="is_published" value="0">
        <input class="form-check-input" type="checkbox" role="switch"
                id="is_published" name="is_published" value="1"
                @checked(old('is_published', true))>  {{-- default nyala di create --}}
        <label class="form-check-label" for="is_published">Publish</label>
        </div>


        <div class="d-flex gap-2">
          <a href="{{ route('admin.testimoni.index') }}" class="btn btn-light">Batal</a>
          <button class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
