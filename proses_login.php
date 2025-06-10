<?php
// Cek session hanya jika belum ada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'config.php';

// Cek apakah form dikirim
if (!isset($_POST['username']) || !isset($_POST['password'])) {
    die("Username dan Password wajib diisi");
}

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM tblogin WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['username'] = $user['username'];

        // Login berhasil → redirect ke home
        header("Location: home1.html");
        exit;
    } else {
        echo "Password salah.";
    }
} else {
    echo "Username tidak ditemukan.";
}
?>
