<?php

session_start();
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
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Beheren</title>
    <link rel="stylesheet" href="./home.css">
    <style>
        .cta-button, .edit-btn, .delete-btn {
            padding: 10px 20px;
            text-decoration: none;
            color: white;
            border-radius: 3px;
            margin-right: 5px; /* Voeg marge toe tussen de knoppen */
        }
        .cta-button {
            background-color: #f44336; 
        }
        .edit-btn {
            background-color: #2196F3; 
        }
        .delete-btn {
            background-color: #f44336; 
        }
        .actions {
            display: flex;
        }
    </style>
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
            <h1>Account overzicht</h1>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Voornaam</th>
                    <th>Tussenvoegsel</th>
                    <th>Achternaam</th>
                    <th>Gebruikersnaam</th>
                    <th>Acties</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["id"]. "</td><td>" . $row["voornaam"]. "</td><td>" . $row["tussenvoegsel"]. "</td><td>" . $row["achternaam"]. "</td><td>" . $row["gebruikersnaam"]. "</td>";
                        echo "<td class='actions'><a href='account-bewerken.php?id=" . $row["id"] . "' class='edit-btn'>Bewerken</a>
                                  <a href='account-verwijderen.php?id=" . $row["id"] . "' class='delete-btn' onclick='return confirm(\"Weet je zeker dat je dit account wilt verwijderen?\")'>Verwijderen</a></td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Geen resultaten</td></tr>";
                }
                $conn->close();
                ?>
            </table>
            <a href="account-registratie.php" class="cta-button">Nieuwe account toevoegen</a>
            <a href="logout.php" class="cta-button">Uitloggen</a>
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