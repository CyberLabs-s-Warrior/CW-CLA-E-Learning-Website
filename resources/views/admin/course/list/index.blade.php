@extends('templates.app')

@section('title', 'Daftar Course')

@section('content')
<div class="container-fluid py-4">
  <div class="d-flex align-items-center mb-4">
    <div class="me-2">
      <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
        <i class="fas fa-chalkboard-teacher"></i>
      </div>
    </div>
    <h1 class="h4 fw-semibold mb-0">Daftar Course</h1>
  </div>

  <div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.course.create') }}" class="btn btn-primary rounded-pill px-4">
      <i class="fas fa-plus me-2"></i>Tambah Course
    </a>
  </div>

  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Gambar</th>
              <th>Nama</th>
              <th>Kategori</th>
              <th>Level</th>
              <th>Harga</th>
              <th>Range Harga</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($courses as $course)
              <tr>
                <td>
                  @if($course->img)
                    <img src="{{ asset('storage/' . $course->img) }}" alt="" class="img-thumbnail rounded shadow-sm" style="width: 60px; height: auto;">
                  @else
                    <span class="text-muted">-</span>
                  @endif
                </td>
                <td>{{ $course->name }}</td>
                <td>{{ $course->category->category ?? '-' }}</td>
                <td>{{ $course->level->level ?? '-' }}</td>
                <td>Rp{{ number_format($course->price) }}</td>
                <td>
                  @if ($course->priceRange)
                    Rp{{ number_format($course->priceRange->min_price) }} - Rp{{ number_format($course->priceRange->max_price) }}
                  @else
                    <span class="text-muted">Tidak Masuk Range</span>
                  @endif
                </td>
                <td>
                  <div class="d-flex gap-1">
                    <a href="{{ route('admin.course.edit', $course) }}" class="btn btn-sm btn-warning rounded-pill px-3">
                      <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <form action="{{ route('admin.course.destroy', $course) }}" method="POST" onsubmit="return confirm('Yakin hapus course ini?')">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-sm btn-danger rounded-pill px-3">
                        <i class="fas fa-trash-alt me-1"></i>Hapus
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center text-muted py-4">
                  <i class="fas fa-info-circle me-2"></i>Belum ada data course.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
