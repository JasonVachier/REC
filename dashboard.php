<?php
session_start();
include('config.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
    <link rel="stylesheet" href="stylephp.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div style="text-align: right; margin: 10px;">
        <?php if (isset($_SESSION['username'])): ?>
            <span>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <a href="logout.php" style="margin-left: 10px;">Déconnexion</a>
        <?php else: ?>
            <a href="login.php">Connexion</a>
        <?php endif; ?>
    </div>
    <a class="header-link" href="articles.php">Article</a>

    <h1>Tableau de Bord</h1>

    <?php if ($result->num_rows > 0): ?>
        <ul>
            <?php while ($row = $result->fetch_assoc()): ?>
                <li>
                    <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                    <?php if (!empty($row['image'])): ?>
                        <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Image de l'article" style="max-width: 300px; height: auto;">
                    <?php endif; ?>
                    <p><?php echo htmlspecialchars($row['content']); ?></p>
                    <p><em>Publié le <?php echo $row['created_at']; ?></em></p>
                    <a href="edit_article.php?id=<?php echo $row['id']; ?>" title="Modifier">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="delete_article.php?id=<?php echo $row['id']; ?>" title="Supprimer" onclick="return confirmDeletion();">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>Aucun article trouvé.</p>
    <?php endif; ?>

    <div style="text-align: center; margin-top: 20px;">
        <a href="create_post.php" style="text-decoration: none;">
            <button style="padding: 10px 20px; font-size: 16px;">Rédiger un nouvel article</button>
        </a>
    </div>

    <script>
    function confirmDeletion() {
        return confirm("Êtes-vous sûr de vouloir supprimer cet article ?");
    }
    </script>
</body>
</html>

<?php
$conn->close();
?>