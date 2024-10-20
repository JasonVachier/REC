<?php
session_start(); // Démarre la session

// Déconnexion
if (isset($_GET['logout'])) {
    session_destroy(); // Détruit la session
    header("Location: index.php"); // Redirige vers la page d'accueil après déconnexion
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>REC - Renewable Energy Club</title>
</head> 
<body>

    <nav class="nav-header">
        <img class="icon" src="image/logo/logo.png">
        <a class="header-link" href="index.php">Home</a>
        <a class="header-link" href="about.html">About</a>
        <a class="header-link" href="WRE.html">Why Renewable Energy</a>
        <a class="header-link" href="articles.php">Blog</a>
        <a class="header-link" href="leadership.html">Leadership</a>
        <div style="margin-left: auto; text-align: right;">
            <?php if (isset($_SESSION['username'])): ?>
                <span>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <a href="logout.php" class="header-link" style="margin-left: 10px;">logout</a>
            <?php else: ?>
                <a href="login.html" class="header-link" style="margin-left: 10px;">login</a>
            <?php endif; ?>
        </div>
    </nav> 

    <div class="container">
        <video autoplay loop muted plays-inline class="background-clip">
            <source src="video.mp4" type="video/mp4">
        </video>

        <div class="content">
            <img class="MainPic" src="image/logo/logoBlanc.png">
            <h2>Education and career opportunities in the clean energy space for NYU students</h2>
            <a href="about.html">Join the Movement</a>
        </div>
        <?php if (isset($_SESSION['username'])): ?>
            <a href="dashboard.php" class="button-index">Go to Dashboard</a>

        <?php endif; ?>
    </div>

    <footer>
        <p class="footerindex">&copy; 2023 REC - Renewable Energy Club</p>
    </footer>

</body>
</html>
