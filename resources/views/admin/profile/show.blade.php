@extends('templates.app') {{-- Sesuaikan dengan layout admin milikmu --}}

@section('title', 'Profil Saya')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow rounded-4 border-0">
                <div class="card-body p-5">

                    <div class="d-flex align-items-center mb-4">
                        <div class="me-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D8ABC&color=fff&size=100"
                                 alt="Avatar" class="rounded-circle shadow" width="80" height="80">
                        </div>
                        <div>
                            <h4 class="mb-1">{{ $user->name }}</h4>
                            <p class="text-muted mb-0">{{ $user->email }}</p>
                            <p class="text-muted mb-0">dibuat :{{ $user->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <h6 class="text-uppercase text-muted">Peran / Role</h6>
                        @foreach ($user->getRoleNames() as $role)
                            <span class="badge rounded-pill bg-gradient bg-primary me-1">{{ $role }}</span>
                        @endforeach
                    </div>

                    <div>
                        <a href="{{ route('admin.dashboard.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
