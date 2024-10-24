<?php
session_start();
include('config.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy(); 
    header("Location: articles.php", true, 303); 
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
    <script src="script.js" defer></script>
    <title>Dashboard - Renewable Energy Club</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav class="nav-header">
        <img class="icon" src="image/logo/logo.png">
        <button class="menu-toggle" aria-label="Toggle menu">
            <span class="menu-icon">☰</span> 
        </button>
        
        <div class="nav-links">
            <a class="header-link" href="index.php">Home</a>
            <a class="header-link" href="about.php">About</a> 
            <a class="header-link" href="WRE.php">Why Renewable Energy</a>
            <a class="header-link" href="articles.php">Blog</a>
            <a class="header-link" href="leadership.html">Leadership</a>
        </div>

        <div style="margin-left: auto; text-align: right;">
            <?php if (isset($_SESSION['username'])): ?>
                <span>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <a href="?logout=true" class="header-link" style="margin-left: 10px;">logout</a>
            <?php else: ?>
                <a href="login.html" class="header-link" style="margin-left: 10px;">login</a>
            <?php endif; ?>
        </div>
    </nav>

    <main class="dashboardBackground"> 
        <div class="content">
            <h1>Dashboard</h1>

            <?php if ($result->num_rows > 0): ?>
                <ul>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <li class="article-block">
                            <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                            <?php if (!empty($row['image'])): ?>
                                <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Image de l'article" style="max-width: 100%; height: auto;">
                            <?php endif; ?>
                            <div><?php echo $row['content']; ?></div>
                            <div class="date-articles"><p><em>published on <?php echo $row['created_at']; ?></em></p></div>
                            <div class="post-actions">
                                <a href="edit_article.php?id=<?php echo $row['id']; ?>" title="Modify">
                                    <i class="fas fa-edit"></i> Modify
                                </a>
                                <a href="delete_article.php?id=<?php echo $row['id']; ?>" title="Delete" onclick="return confirmDeletion();">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </a>
                            </div>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No items found</p>
            <?php endif; ?>

            <div style="text-align: center; margin-top: 20px;">
                <a href="create_post.php">Write a new article</a>
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
        return confirm("Are you sure you want to delete this article ?");
    }
    </script>
</body>
</html>

<?php
$conn->close();
?>
