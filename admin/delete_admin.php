<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}

include '../config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Use prepared statements to prevent SQL injection
    $query = "DELETE FROM admin WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header('Location: list_admin.php');
        exit;
    } else {
        echo "Gagal menghapus admin!";
    }

    $stmt->close();
}

$conn->close();
?>
