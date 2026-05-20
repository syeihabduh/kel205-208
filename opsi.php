<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pilih Akses</title>
    <link rel="stylesheet" href="opsil.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Poppins:wght@300;400;600&display=swap"
        rel="stylesheet">
</head>

<body>
    
   <div class="container">
    <a href="index.php" class="btn-kembali">← Kembali</a>
    <h1 class="title">PILIH PERANMU</h1>
    <p class="subtitle">Tentukan jalan yang ingin kamu ambil</p>

    
    <div class="card-container">
        <a href="form.php" class="card user">
            <div class="icon">👤</div>
            <h2>USER</h2>
            <p>Cek khodam dan temukan penjaga gaibmu</p>
        </a>

        <a href="login.php" class="card admin">
            <div class="icon">🔮</div>
            <h2>ADMIN</h2>
            <p>Lihat seluruh data hasil pengecekan</p>
        </a>
        
    </div>

</div>
</body>

</html>