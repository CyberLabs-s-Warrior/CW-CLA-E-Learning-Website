@extends('templates.app') {{-- ganti sesuai layout adminmu --}}

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Testimoni</h1>
    <a href="{{ route('admin.testimoni.create') }}" class="btn btn-primary">Tambah</a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table mb-0">  
          <thead>
            <tr>
              <th style="width:60px">#</th>
              <th>Student</th>
              <th>Ulasan</th>
              <th>Publish</th>
              <th style="width:180px"></th>
            </tr>
          </thead>
          <tbody>
            @forelse($items as $i => $row)
              @php
                $name = $row->user->name ?? '-';
                $parts = preg_split('/\s+/', trim($name));
                $initials = strtoupper(mb_substr($parts[0] ?? '', 0, 1) . mb_substr(end($parts) ?: '', 0, 1));
                $hue = crc32($name) % 360;
              @endphp
              <tr>
                <td>{{ $items->firstItem() + $i }}</td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                         style="width:34px;height:34px;background:hsl({{ $hue }} 85% 90%);font-weight:700;">
                      {{ $initials }}
                    </div>
                    {{ $name }}
                  </div>
                </td>
                <td>{{ \Illuminate\Support\Str::limit($row->content, 90) }}</td>
                <td>
                  <span class="badge bg-{{ $row->is_published ? 'success' : 'secondary' }}">
                    {{ $row->is_published ? 'Ya' : 'Tidak' }}
                  </span>
                </td>
                <td class="text-end">
                <a href="{{ route('admin.testimoni.edit', ['testimoni' => $row]) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                  
                <form action="{{ route('admin.testimoni.destroy', ['testimoni' => $row]) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Hapus testimoni ini?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                </form>
                                </td>
              </tr>
            @empty
              <tr><td colspan="5" class="text-center text-muted p-4">Belum ada data</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    @if($items instanceof \Illuminate\Pagination\LengthAwarePaginator)
      <div class="card-footer">{{ $items->links() }}</div>
    @endif
  </div>
</div>
@endsection
