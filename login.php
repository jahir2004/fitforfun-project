<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fitforfun";

// Maak verbinding met de database
$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Verwerk het login formulier
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_username = $_POST['username'];
    $admin_password = $_POST['password'];

    // Zoek de gebruiker in de database
    $sql = "SELECT * FROM gebruiker WHERE gebruikersnaam='$admin_username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($admin_password, $row['wachtwoord'])) {
            // Sla gebruikersinformatie op in de sessie
            $_SESSION['admin'] = $row['gebruikersnaam'];
            header("Location: confirmation.php");
        } else {
            echo "Ongeldig wachtwoord.";
        }
    } else {
        echo "Geen gebruiker gevonden met deze gebruikersnaam.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
<header>
        <nav>
            <div class="logo">FITFORFUN</div>
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="login.php">Account</a></li>
                    <li><a href="leden_overzicht.php">Lid</a></li>
                    <li><a href="#">Les</a></li>
                    <li><a href="#">Contact</a></li>
                    <div class="menu-icon">☰</div>
                </ul>
        </nav>
    </header>
    <section class="hero">
        <div class="hero-content">
            <h1>Admin Login</h1>
            <form action="login.php" method="post">
                <label for="username">Gebruikersnaam:</label>
                <input type="text" id="username" name="username" required><br><br>
                <label for="password">Wachtwoord:</label>
                <input type="password" id="password" name="password" required><br><br>
                <button type="cta-button">Login</button>
            </form>
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
