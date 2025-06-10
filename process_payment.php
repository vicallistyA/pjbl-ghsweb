<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "database_ghs";

// Buat koneksi
$conn = new mysqli($host, $user, $password, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$fullName = $_POST['fullname'] ?? '';
$email = $_POST['email'] ?? '';
$address = $_POST['address'] ?? '';
$city = $_POST['city'] ?? '';
$country = $_POST['country'] ?? '';
$postcode = $_POST['postcode'] ?? '';
$an = $_POST['an'] ?? '';
$creditNumber = $_POST['creditnumber'] ?? '';
$color = $_POST['color'] ?? '';
$message = $_POST['message'] ?? '';
$namaProduk = $_POST['product'] ?? 'Tidak diketahui';
$totalHarga = $_POST['total'] ?? '0';

// Simpan ke database
$sql = "INSERT INTO tbcheckout (
    id_user,
    nama_produk,
    total_harga,
    alamat_pemesanan,
    status_pemesanan
) VALUES (
    1, 
    '$namaProduk',
    '$totalHarga',
    '$address, $city, $country ($postcode)',
    'Diproses'
)";

if ($conn->query($sql) === TRUE) {
    header("Location: berhasil.html");
    exit();
} else {
    echo "Gagal menyimpan data: " . $conn->error;
}

$conn->close();
?>
