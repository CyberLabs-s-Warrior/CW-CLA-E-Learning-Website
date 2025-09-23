@extends('layouts.student')

@section('content')
    <div class="container">
        <h2>Checkout: {{ $course->title }}</h2>
        <p>Order ID: {{ $transaction->order_id }}</p>
        <p>Harga: Rp {{ number_format($transaction->gross_amount, 0, ',', '.') }}</p>
        <p>Status: <span class="badge bg-warning">{{ $transaction->status }}</span></p>

        <form action="{{ route('payment.process', $transaction->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Bayar Sekarang</button>
        </form>

    </div>
    @push('scripts')
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}">
        </script>
        <script>
            document.getElementById('pay-button').onclick = function(e) {
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
                                onSuccess: function(result) {
                                    console.log("Sukses", result);
                                },
                                onPending: function(result) {
                                    console.log("Pending", result);
                                },
                                onError: function(result) {
                                    console.log("Error", result);
                                },
                                onClose: function() {
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
