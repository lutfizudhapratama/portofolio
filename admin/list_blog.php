<?php
require '../config.php';

$result = mysqli_query($conn, "SELECT * FROM blog");
?>
<!DOCTYPE html>
<html>
<head>
    <title>List of Blogs</title>
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
            width: 90%;
            max-width: 1000px;
            text-align: center;
        }
        h1 {
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
        img {
            max-width: 100px;
            height: auto;
            border-radius: 5px;
        }
        a {
            text-decoration: none;
            color: black;
            padding: 5px 10px;
            border: 1px solid #4CAF50;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        a:hover {
            background-color: #4CAF50;
            color: #fff;
        }
        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        button a {
            color: #fff;
            text-decoration: none;
        }
        .button-group {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>List of Blogs</h1>
        <table>
            <tr>
                <th>Title</th>
                <th>Content</th>
                <th>Thumbnail</th>
                <th>Actions</th>
            </tr>
            <?php
            $counter = 1;
            while($blog = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $counter ++; ?></td>
                <td><?php echo substr($blog['content'], 0, 100); ?>...</td>
                <td><img src="../uploads/<?php echo $blog['thumbnail']; ?>" alt="Thumbnail"></td>
                <td>
                    <a href="edit_blog.php?id=<?php echo $blog['id']; ?>">Edit</a>
                    <a href="del_blog.php?id=<?php echo $blog['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
        <div class="button-group">
            <button><a href="dashboard.php">Kembali ke Dashboard</a></button>
            <button onclick="window.location.href='add_blog.php';">Add Blog</button>
        </div>
    </div>
</body>
</html>
