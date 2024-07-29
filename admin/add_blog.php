<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $thumbnail = $_FILES['thumbnail']['name'];
    $target = "../uploads/" . basename($thumbnail);

    if (!file_exists('../uploads')) {
        mkdir('../uploads', 0755, true);
    }

    if (empty($title) || empty($content)) {
        echo "Title and content cannot be empty.";
        exit;
    }

    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($_FILES['thumbnail']['type'], $allowed_types)) {
        echo "Only JPEG, PNG, and GIF files are allowed.";
        exit;
    }

    if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $target)) {
        $stmt = $conn->prepare("INSERT INTO blog (title, content, thumbnail) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $content, $thumbnail);

        if ($stmt->execute()) {
            header('Location: list_blog.php');
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Failed to upload file.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Artikel</title>
    <script src="../assets/tinymce/tinymce.min.js"></script>
    <script>
    tinymce.init({
        selector: 'textarea'
    });
    </script>
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
            width: 500px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        label {
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="file"],
        textarea {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }
        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tambah Artikel</h2>
        <form method="post" action="add_blog.php" enctype="multipart/form-data">
            <label for="title">Judul:</label>
            <input type="text" id="title" name="title" required>
            <label for="content">Konten:</label>
            <textarea id="content" name="content"></textarea>
            <label for="thumbnail">Thumbnail:</label>
            <input type="file" id="thumbnail" name="thumbnail" required>
            <button type="submit">Tambah Artikel</button>
            <button type="back-link"><a href="dashboard.php">Kembali ke Dashboard</button>
        </form>
    </div>
</body>
</html>
