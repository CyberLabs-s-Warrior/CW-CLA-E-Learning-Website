@extends('templates.app')

@section('title', 'Edit Level')

@section('content')
<div class="container-fluid py-4">
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
        <i class="fas fa-signal"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Edit Level</h1>
  </div>

  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white fw-semibold text-success border-bottom-0">
      <i class="fas fa-signal me-2"></i>Form Edit Level
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('admin.course-levels.update', $level->id) }}" class="d-flex flex-column gap-3">
        @csrf
        @method('PUT')

        <input type="text" name="level" class="form-control shadow-sm" value="{{ $level->level }}" required>

        <button type="submit" class="btn btn-success rounded-pill w-auto align-self-start">
          <i class="fas fa-save me-1"></i> Update
        </button>
      </form>
    </div>
  </div>
</div>
@endsection
