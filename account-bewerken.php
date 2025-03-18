<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fitforfun";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $voornaam = $_POST["voornaam"];
    $tussenvoegsel = $_POST["tussenvoegsel"];
    $achternaam = $_POST["achternaam"];
    $gebruikersnaam = $_POST["gebruikersnaam"];

    $sql = "UPDATE gebruiker SET voornaam='$voornaam', tussenvoegsel='$tussenvoegsel', achternaam='$achternaam', gebruikersnaam='$gebruikersnaam' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Record succesvol bijgewerkt";
    } else {
        echo "Error bij bijwerken record: " . $conn->error;
    }
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM gebruiker WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
} else {
    echo "Geen ID opgegeven.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Bewerken</title>
    <link rel="stylesheet" href="./home.css">
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
            <h1>Account Bewerken</h1>
            <form method="post" action="account-bewerken.php">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <label>Voornaam:</label>
                <input type="text" name="voornaam" value="<?php echo $row['voornaam']; ?>"><br>
                <label>Tussenvoegsel:</label>
                <input type="text" name="tussenvoegsel" value="<?php echo $row['tussenvoegsel']; ?>"><br>
                <label>Achternaam:</label>
                <input type="text" name="achternaam" value="<?php echo $row['achternaam']; ?>"><br>
                <label>Gebruikersnaam:</label>
                <input type="text" name="gebruikersnaam" value="<?php echo $row['gebruikersnaam']; ?>"><br>
                <input type="submit" value="Bijwerken" class="cta-button">
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