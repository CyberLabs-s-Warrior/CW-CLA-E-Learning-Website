@extends('templates.app')

@section('title', 'Kontak')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex align-items-center mb-4">
            <div class="me-2">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-address-book"></i>
                </div>
            </div>
            <h1 class="h4 fw-semibold mb-0">Informasi Kontak</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center shadow-sm rounded-3">
                <i class="fas fa-check-circle me-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="card border-0 shadow rounded-4">
            <div class="card-header bg-white border-bottom-0 rounded-top-4 pb-0">
                <h6 class="mb-0 fw-bold text-muted">
                    <i class="fas fa-info-circle me-2 text-primary"></i> Detail Kontak
                </h6>
            </div>

            <div class="card-body pt-2">
                <div class="mb-3 d-flex align-items-start">
                    <div class="me-3">
                        <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                    <div>
                        <div class="fw-semibold">Email</div>
                        <div class="text-muted">
                            {{ $contact->email ?? '-' }}
                        </div>
                    </div>
                </div>

                <div class="mb-3 d-flex align-items-start">
                    <div class="me-3">
                        <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="fas fa-phone"></i>
                        </div>
                    </div>
                    <div>
                        <div class="fw-semibold">Telepon</div>
                        <div class="text-muted">
                            {{ $contact->phone_number ?? '-' }}
                        </div>
                    </div>
                </div>

                <div class="mb-3 d-flex align-items-start">
                    <div class="me-3">
                        <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                    </div>
                    <div>
                        <div class="fw-semibold">Lokasi</div>
                        <div class="text-muted">
                            @if($contact->location_url && $contact->location_label)
                                <a href="{{ $contact->location_url }}" target="_blank" class="text-decoration-none text-primary">
                                    {{ $contact->location_label }}
                                    <i class="fas fa-external-link-alt ms-1" style="font-size: 0.8rem;"></i>
                                </a>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <a href="{{ route('admin.contact.edit') }}" class="btn btn-outline-primary rounded-pill px-4">
                        <i class="fas fa-edit me-2"></i>Edit Kontak
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
