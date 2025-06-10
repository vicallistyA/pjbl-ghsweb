<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Hash password agar aman
    $hashed = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO tblogin (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed);

    if ($stmt->execute()) {
        echo "<script>alert('Akun berhasil dibuat!'); window.location.href='login.html';</script>";
    } else {
        echo "Gagal registrasi: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
