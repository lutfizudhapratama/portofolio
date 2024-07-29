<?php
include '../config.php';

// Validate and sanitize input
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch blog post from database
$sql = "SELECT * FROM blog WHERE id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    
    // Handle thumbnail upload
    $thumbnail = $_FILES['thumbnail']['name'];
    $target = "uploads/" . basename($thumbnail);

    if (!empty($thumbnail)) {
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], $target);
        $sql = "UPDATE blog SET title=?, content=?, thumbnail=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sssi', $title, $content, $thumbnail, $id);
    } else {
        $sql = "UPDATE blog SET title=?, content=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ssi', $title, $content, $id);
    }

    // Execute update query
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    // Redirect to blog list after update
    header('Location: list_blog.php');
    exit();
}
?>

<script src="../assets/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: 'textarea'
});
</script>

<!-- Improved HTML form -->
<form method="post" action="edit_blog.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
    Judul: <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>"><br>
    Konten: <textarea name="content"><?php echo htmlspecialchars($row['content']); ?></textarea><br>
    Thumbnail: <input type="file" name="thumbnail"><br>
    <button type="submit">Update Artikel</button>
</form>
