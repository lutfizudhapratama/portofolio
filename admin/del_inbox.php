<?php
include('../config.php');
session_start();

// Periksa apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit();
}

if (isset($_GET['id'])) {
    // Menghindari SQL Injection
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Membuat query untuk menghapus data
    $query = "DELETE FROM kontak WHERE idepesan='$id'";
    
    // Menjalankan query
    if (mysqli_query($conn, $query)) {
        // Redirect ke halaman inbox jika berhasil
        header('Location: inbox.php');
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>
