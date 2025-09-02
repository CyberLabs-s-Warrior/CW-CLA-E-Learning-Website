@extends('templates.app')
@section('title', 'Detail Kursus')

@section('content')
<div class="container-fluid py-4">
  {{-- Header --}}
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:40px;height:40px;">
        <i class="fas fa-eye"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Detail Kursus</h1>
  </div>

  {{-- Card utama --}}
  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">

      {{-- Media (cover) --}}
      <div class="text-center mb-4">
        @if($detail->course->img)
          <img src="{{ asset('storage/'.$detail->course->img) }}" 
               alt="cover" class="rounded-4 shadow-sm" 
               style="max-width:250px; max-height:250px; object-fit:cover;">
        @else
          <div class="text-muted fst-italic">Tidak ada media</div>
        @endif
      </div>

      {{-- Judul --}}
      <h3 class="fw-bold text-primary mb-3 text-center">{{ $detail->course->name ?? '-' }}</h3>

      {{-- Level & Duration --}}
      <div class="row mb-4">
        <div class="col-md-6 mb-3">
          <div class="p-3 bg-light rounded-3 shadow-sm h-100">
            <h6 class="text-muted mb-1"><i class="fas fa-signal me-2"></i>Level</h6>
            <p class="fw-semibold mb-0">{{ $detail->course->level->level ?? 'Tidak ada level' }}</p>
          </div>
        </div>
        <div class="col-md-6 mb-3">
          <div class="p-3 bg-light rounded-3 shadow-sm h-100">
            <h6 class="text-muted mb-1"><i class="fas fa-clock me-2"></i>Durasi</h6>
            <p class="fw-semibold mb-0">{{ $detail->course->formatted_duration ?? '-' }}</p>
          </div>
        </div>
      </div>

      {{-- Modul --}}
      <div class="mb-4">
        <h5 class="fw-bold mb-3"><i class="fas fa-list me-2 text-success"></i>Daftar Modul</h5>
        @if($detail->course->lessons->count())
          <ul class="list-group rounded-3 shadow-sm">
            @foreach($detail->course->lessons as $lesson)
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ $lesson->title }}</span>
                <span class="badge bg-primary rounded-pill">{{ $lesson->formatted_duration }}</span>
              </li>
            @endforeach
          </ul>
        @else
          <p class="text-muted fst-italic">Belum ada modul</p>
        @endif
      </div>

      {{-- Mentor --}}
      <div class="mb-4">
        <h5 class="fw-bold mb-3"><i class="fas fa-user-tie me-2 text-warning"></i>Mentor</h5>
        @if($detail->course->instructors->count())
          <ul class="list-inline mb-0">
            @foreach($detail->course->instructors as $instructor)
              <li class="list-inline-item">
                <span class="badge bg-secondary fs-6">{{ $instructor->name }}</span>
              </li>
            @endforeach
          </ul>
        @else
          <p class="text-muted fst-italic">Tidak ada mentor</p>
        @endif
      </div>

      {{-- Deskripsi --}}
      <div class="mb-4">
        <h5 class="fw-bold mb-3"><i class="fas fa-align-left me-2 text-info"></i>Deskripsi</h5>
        <div class="p-3 bg-light rounded-3 shadow-sm">{!! $detail->description !!}</div>
      </div>

      {{-- Hasil --}}
      <div class="mb-4">
        <h5 class="fw-bold mb-3"><i class="fas fa-check-circle me-2 text-success"></i>Hasil</h5>
        <div class="p-3 bg-light rounded-3 shadow-sm">{!! $detail->outcomes !!}</div>
      </div>

      {{-- Tombol Aksi --}}
      <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('admin.detail.index') }}" class="btn btn-secondary rounded-pill px-4">
          <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
        <a href="{{ route('admin.detail.edit',$detail) }}" class="btn btn-warning rounded-pill px-4">
          <i class="fas fa-edit me-2"></i>Edit
        </a>
      </div>

    </div>
  </div>
</div>
@endsection
