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

// Voorbeeld van het ophalen van een specifieke gebruiker
$gebruikersnaam = 'voorbeeldgebruiker'; // Dit zou dynamisch moeten zijn
$sql = "SELECT * FROM gebruiker WHERE gebruikersnaam='$gebruikersnaam'";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Overzicht</title>
    <link rel="stylesheet" href="../home.css">
</head>
<body>
    <header>
        <nav>
        <div class="logo">FITFORFUN</div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li class="dropdown">
                    <a href="account/account-registratie.php" class="dropbtn">Account</a>
                    <div class="dropdown-content">
                        <a href="account/accountbeheer.php">Beheer</a>
                        <a href="account/accountoverzicht.php">Overzicht</a>
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
            <h1>Account Overzicht</h1>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<p>ID: " . $row["id"]. "</p>";
                    echo "<p>Voornaam: " . $row["voornaam"]. "</p>";
                    echo "<p>Tussenvoegsel: " . $row["tussenvoegsel"]. "</p>";
                    echo "<p>Achternaam: " . $row["achternaam"]. "</p>";
                    echo "<p>Gebruikersnaam: " . $row["gebruikersnaam"]. "</p>";
                }
            } else {
                echo "<p>Geen resultaten</p>";
            }
            ?>
        </div>
    </section>
</body>
</html>