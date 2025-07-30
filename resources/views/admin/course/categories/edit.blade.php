@extends('templates.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="container-fluid py-4">
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
        <i class="fas fa-edit"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Edit Kategori</h1>
  </div>

  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white fw-semibold text-primary border-bottom-0">
      <i class="fas fa-folder-tree me-2"></i>Form Edit Kategori
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('admin.course-categories.update', $category->id) }}" class="d-flex flex-column gap-3">
        @csrf
        @method('PUT')

        <input type="text" name="category" class="form-control shadow-sm" value="{{ $category->category }}" required>

        <button type="submit" class="btn btn-warning rounded-pill w-auto align-self-start">
          <i class="fas fa-save me-1"></i> Update
        </button>
      </form>
    </div>
  </div>
</div>
@endsection
