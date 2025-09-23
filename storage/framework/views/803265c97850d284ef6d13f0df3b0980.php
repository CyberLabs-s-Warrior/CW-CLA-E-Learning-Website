<?php $__env->startSection('content'); ?>
    <div class="container">
        <h2>Checkout: <?php echo e($course->title); ?></h2>
        <p>Order ID: <?php echo e($transaction->order_id); ?></p>
        <p>Harga: Rp <?php echo e(number_format($transaction->gross_amount, 0, ',', '.')); ?></p>
        <p>Status: <span class="badge bg-warning"><?php echo e($transaction->status); ?></span></p>

        <form action="<?php echo e(route('payment.process', $transaction->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-success">Bayar Sekarang</button>
        </form>

    </div>
    <?php $__env->startPush('scripts'); ?>
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo e(config('midtrans.clientKey')); ?>">
        </script>
        <script>
            document.getElementById('pay-button').onclick = function(e) {
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
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/student/checkout/show.blade.php ENDPATH**/ ?>