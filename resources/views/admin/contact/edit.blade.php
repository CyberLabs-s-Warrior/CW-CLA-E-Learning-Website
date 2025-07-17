@extends('templates.app')

@section('title', 'Edit Kontak')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center mb-4">
        <div class="me-2">
            <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center"
                style="width: 40px; height: 40px;">
                <i class="fas fa-edit"></i>
            </div>
        </div>
        <h1 class="h4 fw-semibold mb-0">Edit Kontak</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger rounded-3 shadow-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="fas fa-exclamation-circle me-1"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow rounded-4 border-0">
        <div class="card-body">
            <form action="{{ route('admin.contact.update') }}" method="POST" id="editContactForm">
                @csrf

                <div class="mb-4">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control rounded-3 shadow-sm"
                        value="{{ old('email', $contact->email) }}">
                    @error('email')
                        <small class="text-danger d-block mt-1">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Telepon</label>
                    <input type="text" name="phone_number" class="form-control rounded-3 shadow-sm"
                        value="{{ old('phone_number', $contact->phone_number) }}">
                    @error('phone_number')
                        <small class="text-danger d-block mt-1">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Label Lokasi (nama tempat)</label>
                    <input type="text" name="location_label" class="form-control rounded-3 shadow-sm"
                        value="{{ old('location_label', $contact->location_label) }}">
                    @error('location_label')
                        <small class="text-danger d-block mt-1">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">URL Lokasi (Google Maps)</label>
                    <input type="text" name="location_url" class="form-control rounded-3 shadow-sm"
                        value="{{ old('location_url', $contact->location_url) }}">
                    @error('location_url')
                        <small class="text-danger d-block mt-1">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" id="submitBtn" class="btn btn-success rounded-pill px-4 me-2">
                        <span id="btnText"><i class="fas fa-save me-2"></i>Simpan</span>
                    </button>
                    <a href="{{ route('admin.contact.index') }}" class="btn btn-secondary rounded-pill px-4">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('editContactForm').addEventListener('submit', function () {
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');

        submitBtn.disabled = true;
        btnText.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
    });
</script>
@endsection
