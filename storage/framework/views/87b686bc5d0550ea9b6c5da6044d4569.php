<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('client/payment.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
        <div class="pay-container">
        <h2 class="pay-title">Pembayaran Kursus</h2>

        <div class="pay-info">
            <p><strong>Kursus:</strong> <?php echo e($transaction->course->name); ?></p>
            <p><strong>Order ID:</strong> <?php echo e($transaction->order_id); ?></p>
            <p><strong>Harga:</strong> Rp <?php echo e(number_format($transaction->gross_amount, 0, ',', '.')); ?></p>
        </div>

        <button id="pay-button" class="pay-button">Bayar Sekarang</button>
    </div>

    
    <?php $__env->startPush('scripts'); ?>
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo e(config('midtrans.clientKey')); ?>">
        </script>
        <script>
            document.getElementById('pay-button').onclick = function() {
                snap.pay('<?php echo e($snapToken); ?>', {
                    onSuccess: function(result) {
                        // setelah bayar sukses, redirect ke lesson
                        window.location.href = '/detail/<?php echo e($transaction->course->slug); ?>';
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