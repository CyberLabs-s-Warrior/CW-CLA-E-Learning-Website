@extends('templates.app')
@section('title','Forum — Kategori')

@section('content')
<div class="container-fluid">

  {{-- Header --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 fw-bold text-dark">Kategori Forum</h1>
    <a href="{{ route('admin.forum.categories.create') }}" class="btn btn-primary shadow-sm">
      <i class="fa fa-plus me-1"></i> Tambah Kategori
    </a>
  </div>

  {{-- Alert --}}
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
      <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  {{-- Card Table --}}
  <div class="card shadow-sm border-0">
    <div class="card-header bg-light fw-semibold">
      Daftar Kategori
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-secondary">
            <tr>
              <th>Nama</th>
              <th>Slug</th>
              <th>Urutan</th>
              <th>Status</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($categories as $c)
              <tr>
                <td class="fw-medium">{{ $c->name }}</td>
                <td><span class="text-muted">{{ $c->slug }}</span></td>
                <td>{{ $c->sort_order }}</td>
                <td>
                  @if($c->is_private)
                    <span class="badge bg-danger">Privat</span>
                  @else
                    <span class="badge bg-success">Publik</span>
                  @endif
                </td>
                <td class="text-center">
                  <div class="btn-group btn-group-sm" role="group">
                    <a class="btn btn-warning text-white" 
                       href="{{ route('admin.forum.categories.edit',$c) }}">
                      <i class="fa fa-edit"></i>
                    </a>
                    <form method="POST" 
                          action="{{ route('admin.forum.categories.destroy',$c) }}" 
                          onsubmit="return confirm('Arsipkan kategori ini?')">
                      @csrf @method('DELETE')
                      <button class="btn btn-danger">
                        <i class="fa fa-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted py-4">
                  <i class="fa fa-folder-open me-2"></i> Belum ada kategori.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer">
      {{ $categories->links() }}
    </div>
  </div>
</div>
@endsection
