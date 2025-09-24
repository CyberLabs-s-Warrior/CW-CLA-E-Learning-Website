<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Kelas</title>
    
</head>

<body>

    <div class="container">
        <h1 class="title">Pembayaran Kelas</h1>

        <!-- Info Kelas -->
        <div class="info">
            <p><span class="label">Kelas:</span> Nama Kelas</p>
            <p><span class="label">Harga:</span> Rp 250.000</p>
        </div>

        <!-- Total -->
        <div class="total">
            <p>Total: Rp 250.000</p>
        </div>

        <!-- Form Dummy -->
        <form>
            <!-- Metode Pembayaran -->
            <div class="section">
                <p class="section-title">Pilih Metode Pembayaran:</p>
                <label><input type="radio" name="metode" value="bank"> Transfer Bank (BCA, BNI, Mandiri)</label><br>
                <label><input type="radio" name="metode" value="qris"> QRIS</label><br>
                <label><input type="radio" name="metode" value="ewallet"> E-Wallet (OVO, Dana, Gopay)</label>
            </div>

            <!-- Catatan -->
            <div class="section">
                <label for="catatan">Catatan (Opsional):</label><br>
                <textarea id="catatan" rows="3"></textarea>
            </div>

            <!-- Tombol -->
            <div class="buttons">
                <button type="button" class="btn-primary">Bayar Sekarang</button>
                <button type="button" class="btn-secondary">Kembali</button>
            </div>
        </form>
    </div>

</body>

</html><?php /**PATH D:\PKL\CW-CLA-E-Learning-Website\resources\views/student/payment/index.blade.php ENDPATH**/ ?>