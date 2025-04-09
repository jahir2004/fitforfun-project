<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uitgelogd</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">FITFORFUN</div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li class="dropdown">
                    <a href="account-registratie.php" class="dropbtn">Account</a>
                    <div class="dropdown-content">
                        <a href="accountbeheer.php">Beheer</a>
                        <a href="accountoverzicht.php">Overzicht</a>
                        <a href="login.php">Login</a> 
                    </div>
                </li>
                <li><a href="leden_overzicht.php">Lid</a></li>
<<<<<<< HEAD
                <li><a href="lessenoverzicht/php">Les</a></li>
=======
                <li><a href="#">Les</a></li>
>>>>>>> 1005ed751cfd3e682372c1b99571a0601268b49c
                <li><a href="#">Contact</a></li>
                <div class="menu-icon">☰</div>
            </ul>
        </nav>
    </header>
    
    <section class="hero">
        <div class="hero-content">
            <h1>Je bent uitgelogd</h1>
            <p>Je sessie is beëindigd. Klik hieronder om opnieuw in te loggen.</p>
            <a href="login.php" class="cta-button">Inloggen</a>
        </div>
    </section>
    <footer>
        <div class="footer-content">
            <ul>
                <li><a href="#">Account</a></li>
                <li><a href="#">Lid</a></li>
                <li><a href="#">Les</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
    </footer>
</body>
</html>
