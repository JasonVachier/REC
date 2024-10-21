<?php
session_start();
include('config.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$post_id = $_GET['id']; // Assure-toi que l'ID de l'article est bien transmis
$sql = "SELECT * FROM posts WHERE id=$post_id";
$result = $conn->query($sql);
$post = $result->fetch_assoc();

// Récupération de l'image actuelle
$current_image = isset($post['image']) ? $post['image'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Échappement des données pour éviter les erreurs SQL
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $new_image = $current_image; // On garde l'image actuelle par défaut

    // Gestion du téléchargement de la nouvelle image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = 'uploads/';
        $new_image = basename($_FILES['image']['name']);
        $upload_file = $upload_dir . $new_image;

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
            echo "Erreur lors du téléchargement de l'image.";
            exit();
        }
    }

    // Requête de mise à jour
    $sql = "UPDATE posts SET title='$title', content='$content', image='$new_image' WHERE id=$post_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Erreur : " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Edit an article</title>
    <link rel="stylesheet" href="stylephp.css">
</head>
<body>
    <h1>Edit an article</h1>
    <form action="edit_article.php?id=<?php echo $post_id; ?>" method="POST" enctype="multipart/form-data">
        <div>
            <label for="title">Title :</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
        </div>
        <div>
            <label for="content">Content :</label>
            <textarea name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea>
        </div>
        <div>
            <label for="image">Upload a new image (optional):</label>
            <input type="file" name="image" accept="image/*">
            <?php if ($current_image): ?>
                <p>Current image: <img src="uploads/<?php echo htmlspecialchars($current_image); ?>" style="max-width: 150px;"></p>
            <?php endif; ?>
        </div>
        <div>
            <button type="submit">Update the article</button>
        </div>
    </form>
</body>
</html>
