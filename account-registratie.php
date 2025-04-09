<?php
// Verbinding maken met de database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fitforfun";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $voornaam = $_POST["voornaam"];
    $tussenvoegsel = $_POST["tussenvoegsel"];
    $achternaam = $_POST["achternaam"];
    $gebruikersnaam = $_POST["gebruikersnaam"];
    $wachtwoord = password_hash($_POST["wachtwoord"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO gebruiker (voornaam, tussenvoegsel, achternaam, gebruikersnaam, wachtwoord)
            VALUES ('$voornaam', '$tussenvoegsel', '$achternaam', '$gebruikersnaam', '$wachtwoord')";

    if ($conn->query($sql) === TRUE) {
        echo "Registratie succesvol!";
    } else {
        echo "Fout: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Registratie</title>
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
            <h1> Nieuwe Account Toevoegen</h1>
            <form method="post" action="account-registratie.php">
                <input type="text" name="voornaam" placeholder="Voornaam" required>
                <input type="text" name="tussenvoegsel" placeholder="Tussenvoegsel">
                <input type="text" name="achternaam" placeholder="Achternaam" required>
                <input type="text" name="gebruikersnaam" placeholder="Gebruikersnaam" required>
                <input type="password" name="wachtwoord" placeholder="Wachtwoord" required>
                <button type="submit">Registreer</button>
                <a href="accountbeheer.php" class="cta-button">Overzicht</a>
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