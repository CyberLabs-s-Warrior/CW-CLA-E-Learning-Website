@extends('layouts.student')

@section('content')
    <div class="container">
        <h2>Bayar: {{ $transaction->course->name }}</h2>
        <p>Order ID: {{ $transaction->order_id }}</p>
        <p>Harga: Rp {{ number_format($transaction->gross_amount, 0, ',', '.') }}</p>

        <button id="pay-button" class="btn btn-success">Bayar Sekarang</button>
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
                        window.location.href = '/lesson/{{ $transaction->course->slug }}';
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
