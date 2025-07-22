@extends('templates.app')

@section('title', 'Edit User')

@section('content')

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="mb-4 fw-bold">Edit User</h4>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" name="name" id="name"
                            value="{{ old('name', $user->name) }}"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Nama lengkap" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email"
                            value="{{ old('email', $user->email) }}"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="Email aktif" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                        @enderror
                    </div>

                    {{-- Password Baru --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru
                            <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small>
                        </label>
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Minimal 8 karakter">
                        @error('password')
                            <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control" placeholder="Ulangi password baru">
                    </div>

                    @php
                        $isSuperadmin = $user->hasRole('superadmin');
                    @endphp

                    {{-- Role --}}
                    @if(!$isSuperadmin)
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="">-- Pilih Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role }}" {{ $user->hasRole($role) ? 'selected' : '' }}>
                                    {{ ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $errors->first('role') }}</div>
                        @enderror
                    </div>
                    @endif

                    {{-- Permissions --}}
                    @if(!$isSuperadmin)
                    <div class="mb-4" id="permission-wrapper" style="display: none;">
                        <label class="form-label fw-bold">Akses / Permissions</label>
                        <div class="row">
                            @php
                                $grouped = [];
                                foreach($permissions as $permission) {
                                    $parts = explode('_', $permission->name);
                                    $fitur = end($parts);
                                    $grouped[$fitur][] = $permission;
                                }
                            @endphp

                            @foreach($grouped as $fitur => $perms)
                                <div class="col-md-4 mb-3">
                                    <div class="border rounded p-3 bg-light">
                                        <strong class="text-uppercase small text-muted d-block mb-2">
                                            {{ ucfirst($fitur) }}
                                        </strong>
                                        @foreach($perms as $permission)
                                            <div class="form-check mb-2">
                                                <input type="checkbox"
                                                    name="permissions[]"
                                                    value="{{ $permission->name }}"
                                                    class="form-check-input"
                                                    id="perm_{{ $permission->name }}"
                                                    {{ in_array($permission->name, $userPermissions) ? 'checked' : '' }}>
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
                    @endif

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save me-1"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        const permissionWrapper = document.getElementById('permission-wrapper');

        if (!roleSelect || !permissionWrapper) return;

        function togglePermissions() {
            if (roleSelect.value === 'admin') {
                permissionWrapper.style.display = 'block';
            } else {
                permissionWrapper.style.display = 'none';
                permissionWrapper.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
            }
        }

        togglePermissions();
        roleSelect.addEventListener('change', togglePermissions);
    });
</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


@endsection
