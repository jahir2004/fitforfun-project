<?php


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fitforfun";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Voorbeeld van het ophalen van gebruikersgegevens
$sql = "SELECT * FROM gebruiker";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Beheren</title>
    <link rel="stylesheet" href="./home.css">
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
            <h1>Account Beheren</h1>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Voornaam</th>
                    <th>Tussenvoegsel</th>
                    <th>Achternaam</th>
                    <th>Gebruikersnaam</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["id"]. "</td><td>" . $row["voornaam"]. "</td><td>" . $row["tussenvoegsel"]. "</td><td>" . $row["achternaam"]. "</td><td>" . $row["gebruikersnaam"]. "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Geen resultaten</td></tr>";
                }
                ?>
            </table>
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
