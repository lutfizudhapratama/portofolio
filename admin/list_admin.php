<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}

include '../config.php';

$query = "SELECT * FROM admin";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: gold;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: yellow;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        a {
            text-decoration: none;
            color: #4CAF50;
            padding: 5px 10px;
            border: 1px solid #4CAF50;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        a:hover {
            background-color: #4CAF50;
            color: #fff;
        }
        .back-link {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin List</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Nama Lengkap</th>
                <th>Actions</th>
            </tr>
            <?php
            $counter = 1;
            while ($admin = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $counter++; ?></td>
                <td><?php echo $admin['username']; ?></td>
                <td><?php echo $admin['email']; ?></td>
                <td><?php echo $admin['nama_lengkap']; ?></td>
                <td>
                    <a href="edit_admin.php?id=<?php echo $admin['id']; ?>">Edit</a>
                    <a href="delete_admin.php?id=<?php echo $admin['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
        <p class="back-link"><a href="add_admin.php">Tambah Admin</a></p>
        <p class="back-link"><a href="dashboard.php">Kembali ke Dashboard</a></p>
    </div>
</body>
</html>

<?php
$result->free();
$conn->close();
?>
