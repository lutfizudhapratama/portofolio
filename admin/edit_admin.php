<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}

include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $nama_lengkap = $_POST['nama_lengkap'];

    $query = "UPDATE admin SET username=?, email=?, nama_lengkap=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $username, $email, $nama_lengkap, $id);
    if ($stmt->execute()) {
        header('Location: list_admin.php');
        exit;
    } else {
        $error = 'Gagal mengedit admin!';
    }

    $stmt->close();
    $conn->close();
} else {
    $id = $_GET['id'];
    $query = "SELECT * FROM admin WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Admin</title>
</head>
<body>
    <h2>Edit Admin</h2>
    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $admin['id']; ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $admin['username']; ?>" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $admin['email']; ?>" required><br>
        <label for="nama_lengkap">Nama Lengkap:</label>
        <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo $admin['nama_lengkap']; ?>" required><br>
        <input type="submit" value="Edit Admin">
    </form>
    <p><a href="list_admin.php">Back to Admin List</a></p>
</body>
</html>
