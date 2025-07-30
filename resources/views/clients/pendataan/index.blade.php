<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Data Diri</title>
    <link rel="stylesheet" href="client/userdata.css">
</head>

<body>

    <div class="form-container">
        <h2 class="form-title">Lengkapi Data Diri Anda</h2>
        <p class="form-subtitle">Isi data berikut untuk melanjutkan ke pembayaran kursus</p>

        <!-- Upload Foto Profil -->
        <div class="profile-picture-wrapper">
            <input type="file" id="profile-upload" accept="image/*" hidden>
            <label for="profile-upload" class="profile-label">
                <img src="https://www.w3schools.com/howto/img_avatar.png" alt="Foto Profil" id="profile-preview">
                <div class="overlay">
                    <span class="plus-icon">+</span>
                </div>
            </label>
        </div>

        <!-- Form Data Diri -->
        <form action="#" method="POST" class="userdata-form">
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" placeholder="Contoh: Razzan Aditya Pangestu" required>
            </div>

            <div class="form-group">
                <label for="email">Email Aktif</label>
                <input type="email" id="email" name="email" placeholder="Contoh: email@contoh.com" required>
            </div>

            <div class="form-group">
                <label for="phone">Nomor WhatsApp</label>
                <input type="tel" id="phone" name="phone" placeholder="08xxxxxxxxxx" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat Lengkap</label>
                <textarea id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat rumah..." required></textarea>
            </div>

            <div class="form-group">
                <label for="tgl_lahir">Tanggal Lahir</label>
                <input type="date" id="tgl_lahir" name="tgl_lahir" required>
            </div>

            <div class="form-group">
                <label>Jenis Kelamin</label>
                <div class="radio-group">
                    <label><input type="radio" name="gender" value="Laki-laki" required> Laki-laki</label>
                    <label><input type="radio" name="gender" value="Perempuan"> Perempuan</label>
                </div>
            </div>

            <div class="form-group center">
                <button type="submit" class="submit-btn">Simpan Data</button>
            </div>
        </form>
    </div>

    <script>
        // Preview foto profil
        const upload = document.getElementById('profile-upload');
        const preview = document.getElementById('profile-preview');

        upload.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function () {
                    preview.setAttribute('src', reader.result);
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>