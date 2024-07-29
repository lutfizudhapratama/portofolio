<?php
include '../config.php';

// Validasi dan pastikan bahwa id adalah integer
$id = intval($_GET['id']);

// Gunakan prepared statements untuk keamanan
$sql = "DELETE FROM blog WHERE id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id);

if (mysqli_stmt_execute($stmt)) {
    header('Location: list_blog.php');
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
