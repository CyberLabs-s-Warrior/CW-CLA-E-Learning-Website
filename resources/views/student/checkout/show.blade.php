@extends('layouts.student')

@push('styles')
    <link rel="stylesheet" href="{{ asset('client/checkout.css') }}">
@endpush

@section('content')
    <div class="checkout-wrap">
        <div class="checkout-card">

            @php
                $status = strtolower($transaction->status ?? '');
                $statusClass = match ($status) {
                    'success', 'settlement', 'paid' => 'bg-success',
                    'pending' => 'bg-warning text-dark',
                    'expire', 'cancel', 'denied', 'failed' => 'bg-danger',
                    default => 'bg-secondary'
                };
              @endphp

            <div class="checkout-head">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M3 7h18M3 7l2 12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2l2-12M7 7V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2"
                        stroke="#0f172a" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <h2 class="checkout-title">Checkout: {{ $course->name }}</h2>
            </div>

            <div class="checkout-meta">
                <div class="meta-row">
                    <span class="label">Order ID</span>
                    <span>{{ $transaction->order_id }}</span>
                </div>

                <div class="meta-row">
                    <span class="label">Harga</span>
                    <span class="price">Rp {{ number_format($transaction->gross_amount, 0, ',', '.') }}</span>
                </div>

                <div class="meta-row">
                    <span class="label">Status</span>
                    <span class="badge rounded {{ $statusClass }}">{{ ucfirst($transaction->status) }}</span>
                </div>
            </div>

            <div class="checkout-actions">
                <form action="{{ route('payment.process', $transaction->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-pay">
                        {{-- ikon panah bayar --}}
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M5 12h12M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        Bayar Sekarang
                    </button>
                </form>
                <a href="{{ route('detail.index', $course->slug) }}" class="btn-back">
                    ← Kembali ke Detail Kursus
                </a>
                <p class="note">Dengan menekan “Bayar Sekarang”, Anda akan diarahkan ke proses pembayaran.</p>
            </div>

        </div>
    </div>
    @push('scripts')
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}">
        </script>
        <script>
            document.getElementById('pay-button').onclick = function (e) {
                e.preventDefault(); // cegah reload form

                fetch("{{ route('checkout') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        course_id: "{{ $course->id }}" // ambil dinamis dari blade
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.snap_token) {
                            window.snap.pay(data.snap_token, {
                                onSuccess: function (result) {
                                    console.log("Sukses", result);
                                },
                                onPending: function (result) {
                                    console.log("Pending", result);
                                },
                                onError: function (result) {
                                    console.log("Error", result);
                                },
                                onClose: function () {
                                    alert("Popup ditutup tanpa menyelesaikan pembayaran");
                                }
                            });
                        } else {
                            alert("Error: " + data.error);
                        }
                    });
            }
        </script>
    @endpush
@endsection