<?php
include 'config.php'; // Pastikan file ini berisi koneksi $conn ke database_ghs

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validasi dasar (boleh ditambah)
    if (empty($username) || empty($email) || empty($password)) {
        echo "<script>alert('Semua field harus diisi.'); window.location.href='register_.html';</script>";
        exit;
    }

    // Enkripsi password
    $hashed = password_hash($password, PASSWORD_BCRYPT);

    // Insert ke database
    $stmt = $conn->prepare("INSERT INTO tblogin (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed);

    if ($stmt->execute()) {
        echo "<script>
                alert('Akun berhasil dibuat. Silakan login!');
                window.location.href='login_.html';
              </script>";
        exit;
    } else {
        echo "<script>alert('Gagal registrasi: " . $conn->error . "'); window.location.href='register_.html';</script>";
        exit;
    }

    $stmt->close();
}
$conn->close();
?>
