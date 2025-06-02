<?php
include "file_koneksi.php"; // Sesuai persis dengan nama file

session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$sql = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
$cek = mysqli_num_rows($sql);

if ($cek == 1) {
    $data = mysqli_fetch_array($sql);
    if ($password == $data['password']) { // bisa ganti jadi password_verify jika pakai hash
        $_SESSION['username'] = $data['username'];
        $_SESSION['uid'] = $data['uid'];

        header("Location: katalog.php"); // langsung ke katalog setelah login
        exit();
    } else {
        $_SESSION['error'] = "Password salah!";
        header("Location: index.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Username tidak ditemukan!";
    header("Location: index.php");
    exit();
}
?>
