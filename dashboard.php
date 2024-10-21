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
    <title>Tableau de Bord - Renewable Energy Club</title>
    <link rel="stylesheet" href="style.css"> <!-- Assurez-vous que le fichier CSS approprié est chargé -->
</head>
<body>

    <nav class="nav-header">
        <img class="icon" src="image/logo/logo.png">
        <a class="header-link" href="index.php">Home</a>
        <a class="header-link" href="about.php">About</a>
        <a class="header-link" href="WRE.html">Why Renewable Energy</a>
        <a class="header-link" href="articles.php">Articles</a>
        <a class="header-link" href="leadership.html">Leadership</a>
        <div style="margin-left: auto; text-align: right;">
            <?php if (isset($_SESSION['username'])): ?>
                <span>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <a href="logout.php" class="header-link" style="margin-left: 10px;">Déconnexion</a>
            <?php else: ?>
                <a href="login.php" class="header-link" style="margin-left: 10px;">Connexion</a>
            <?php endif; ?>
        </div>
    </nav>

    <main class="dashboardBackground"> 
        <div class="content">
            <h1>Tableau de Bord</h1>

            <?php if ($result->num_rows > 0): ?>
                <ul>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <li class="article-block">
                            <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                            <?php if (!empty($row['image'])): ?>
                                <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Image de l'article" style="max-width: 100%; height: auto;">
                            <?php endif; ?>
                            <p><?php echo htmlspecialchars($row['content']); ?></p>
                            <p><em>Publié le <?php echo $row['created_at']; ?></em></p>
                            <div class="post-actions">
                                <a href="edit_article.php?id=<?php echo $row['id']; ?>" title="Modifier">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                                <a href="delete_article.php?id=<?php echo $row['id']; ?>" title="Supprimer" onclick="return confirmDeletion();">
                                    <i class="fas fa-trash-alt"></i> Supprimer
                                </a>
                            </div>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>Aucun article trouvé.</p>
            <?php endif; ?>

            <div style="text-align: center; margin-top: 20px;">
                <a href="create_post.php">
                    <button class="create-post-button">Rédiger un nouvel article</button>
                </a>
            </div>
        </div>
    </main>

    <footer>
        <p>
            <a href="mailto:renewable-energy-club@nyu.edu">Contact us</a>
            <br>
            New York, NY, USA
        </p>
    </footer>

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
