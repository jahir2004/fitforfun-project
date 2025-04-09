<?php
session_start();

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bevestiging</title>
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
                    </div>
                </li>
                <li><a href="#">Lid</a></li>
                <li><a href="#">Les</a></li>
                <li><a href="#">Contact</a></li>
                <div class="menu-icon">☰</div>
            </ul>
        </nav>
    </header>
    <section class="hero">
        <div class="hero-content">
            <h1>Welkom, <?php echo $_SESSION['admin']; ?>!</h1>
            <p>Je bent succesvol ingelogd.</p>
            <a href="accountbeheer.php" class="cta-button">Ga naar de beheerpagina</a>
            <a href="Lesregistratie.php" class="cta-button">Ga naar Lesregistratie</a>

            <a href="logout.php" class="cta-button">Uitloggen</a>
        </div>
    </section>
</body>
</html>