<?php
$servername = "localhost";
$username = "root";
$password = "merdeka2022";
$dbname = "webpro";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$nama = $_POST['nama'];
$email = $_POST['email'];
$message = $_POST['message'];

$sql = "INSERT INTO kontak (nama, email, message) VALUES ('$nama', '$email', '$message')";

if ($conn->query($sql) === TRUE) {
    echo "Data berhasil ditambahkan";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>