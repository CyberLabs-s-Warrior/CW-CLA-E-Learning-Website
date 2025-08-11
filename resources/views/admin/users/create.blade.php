@extends('templates.app')

@section('title', 'Tambah User')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="mb-4 fw-bold">Tambah User</h4>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Tambahkan id="createForm" untuk dikenali script --}}
                    <form id="createForm" action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" id="name" placeholder="Nama lengkap"
                                class="form-control @error('name') is-invalid @enderror" required
                                value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Profil</label>
                            <input type="file" name="foto" id="foto"
                                class="form-control @error('foto') is-invalid @enderror">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" placeholder="Email aktif"
                                class="form-control @error('email') is-invalid @enderror" required
                                value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" placeholder="Minimal 8 karakter"
                                class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="Ulangi password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="">-- Pilih Role --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                                        {{ ucfirst($role) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4" id="permission-wrapper" style="display: none;">
                            <label class="form-label fw-bold">Akses / Permissions</label>
                            <div class="row">
                                @php
                                    $grouped = [];
                                    foreach ($permissions as $permission) {
                                        $parts = explode('_', $permission->name);
                                        $fitur = end($parts);
                                        $grouped[$fitur][] = $permission;
                                    }
                                @endphp

                                @foreach ($grouped as $fitur => $perms)
                                    <div class="col-md-4 mb-3">
                                        <div class="border rounded p-3 bg-light">
                                            <strong class="text-uppercase small text-muted d-block mb-2">
                                                {{ ucfirst($fitur) }}
                                            </strong>
                                            @foreach ($perms as $permission)
                                                <div class="form-check mb-2">
                                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                        class="form-check-input" id="perm_{{ $permission->name }}">
                                                    <label class="form-check-label small" for="perm_{{ $permission->name }}">
                                                        {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success" id="btnSubmit">
                                <i class="bi bi-save me-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script Toggle Permissions --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const roleSelect = document.getElementById('role');
    const permissionWrapper = document.getElementById('permission-wrapper');
    const checkboxes = permissionWrapper.querySelectorAll('input[type="checkbox"]');

    const rolePermissions = @json($rolePermissions);

    function togglePermissions() {
        const selectedRole = roleSelect.value;
        if (selectedRole && rolePermissions[selectedRole]) {
            permissionWrapper.style.display = 'block';
            checkboxes.forEach(cb => cb.checked = false);
            rolePermissions[selectedRole].forEach(name => {
                const checkbox = document.getElementById(`perm_${name}`);
                if (checkbox) checkbox.checked = true;
            });
        } else {
            permissionWrapper.style.display = 'none';
            checkboxes.forEach(cb => cb.checked = false);
        }
    }

    togglePermissions();
    roleSelect.addEventListener('change', togglePermissions);
});
</script>

{{-- Script Tombol Submit jadi Spinner --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('createForm');
    const btnSubmit = document.getElementById('btnSubmit');
    const originalBtnHtml = btnSubmit.innerHTML;

    if (form && btnSubmit) {
        form.addEventListener('submit', function () {
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = `
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Menyimpan...
            `;

            // Jika submit gagal (misalnya validasi server), tombol kembali normal
            setTimeout(() => {
                if (document.querySelectorAll('.alert-danger').length > 0) {
                    btnSubmit.disabled = false;
                    btnSubmit.innerHTML = originalBtnHtml;
                }
            }, 500);
        });
    }
});
</script>

{{-- Bootstrap Icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
