<?php
include "koneksi.php";

if (isset($_POST['kirim'])) {
    $nama    = mysqli_real_escape_string($koneksi, trim($_POST['nama']));
    $alamat  = mysqli_real_escape_string($koneksi, trim($_POST['alamat']));
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $hari    = mysqli_real_escape_string($koneksi, trim($_POST['hari']));
    $weton   = mysqli_real_escape_string($koneksi, trim($_POST['weton']));

    if (empty($nama) || empty($alamat) || empty($tanggal) || empty($hari) || empty($weton)) {
        $pesan = "Semua field wajib diisi!";
    } else {

        $cek_existing = mysqli_query($koneksi,
            "SELECT id FROM khodam
             WHERE nama    = '$nama'
             AND   tanggal = '$tanggal'
             AND   hari    = '$hari'
             AND   weton   = '$weton'
             AND   alamat  = '$alamat'
             AND   (nama != '' AND nama IS NOT NULL)
             LIMIT 1"
        );

        if (mysqli_num_rows($cek_existing) > 0) {
            // User sama, tampilkan khodam yang sudah pernah didapat
            $row = mysqli_fetch_assoc($cek_existing);
            header("Location: landing.php?id=" . $row['id']);
            exit;
        }

        $cek_kosong = mysqli_query($koneksi,
            "SELECT id FROM khodam
             WHERE nama = '' OR nama IS NULL
             ORDER BY id ASC
             LIMIT 1"
        );

        if (mysqli_num_rows($cek_kosong) > 0) {
            // Ada slot kosong → pakai slot ini
            $row = mysqli_fetch_assoc($cek_kosong);
            $id  = $row['id'];
        } else {

            $cek_pertama = mysqli_query($koneksi,
                "SELECT id FROM khodam ORDER BY id ASC LIMIT 1"
            );
            $row = mysqli_fetch_assoc($cek_pertama);
            $id  = $row['id'];
        }

        $sql = "UPDATE khodam SET
                    nama    = '$nama',
                    alamat  = '$alamat',
                    tanggal = '$tanggal',
                    hari    = '$hari',
                    weton   = '$weton'
                WHERE id = $id";

        if (mysqli_query($koneksi, $sql)) {
            header("Location: landing.php?id=" . $id);
            exit;
        } else {
            $pesan = "Gagal menyimpan: " . mysqli_error($koneksi);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Khodam Kamu</title>
    <link rel="stylesheet" href="forme.css">
</head>
<body>

<div class="form-wrapper">
<a href="opsi.php" class="btn-kembali">← Kembali</a>
    <div class="form-brand">
        <div class="subtitle">✦ Dunia Gaib Nusantara ✦</div>
        <h1>Cek <span class="khodam">Khodam</span>Kamu</h1>
        <p>Setiap jiwa memiliki penjaga gaib.<br>Siapakah yang menemanimu sejak lahir?</p>
    </div>

    <div class="form-card">
        <h2>✦ Isi Data Dirimu</h2>

        <?php if (!empty($pesan)): ?>
        <div class="error-msg">⚠️ <?= htmlspecialchars($pesan) ?></div>
        <?php endif; ?>

        <form method="POST" action="form.php">

            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text"
                       id="nama"
                       name="nama"
                       placeholder="Masukkan nama lengkapmu"
                       value="<?= isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : '' ?>"
                       required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat / Kota Asal</label>
                <input type="text"
                       id="alamat"
                       name="alamat"
                       placeholder="Contoh: Surabaya, Jawa Timur"
                       value="<?= isset($_POST['alamat']) ? htmlspecialchars($_POST['alamat']) : '' ?>"
                       required>
            </div>

            <div class="form-group">
                <label for="tanggal">Tanggal Lahir</label>
                <input type="date"
                       id="tanggal"
                       name="tanggal"
                       value="<?= isset($_POST['tanggal']) ? htmlspecialchars($_POST['tanggal']) : '' ?>"
                       max="<?= date('Y-m-d') ?>"
                       required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="hari">Hari Lahir</label>
                    <select id="hari" name="hari" required>
                        <option value="">-- Pilih Hari --</option>
                        <?php
                        $hari_list = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
                        foreach ($hari_list as $h):
                            $sel = (isset($_POST['hari']) && $_POST['hari'] == $h) ? 'selected' : '';
                        ?>
                        <option value="<?= $h ?>" <?= $sel ?>><?= $h ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="weton">Weton (Pasaran)</label>
                    <select id="weton" name="weton" required>
                        <option value="">-- Pilih Weton --</option>
                        <?php
                        $pasaran = ['Kliwon','Wage','Pahing','Legi','Pon'];
                        foreach ($pasaran as $ps):
                            $sel = (isset($_POST['weton']) && $_POST['weton'] == $ps) ? 'selected' : '';
                        ?>
                        <option value="<?= $ps ?>" <?= $sel ?>><?= $ps ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <button type="submit" name="kirim" class="btn-submit">
                ✦ Mulai Pengecekan ✦
            </button>

        </form>
    </div>

    <div class="form-stats">
        <div class="stat-item">
            <div class="angka">50</div>
            <div class="keterangan">Jenis Khodam</div>
        </div>
        <div class="stat-item">
            <div class="angka gratis">Gratis</div>
            <div class="keterangan">Tanpa Bayar</div>
        </div>
        <div class="stat-item">
            <div class="angka instan">Instan</div>
            <div class="keterangan">Hasil Langsung</div>
        </div>
    </div>

    <div class="form-footer">© 2026 Cek Khodam · Niki Abduh</div>

</div>

</body>
</html>