<?php
$host = "localhost";
$user = "root";        // sesuaikan username MySQL kamu
$pass = "";            // kosongkan jika tidak pakai password
$db   = "database_ghs";

$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
