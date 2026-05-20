<?php
include 'koneksi.php';

if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    $cek = mysqli_query($koneksi, "SELECT fotokhodam FROM khodam WHERE id = $id");
    $row = mysqli_fetch_assoc($cek);
    if ($row && !empty($row['fotokhodam']) && file_exists($row['fotokhodam'])) {
        unlink($row['fotokhodam']);
    }
    if (mysqli_query($koneksi, "DELETE FROM khodam WHERE id = $id")) {
        $pesan = "<div class='alert sukses'>✅ Data berhasil dihapus.</div>";
    } else {
        $pesan = "<div class='alert gagal'>❌ Gagal menghapus data.</div>";
    }
}

if (isset($_POST['simpan_edit'])) {
    $id = (int) $_POST['id'];
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $hari = mysqli_real_escape_string($koneksi, $_POST['hari']);
    $weton = mysqli_real_escape_string($koneksi, $_POST['weton']);
    $namakhodam = mysqli_real_escape_string($koneksi, $_POST['namakhodam']);
    $ketkhodam = mysqli_real_escape_string($koneksi, $_POST['ketkhodam']);

    $foto_query = "";
    if (!empty($_FILES['fotokhodam']['name'])) {
        $ext = pathinfo($_FILES['fotokhodam']['name'], PATHINFO_EXTENSION);
        $nama_file = "foto_" . time() . "." . $ext;
        $target = "uploads/" . $nama_file;
        if (!is_dir("uploads"))
            mkdir("uploads", 0777, true);
        if (move_uploaded_file($_FILES['fotokhodam']['tmp_name'], $target)) {
            $cek_lama = mysqli_query($koneksi, "SELECT fotokhodam FROM khodam WHERE id = $id");
            $lama = mysqli_fetch_assoc($cek_lama);
            if ($lama && !empty($lama['fotokhodam']) && file_exists($lama['fotokhodam'])) {
                unlink($lama['fotokhodam']);
            }
            $foto_query = ", fotokhodam = '$target'";
        }
    }

    $sql = "UPDATE khodam SET
                nama       = '$nama',
                alamat     = '$alamat',
                tanggal    = '$tanggal',
                hari       = '$hari',
                weton      = '$weton',
                namakhodam = '$namakhodam',
                ketkhodam  = '$ketkhodam'
                $foto_query
            WHERE id = $id";

    if (mysqli_query($koneksi, $sql)) {
        $pesan = "<div class='alert sukses'>✅ Data berhasil diperbarui.</div>";
    } else {
        $pesan = "<div class='alert gagal'>❌ Gagal update: " . mysqli_error($koneksi) . "</div>";
    }
}

$data_edit = null;
if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];
    $res = mysqli_query($koneksi, "SELECT * FROM khodam WHERE id = $id");
    $data_edit = mysqli_fetch_assoc($res);
}

$hasil = mysqli_query($koneksi, "SELECT * FROM khodam ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Data Khodam</title>
    <link rel="stylesheet" href="admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@" rel="stylesheet">
</head>

<body>

    <h1>⚙️ Admin Panel — Data Khodam</h1>
    
    <a href="opsi.php" class="btn-kembali">← Kembali</a>
    <div class="container">

        <?php if ($data_edit): ?>
            <div class="form-edit">
                <h2>✏️ Edit Data Khodam — ID #<?= $data_edit['id'] ?></h2>
                <form method="POST" enctype="multipart/form-data" action="admin.php">
                    <input type="hidden" name="id" value="<?= $data_edit['id'] ?>">
                    <div class="form-grid">

                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($data_edit['nama']) ?>"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" id="alamat" name="alamat"
                                value="<?= htmlspecialchars($data_edit['alamat']) ?>">
                        </div>

                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" id="tanggal" name="tanggal" value="<?= $data_edit['tanggal'] ?>">
                        </div>

                        <div class="form-group">
                            <label for="hari">Hari</label>
                            <select id="hari" name="hari">
                                <?php
                                foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $h):
                                    ?>
                                    <option value="<?= $h ?>" <?= $data_edit['hari'] == $h ? 'selected' : '' ?>>
                                        <?= $h ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="weton">Weton</label>
                            <input type="text" id="weton" name="weton" value="<?= htmlspecialchars($data_edit['weton']) ?>">
                        </div>

                        <div class="form-group">
                            <label for="namakhodam">Nama Khodam</label>
                            <input type="text" id="namakhodam" name="namakhodam"
                                value="<?= htmlspecialchars($data_edit['namakhodam']) ?>" required>
                        </div>

                        <div class="form-group full">
                            <label for="ketkhodam">Keterangan Khodam</label>
                            <textarea id="ketkhodam"
                                name="ketkhodam"><?= htmlspecialchars($data_edit['ketkhodam']) ?></textarea>
                        </div>

                        <div class="form-group full">
                            <label>Foto Khodam</label>
                            <?php if (!empty($data_edit['fotokhodam'])): ?>
                                <div class="foto-preview">
                                    <img src="<?= htmlspecialchars($data_edit['fotokhodam']) ?>" alt="Foto">
                                    <small>Foto saat ini — kosongkan input di bawah jika tidak ingin ganti</small>
                                </div>
                            <?php endif; ?>
                            <input type="file" name="fotokhodam" accept="image/*">
                        </div>

                    </div>

                    <div class="form-actions">
                        <button type="submit" name="simpan_edit" class="btn-simpan">💾 Simpan Perubahan</button>
                        <a href="admin.php" class="btn-batal">✖ Batal</a>
                    </div>
                </form>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">📋 Daftar Data Khodam</div>
            <div class="overflow-x">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Tanggal</th>
                            <th>Hari</th>
                            <th>Weton</th>
                            <th>Nama Khodam</th>
                            <th>Foto</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($hasil) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($hasil)): ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= htmlspecialchars($row['nama']) ?></td>
                                    <td><?= htmlspecialchars($row['alamat']) ?></td>
                                    <td><?= $row['tanggal'] ?></td>
                                    <td><?= htmlspecialchars($row['hari']) ?></td>
                                    <td><?= htmlspecialchars($row['weton']) ?></td>
                                    <td><?= htmlspecialchars($row['namakhodam']) ?></td>
                                    <td>
                                        <?php if (!empty($row['fotokhodam'])): ?>
                                            <img class="foto-kecil" src="<?= htmlspecialchars($row['fotokhodam']) ?>" alt="foto">
                                        <?php else: ?>
                                            <span style="color:#aaa;font-size:11px;">Tidak ada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars(mb_strimwidth($row['ketkhodam'], 0, 40, '...')) ?></td>
                                    <td style="white-space:nowrap;">
                                        <a href="admin.php?edit=<?= $row['id'] ?>" class="btn btn-edit">✏️ Edit</a>
                                        <a href="admin.php?hapus=<?= $row['id'] ?>" class="btn btn-hapus"
                                            onclick="return confirm('Yakin hapus data ID <?= $row['id'] ?>?')">🗑️ Hapus</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" style="text-align:center;padding:20px;color:#aaa;">
                                    Belum ada data khodam.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    </body>
</html>