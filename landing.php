<?php
include "koneksi.php";

if (!$koneksi)
    die("Koneksi gagal: " . mysqli_connect_error());

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: form.php");
    exit;
}

$id = (int) $_GET['id'];
$res = mysqli_query($koneksi, "SELECT * FROM khodam WHERE id = $id");

if (mysqli_num_rows($res) == 0) {
    header("Location: form.php");
    exit;
}

$data = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khodam Kamu — <?= htmlspecialchars($data['nama']) ?></title>
    <link rel="stylesheet" href="landing.css">
</head>

<body>
    
    <div class="landing-wrapper">

        <div class="brand-top">✦ Dunia Gaib Nusantara ✦</div>

        <div class="result-card">

            <div class="foto-glow"></div>

            <div class="foto-wrap">
                <?php if (!empty($data['fotokhodam'])): ?>
                    <img src="<?= htmlspecialchars($data['fotokhodam']) ?>" alt="Foto Khodam">
                <?php else: ?>
                    <div class="foto-placeholder">✦</div>
                <?php endif; ?>
            </div>
            <span class="info-value">Selamat <?= htmlspecialchars($data['nama']) ?></span>
            <div class="label-khodam">Khodam Pendampingmu</div>

            <h1 class="nama-khodam"><?= htmlspecialchars($data['namakhodam']) ?></h1>

            <p class="ket-khodam"><?= nl2br(htmlspecialchars($data['ketkhodam'])) ?></p>

            <div class="divider"></div>

            <div class="btn-group">
                <a href="opsi.php" class="btn btn-ulang">← Kembali</a>
                <a href="form.php" class="btn btn-ulang">✦ Cek Ulang</a>
                <a href="edit.php?id=<?= $data['id'] ?>" class="btn btn-edit">✎ Edit Khodam</a>
            </div>

        </div>

        <div class="landing-footer">© 2026 Cek Khodam · Niki Abduh</div>

    </div>

</body>

</html>