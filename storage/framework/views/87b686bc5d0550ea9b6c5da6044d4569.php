<?php $__env->startSection('content'); ?>
    <div class="container">
        <h2>Bayar: <?php echo e($transaction->course->name); ?></h2>
        <p>Order ID: <?php echo e($transaction->order_id); ?></p>
        <p>Harga: Rp <?php echo e(number_format($transaction->gross_amount, 0, ',', '.')); ?></p>

        <button id="pay-button" class="btn btn-success">Bayar Sekarang</button>
    </div>

    
    <?php $__env->startPush('scripts'); ?>
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo e(config('midtrans.clientKey')); ?>">
        </script>
        <script>
            document.getElementById('pay-button').onclick = function() {
                snap.pay('<?php echo e($snapToken); ?>', {
                    onSuccess: function(result) {
                        // setelah bayar sukses, redirect ke lesson
                        window.location.href = '/lesson/<?php echo e($transaction->course->slug); ?>';
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
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/student/checkout/payment.blade.php ENDPATH**/ ?>