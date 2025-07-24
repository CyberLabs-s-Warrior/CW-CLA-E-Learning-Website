@extends('templates.app')

@section('title', 'User Management')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Manajemen User</h4>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah User
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle shadow-sm rounded overflow-hidden">
            <thead class="table-light text-center align-middle">
                <tr>
                    <th style="width: 5%">#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th style="width: 30%">Role & Akses</th>
                    <th>Dibuat</th>
                    <th style="width: 15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $user)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <div class="mb-2">
                                @foreach($user->roles as $role)
                                    @if($role->name === 'superadmin')
                                        <span class="badge bg-danger text-white me-1">Superadmin</span>
                                    @else
                                        <span class="badge bg-primary text-white me-1">{{ ucfirst($role->name) }}</span>
                                    @endif
                                @endforeach

                            </div>

                            @php
                                $permissions = $user->getAllPermissions()->pluck('name')->toArray();
                            @endphp

                            @if ($permissions)
                                <button class="btn btn-sm btn-outline-secondary collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#perm-{{ $user->id }}"
                                        aria-expanded="false" aria-controls="perm-{{ $user->id }}">
                                    <i class="bi bi-eye me-1"></i> Tampilkan Akses
                                </button>
                                <div class="collapse mt-2" id="perm-{{ $user->id }}">
                                    <div class="border rounded p-2 bg-light">
                                        @foreach ($permissions as $permission)
                                            <span class="badge bg-secondary text-light me-1 mb-1">
                                                {{ str_replace('_', ' ', $permission) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </td>
                        <td>{{ $user->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</td>
                        <td class="text-center">
                            @if (!($user->is_superadmin && auth()->id() !== $user->id))
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                class="btn btn-sm btn-warning me-1"
                                data-bs-toggle="tooltip" title="Edit User">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            @endif

                            @unless ($user->is_superadmin)
                                <form action="{{ route('admin.users.destroy', $user->id) }}"
                                    method="POST" class="d-inline form-delete"
                                    data-nama="{{ $user->name }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger btn-delete"
                                            data-bs-toggle="tooltip" title="Hapus User">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @endunless
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada user</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltips.forEach(el => new bootstrap.Tooltip(el));

            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const form = button.closest('.form-delete');
                    const nama = form.getAttribute('data-nama');

                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: `User "${nama}" akan dihapus secara permanen.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: @json(session('success')),
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true
                });
            });
        </script>
    @elseif(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: @json(session('error')),
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            });
        </script>
    @endif
@endpush
