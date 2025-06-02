<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$pass = ''; // Ganti jika pakai password
$dbname = 'tubes_pemweb';

$conn = new mysqli($host, $user, $pass, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$Gmail = $_POST['Gmail'];
$username = $_POST['username'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validasi password cocok
if ($password !== $confirm_password) {
    die("Password dan konfirmasi tidak cocok.");
 }

// Cek apakah username atau email/phone sudah dipakai
$check = $conn->prepare("SELECT id FROM user WHERE username = ? OR Gmail = ?");
$check->bind_param("ss", $username, $Gmail);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo "Username atau email sudah digunakan!";
    $check->close();
    $conn->close();
    exit;
}
$check->close();

// Simpan data ke database
$stmt = $conn->prepare("INSERT INTO user (Gmail, username, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $Gmail, $username, $password);

if ($stmt->execute()) {
    header("location:index.php");
} else {
    echo "Gagal registrasi: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
