@extends('templates.app')

@section('title', 'Edit User')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="mb-4 fw-bold">Edit User</h4>

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

                    <form id="editUserForm" action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" id="name" class="form-control" required
                                   value="{{ old('name', $user->name) }}">
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Profil (opsional)</label>
                            <input type="file" name="foto" id="foto" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required
                                   value="{{ old('email', $user->email) }}">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru (kosongkan jika tidak ingin diubah)</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        </div>

                        @if (!$user->hasRole('superadmin'))
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select name="role" id="role" class="form-select" required>
                                    <option value="">-- Pilih Role --</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}" {{ $user->hasRole($role) ? 'selected' : '' }}>
                                            {{ ucfirst($role) }}
                                        </option>
                                    @endforeach
                                </select>
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
                                                        <input type="checkbox"
                                                               name="permissions[]"
                                                               value="{{ $permission->name }}"
                                                               class="form-check-input"
                                                               id="perm_{{ $permission->name }}"
                                                               {{ $user->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                        <label class="form-check-label small"
                                                               for="perm_{{ $permission->name }}">
                                                            {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" id="btnSubmit" class="btn btn-primary">
                                <span id="btnText"><i class="bi bi-save me-1"></i> Update</span>
                                <span id="btnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.getElementById('role');
        const permissionWrapper = document.getElementById('permission-wrapper');

        function togglePermissions() {
            if (roleSelect && (roleSelect.value === 'admin' || roleSelect.value === 'instructor')) {
                permissionWrapper.style.display = 'block';
            } else {
                permissionWrapper.style.display = 'none';
                permissionWrapper.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
            }
        }

        togglePermissions();
        if (roleSelect) {
            roleSelect.addEventListener('change', togglePermissions);
        }

        // Spinner saat submit
        const form = document.getElementById('editUserForm');
        const btnSubmit = document.getElementById('btnSubmit');
        const btnText = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');

        form.addEventListener('submit', function () {
            btnSubmit.disabled = true;
            btnText.textContent = 'Menyimpan...';
            btnSpinner.classList.remove('d-none');
        });
    });
</script>

{{-- Bootstrap Icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
