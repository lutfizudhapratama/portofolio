<?php
// Pastikan file ini hanya bisa diakses melalui method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Konfigurasi koneksi ke database
    $servername = "localhost"; // Ganti sesuai dengan host MySQL Anda
    $username = "username"; // Ganti dengan username MySQL Anda
    $password = "12345678"; // Ganti dengan password MySQL Anda
    $dbname = "webprofile"; // Nama database yang sudah dibuat

    // Membuat koneksi ke database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Memeriksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Menangkap dan membersihkan data dari form
    $nama = clean_input($_POST['nama']);
    $email = clean_input($_POST['email']);
    $message = clean_input($_POST['message']);

    // Membuat query menggunakan prepared statement
    $sql = "INSERT INTO kontak (nama, email, message) VALUES ('$nama', '$email', '$message')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nama, $email, $message);

    // Menjalankan query
    if ($stmt->execute()) {
        echo "Pesan berhasil dikirim!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Menutup statement dan koneksi ke database
    $stmt->close();
    $conn->close();
}

// Fungsi untuk membersihkan input
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
