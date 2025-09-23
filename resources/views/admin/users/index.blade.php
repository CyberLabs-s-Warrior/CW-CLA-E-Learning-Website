@extends('templates.app')

@section('title', 'User Management')

@section('content')
    @php use Illuminate\Support\Facades\Storage; @endphp

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h4 class="fw-bold mb-0 d-flex align-items-center">
                <span class="bg-white rounded-circle shadow-sm d-inline-flex align-items-center justify-content-center me-2"
                    style="width: 40px; height: 40px;">
                    <i class="bi bi-people-fill" style="color: #0d6efd; font-size: 1.2rem;"></i>
                </span>
                Manajemen User
            </h4>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Tambah User
            </a>
        </div>

        {{-- Form Filter Otomatis --}}
        <form method="GET" id="filter-form" class="mb-4 d-flex flex-wrap gap-3 align-items-end">
            <div>
                <label for="role" class="form-label mb-1">Filter Role</label>
                <select name="role" id="role" class="form-select"
                    onchange="document.getElementById('filter-form').submit()">
                    <option value="">-- Semua Role --</option>
                    @foreach(['superadmin', 'admin', 'instructor', 'student'] as $roleItem)
                        <option value="{{ $roleItem }}" {{ request('role') == $roleItem ? 'selected' : '' }}>
                            {{ ucfirst($roleItem) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="permission" class="form-label mb-1">Filter Akses</label>
                <select name="permission" id="permission" class="form-select"
                    onchange="document.getElementById('filter-form').submit()">
                    <option value="">-- Semua Akses --</option>
                    @foreach($allPermissions as $perm)
                        <option value="{{ $perm->name }}" {{ request('permission') == $perm->name ? 'selected' : '' }}>
                            {{ str_replace('_', ' ', ucfirst($perm->name)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="search" class="form-label mb-1">Cari Nama</label>
                <div class="input-group">
                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Masukkan nama...">
                    <button type="submit" class="btn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        {{-- Alert filter aktif --}}
        @if(request()->filled('role') || request()->filled('permission') || request()->filled('search'))
            <div class="alert alert-info d-flex justify-content-between align-items-center">
                <div>
                    Menampilkan user
                    @if(request()->filled('search'))
                        dengan nama mengandung: <strong>"{{ request('search') }}"</strong>
                    @endif
                    @if(request()->filled('role'))
                        @if(request()->filled('search')) dan @endif
                        role: <strong>{{ ucfirst(request('role')) }}</strong>
                    @endif
                    @if(request()->filled('permission'))
                        @if(request()->filled('role') || request()->filled('search')) dan @endif
                        akses: <strong>{{ str_replace('_', ' ', request('permission')) }}</strong>
                    @endif
                </div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        @endif

        {{-- Tabel User --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle shadow-sm rounded overflow-hidden">
                <thead class="table-light text-center align-middle">
                    <tr>
                        <th style="width: 5%">No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th style="width: 20%">Role & Akses</th>
                        <th>Dibuat</th>
                        <th style="width: 15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                        @php
                            // Tentukan avatar: student → profile, lainnya → users.foto, fallback ke UI-Avatars
                            $avatar = $user->hasRole('student')
                                ? ($user->profile?->avatar_url ?? 'https://ui-avatars.com/api/?rounded=true&name='.urlencode($user->name))
                                : ($user->foto ? Storage::url($user->foto) : 'https://ui-avatars.com/api/?rounded=true&name='.urlencode($user->name));
                        @endphp

                        <tr>
                            <td class="text-center">{{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}</td>
                            <td>
                                <img src="{{ $avatar }}" width="50" height="50" class="rounded-circle object-fit-cover" alt="Foto {{ $user->name }}">
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <div class="mb-2">
                                    @php
                                        $roleColors = [
                                            'superadmin' => 'bg-danger',
                                            'admin' => 'bg-primary',
                                            'instructor' => 'bg-info',
                                            'student' => 'bg-bright-green'
                                        ];
                                    @endphp

                                    <style>
                                        .bg-bright-green {
                                            background-color: #28e36d !important;
                                            /* hijau cerah custom */
                                            color: #fff !important;
                                        }
                                    </style>

                                    @foreach($user->roles as $role)
                                        <span class="badge {{ $roleColors[$role->name] ?? 'bg-secondary' }} text-white me-1">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @endforeach
                                </div>

                                @php
                                $directPerms = $user->getDirectPermissions()->pluck('name')->toArray();
                                $rolePerms   = $user->getPermissionsViaRoles()->pluck('name')->toArray();
                                @endphp

                                @if (!$user->hasRole('superadmin') && (!empty($rolePerms) || !empty($directPerms)))
                                <button class="btn btn-sm btn-outline-secondary collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#perm-{{ $user->id }}">
                                    <i class="bi bi-eye me-1"></i> Tampilkan Akses
                                </button>
                                <div class="collapse mt-2" id="perm-{{ $user->id }}">
                                    <div class="border rounded p-2 bg-light">
                                    @if(!empty($rolePerms))
                                        <div class="mb-1"><small class="text-muted">Via Role</small></div>
                                        @foreach ($rolePerms as $p)
                                        <span class="badge bg-secondary text-light me-1 mb-1">{{ str_replace('_',' ',$p) }}</span>
                                        @endforeach
                                    @endif

                                    @if(!empty($directPerms))
                                        <div class="mt-2 mb-1"><small class="text-muted">Direct</small></div>
                                        @foreach ($directPerms as $p)
                                        <span class="badge bg-info text-dark me-1 mb-1">{{ str_replace('_',' ',$p) }}</span>
                                        @endforeach
                                    @endif
                                    </div>
                                </div>
                                @endif
                                                            </td>
                            <td>{{ $user->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</td>
                            <td class="text-center">
                                {{-- Edit: disembunyikan untuk student, dan tetap melindungi superadmin lain --}}
                                @if (!($user->is_superadmin && auth()->id() !== $user->id) && !$user->hasRole('student'))
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning me-1"
                                        data-bs-toggle="tooltip" title="Edit User">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                @endif

                                {{-- Modal Profil khusus student --}}
                                @if ($user->hasRole('student'))
                                    <button type="button" class="btn btn-sm btn-info me-1"
                                        data-bs-toggle="modal" data-bs-target="#profileModal-{{ $user->id }}">
                                        <i class="bi bi-person-badge"></i> Profil
                                    </button>
                                @endif

                                {{-- Hapus: diblokir untuk student, tetap nonaktif untuk superadmin --}}
                                @unless ($user->is_superadmin || $user->hasRole('student'))
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        class="d-inline form-delete" data-nama="{{ $user->name }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-bs-toggle="tooltip"
                                            title="Hapus User">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endunless
                            </td>
                        </tr>

                        {{-- Modal Profil Student --}}
                        @if ($user->hasRole('student'))
                            @php $p = $user->profile; @endphp
                            <div class="modal fade" id="profileModal-{{ $user->id }}" tabindex="-1"
                                 aria-labelledby="profileModalLabel-{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 rounded-4 shadow">
                                        <div class="modal-header bg-light border-0 rounded-top-4">
                                            <h5 class="modal-title fw-bold" id="profileModalLabel-{{ $user->id }}">
                                                Profil Student — {{ $user->name }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-3 align-items-center">
                                                <div class="col-auto">
                                                    <img src="{{ $p?->avatar_url ?? 'https://ui-avatars.com/api/?rounded=true&name='.urlencode($user->name) }}"
                                                         alt="Avatar" width="96" height="96"
                                                         class="rounded border object-fit-cover">
                                                </div>
                                                <div class="col">
                                                    <div class="row mb-2">
                                                        <div class="col-sm-4 text-muted">Email</div>
                                                        <div class="col-sm-8">{{ $user->email }}</div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-4 text-muted">Jenis Kelamin</div>
                                                        <div class="col-sm-8">{{ $p?->jenis_kelamin ?? '-' }}</div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-4 text-muted">Status</div>
                                                        <div class="col-sm-8">{{ $p?->status ?? '-' }}</div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-4 text-muted">Tanggal Lahir</div>
                                                        <div class="col-sm-8">
                                                            {{ optional($p?->tgl_lahir)->format('d M Y') ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-4 text-muted">Dibuat</div>
                                                        <div class="col-sm-8">{{ $user->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</div>
                                                    </div>
                                                </div>
                                            </div>

                                            @if(!$p)
                                                <div class="alert alert-warning mt-3 mb-0">
                                                    Data profil student belum lengkap/tersedia.
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada user</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $users->links() }}
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
                        background: 'linear-gradient(145deg, #e6f0ff, #f8fbff)',
                        color: '#1e3a8a',
                        iconColor: '#0d6efd',
                        showCancelButton: true,
                        confirmButtonColor: '#0d6efd',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="bi bi-check-circle me-1"></i> Ya, hapus!',
                        cancelButtonText: '<i class="bi bi-x-circle me-1"></i> Batal',
                        customClass: {
                            popup: 'rounded-4 shadow-lg border-0 p-3',
                            title: 'fw-bold fs-4 text-primary',
                            htmlContainer: 'mt-2 fs-6',
                            confirmButton: 'px-4 py-2 rounded-pill shadow-sm',
                            cancelButton: 'px-4 py-2 rounded-pill shadow-sm'
                        },
                        preConfirm: () => {
                            Swal.showLoading();
                            return new Promise((resolve) => {
                                setTimeout(resolve, 500);
                            });
                        }
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
                    background: 'linear-gradient(145deg, #e6f0ff, #f8fbff)',
                    color: '#1e3a8a',
                    iconColor: '#0d6efd',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'custom-swal-popup rounded-4 shadow-lg border-0 p-4',
                        title: 'fw-bold fs-4 text-primary custom-swal-title',
                        htmlContainer: 'mt-2 fs-6 custom-swal-text',
                        icon: 'custom-swal-icon'
                    },
                    didOpen: () => {
                        const icon = document.querySelector('.custom-swal-icon');
                        if (icon) {
                            icon.style.animation = 'bounceInIcon 0.6s ease, pulseBlue 1.5s infinite';
                        }
                    },
                    willClose: () => {
                        const popup = document.querySelector('.custom-swal-popup');
                        if (popup) {
                            popup.style.animation = 'fadeZoomOut 0.4s ease forwards';
                        }
                    }
                });
            });
        </script>

        <style>
            .custom-swal-popup {
                animation: fadeZoomIn 0.45s ease;
                backdrop-filter: blur(6px);
            }

            @keyframes fadeZoomOut {
                from { opacity: 1; transform: scale(1); }
                to { opacity: 0; transform: scale(0.85); }
            }

            @keyframes fadeZoomIn {
                from { opacity: 0; transform: scale(0.85); }
                to { opacity: 1; transform: scale(1); }
            }

            @keyframes bounceInIcon {
                0% { transform: translateY(50px) scale(0.8); opacity: 0; }
                60% { transform: translateY(-10px) scale(1.05); opacity: 1; }
                100% { transform: translateY(0) scale(1); }
            }

            @keyframes pulseBlue {
                0% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.6); }
                70% { box-shadow: 0 0 0 15px rgba(13, 110, 253, 0); }
                100% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0); }
            }

            .custom-swal-title {
                animation: fadeInDown 0.5s ease 0.2s both;
            }

            .custom-swal-text {
                animation: fadeInUp 0.5s ease 0.4s both;
            }

            @keyframes fadeInDown {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }

            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>
    @endif
@endpush
