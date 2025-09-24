<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('client/checkout.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="checkout-wrap">
        <div class="checkout-card">

            <?php
                $status = strtolower($transaction->status ?? '');
                $statusClass = match ($status) {
                    'success', 'settlement', 'paid' => 'bg-success',
                    'pending' => 'bg-warning text-dark',
                    'expire', 'cancel', 'denied', 'failed' => 'bg-danger',
                    default => 'bg-secondary'
                };
              ?>

            <div class="checkout-head">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M3 7h18M3 7l2 12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2l2-12M7 7V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2"
                        stroke="#0f172a" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <h2 class="checkout-title">Checkout: <?php echo e($course->name); ?></h2>
            </div>

            <div class="checkout-meta">
                <div class="meta-row">
                    <span class="label">Order ID</span>
                    <span><?php echo e($transaction->order_id); ?></span>
                </div>

                <div class="meta-row">
                    <span class="label">Harga</span>
                    <span class="price">Rp <?php echo e(number_format($transaction->gross_amount, 0, ',', '.')); ?></span>
                </div>

                <div class="meta-row">
                    <span class="label">Status</span>
                    <span class="badge rounded <?php echo e($statusClass); ?>"><?php echo e(ucfirst($transaction->status)); ?></span>
                </div>
            </div>

            <div class="checkout-actions">
                <form action="<?php echo e(route('payment.process', $transaction->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn-pay">
                        
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M5 12h12M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        Bayar Sekarang
                    </button>
                </form>
                <p class="note">Dengan menekan “Bayar Sekarang”, Anda akan diarahkan ke proses pembayaran.</p>
            </div>

        </div>
    </div>
    <?php $__env->startPush('scripts'); ?>
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo e(config('midtrans.clientKey')); ?>">
        </script>
        <script>
            document.getElementById('pay-button').onclick = function (e) {
                e.preventDefault(); // cegah reload form

                fetch("<?php echo e(route('checkout')); ?>", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        course_id: "<?php echo e($course->id); ?>" // ambil dinamis dari blade
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
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/student/checkout/show.blade.php ENDPATH**/ ?>