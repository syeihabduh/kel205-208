<?php
include "koneksi.php";

if (!$koneksi) die("Koneksi gagal: " . mysqli_connect_error());

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: form.php");
    exit;
}

$id   = (int) $_GET['id'];
$res  = mysqli_query($koneksi, "SELECT * FROM khodam WHERE id = $id");

if (mysqli_num_rows($res) == 0) {
    header("Location: form.php");
    exit;
}

$data  = mysqli_fetch_assoc($res);
$pesan = "";

if (isset($_POST['simpan'])) {
    $namakhodam = mysqli_real_escape_string($koneksi, trim($_POST['namakhodam']));
    $ketkhodam  = mysqli_real_escape_string($koneksi, trim($_POST['ketkhodam']));

    if (empty($namakhodam)) {
        $pesan = "Nama khodam wajib diisi!";
    } else {
        $foto_query = "";

        if (!empty($_FILES['fotokhodam']['name'])) {
            $ext       = pathinfo($_FILES['fotokhodam']['name'], PATHINFO_EXTENSION);
            $nama_file = "foto_" . time() . "." . $ext;
            $target    = "uploads/" . $nama_file;

            if (!is_dir("uploads")) mkdir("uploads", 0777, true);

            if (move_uploaded_file($_FILES['fotokhodam']['tmp_name'], $target)) {
                // Hapus foto lama
                if (!empty($data['fotokhodam']) && file_exists($data['fotokhodam'])) {
                    unlink($data['fotokhodam']);
                }
                $foto_query = ", fotokhodam = '$target'";
            }
        }

        $sql = "UPDATE khodam SET
                    namakhodam = '$namakhodam',
                    ketkhodam  = '$ketkhodam'
                    $foto_query
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
    <title>Edit Khodam</title>
    <link rel="stylesheet" href="edit.css">
</head>
<body>

<div class="edit-wrapper">

    <div class="brand-top">✦ Dunia Gaib Nusantara ✦</div>

    <div class="edit-card">

        <h2>✎ Edit Khodam</h2>
        <p class="edit-sub">Data milik: <span><?= htmlspecialchars($data['nama']) ?></span></p>

        <?php if (!empty($pesan)): ?>
        <div class="error-msg">⚠️ <?= htmlspecialchars($pesan) ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" action="edit.php?id=<?= $id ?>">

            <div class="form-group">
                <label for="namakhodam">Nama Khodam</label>
                <input type="text"
                       id="namakhodam"
                       name="namakhodam"
                       placeholder="Nama khodam pendamping"
                       value="<?= htmlspecialchars($data['namakhodam']) ?>"
                       required>
            </div>

            <div class="form-group">
                <label for="ketkhodam">Keterangan Khodam</label>
                <textarea id="ketkhodam"
                          name="ketkhodam"
                          placeholder="Tuliskan keterangan khodam..."><?= htmlspecialchars($data['ketkhodam']) ?></textarea>
            </div>

            <div class="form-group">
                <label>Foto Khodam</label>
                <?php if (!empty($data['fotokhodam']) && file_exists($data['fotokhodam'])): ?>
                <div class="foto-preview">
                    <img src="<?= htmlspecialchars($data['fotokhodam']) ?>" alt="Foto Khodam">
                    <small>Foto saat ini — kosongkan jika tidak ingin mengganti</small>
                </div>
                <?php endif; ?>
                <input type="file" name="fotokhodam" accept="image/*">
            </div>

            <div class="btn-group">
                <a href="landing.php?id=<?= $id ?>" class="btn btn-batal">✕ Batal</a>
                <button type="submit" name="simpan" class="btn btn-simpan">✦ Simpan</button>
            </div>

        </form>
    </div>

    <div class="edit-footer">© 2026 Cek Khodam · Niki Abduh</div>

</div>

</body>
</html>