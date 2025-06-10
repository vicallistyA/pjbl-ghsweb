<?php
session_start();
include 'config.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM tbadmin WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        $_SESSION['admin'] = $username;
        header("Location: database_admin.php");
        exit;
    } else {
        echo "<script>alert('Password salah'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Admin tidak ditemukan'); window.history.back();</script>";
}
?>
