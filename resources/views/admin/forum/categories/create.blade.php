@extends('templates.app')
@section('title','Form Kategori Forum')

@section('content')
  <h1 class="mb-3">{{ isset($category) ? 'Edit' : 'Tambah' }} Kategori</h1>

  <form method="POST" action="{{ isset($category) ? route('admin.forum.categories.update',$category) : route('admin.forum.categories.store') }}">
    @csrf
    @if(isset($category)) @method('PUT') @endif

    <div class="mb-3">
      <label class="form-label">Nama</label>
      <input name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" required>
      @error('name') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Slug (opsional)</label>
      <input name="slug" class="form-control" value="{{ old('slug', $category->slug ?? '') }}">
      @error('slug') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Deskripsi</label>
      <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description ?? '') }}</textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Urutan</label>
      <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $category->sort_order ?? 0) }}">
    </div>

    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" name="is_private" value="1"
        {{ old('is_private', $category->is_private ?? false) ? 'checked' : '' }}>
      <label class="form-check-label">Kategori Privat</label>
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.forum.categories.index') }}" class="btn btn-secondary">Batal</a>
  </form>
@endsection
