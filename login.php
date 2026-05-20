<?php
session_start();
$admin_user = "NIKIABDUH";
$admin_pass = "KHODAM2026";
$error = "";
if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    if ($user === $admin_user && $pass === $admin_pass) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin.php");
        exit;
    } else {
        $error = "Mantra salah! Kamu bukan penjaga gerbang ini.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login Admin - Portal Gaib</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <div class="login-container">
        <h1>PORTAL GAIB</h1>

        <p>Hanya penjaga yang boleh masuk</p>
        <?php if ($error): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="input-group">
                <label>Nama Wali</label>
                <input type="text" name="username" placeholder="Username..." required>
            </div>
            <div class="input-group">
                <label>Kunci Mantra</label>
                <input type="password" name="password" placeholder="Password..." required>
            </div>
            <button type="submit" name="login" class="btn-login">BUKA GERBANG</button>
        </form>
        <a href="opsi.php" class="back">Kembali ke Dunia Nyata</a>
    </div>
</body>

</html>