@extends('layouts.student')

@push('styles')
    <link rel="stylesheet" href="{{ asset('client/payment.css') }}">
@endpush

@section('content')
        <div class="pay-container">
        <h2 class="pay-title">Pembayaran Kursus</h2>

        <div class="pay-info">
            <p><strong>Kursus:</strong> {{ $transaction->course->name }}</p>
            <p><strong>Order ID:</strong> {{ $transaction->order_id }}</p>
            <p><strong>Harga:</strong> Rp {{ number_format($transaction->gross_amount, 0, ',', '.') }}</p>
        </div>

        <button id="pay-button" class="pay-button">Bayar Sekarang</button>
    </div>

    {{-- Midtrans Snap JS --}}
    @push('scripts')
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}">
        </script>
        <script>
            document.getElementById('pay-button').onclick = function() {
                snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result) {
                        // setelah bayar sukses, redirect ke lesson
                        window.location.href = '/detail/{{ $transaction->course->slug }}';
                    },
                    onPending: function(result) {
                        alert('Pembayaran pending, silakan tunggu konfirmasi.');
                    },
                    onError: function(result) {
                        alert('Terjadi error, coba lagi.');
                    }
                });
            };
        </script>
    @endpush
@endsection
