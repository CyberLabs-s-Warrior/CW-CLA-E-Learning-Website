@extends('templates.app')
@section('title','Forum — Kategori')

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0">Kategori Forum</h1>
    <a href="{{ route('admin.forum.categories.create') }}" class="btn btn-primary">Tambah</a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card">
    <div class="card-body table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>Nama</th><th>Slug</th><th>Urutan</th><th>Privat?</th><th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($categories as $c)
            <tr>
              <td>{{ $c->name }}</td>
              <td>{{ $c->slug }}</td>
              <td>{{ $c->sort_order }}</td>
              <td>{{ $c->is_private ? 'Ya':'Tidak' }}</td>
              <td class="d-flex gap-2">
                <a class="btn btn-sm btn-warning" href="{{ route('admin.forum.categories.edit',$c) }}">Edit</a>
                <form method="POST" action="{{ route('admin.forum.categories.destroy',$c) }}" onsubmit="return confirm('Arsipkan kategori ini?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-muted">Belum ada kategori.</td></tr>
          @endforelse
        </tbody>
      </table>
      {{ $categories->links() }}
    </div>
  </div>
@endsection
