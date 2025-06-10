<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO tbadmin (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Admin berhasil terdaftar'); window.location.href='admin_login.html';</script>";
    } else {
        echo "Gagal mendaftar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
