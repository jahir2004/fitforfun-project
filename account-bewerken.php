<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fitforfun";

// Create connection using try-catch for better error handling
try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Verbinding mislukt: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die($e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $voornaam = $_POST["voornaam"];
    $tussenvoegsel = $_POST["tussenvoegsel"];
    $achternaam = $_POST["achternaam"];
    $gebruikersnaam = $_POST["gebruikersnaam"];
    $wachtwoord = $_POST["wachtwoord"];

    // Server-side validation
    if (empty($voornaam) || empty($achternaam) || empty($gebruikersnaam) || empty($wachtwoord)) {
        echo "<script>alert('Voer geldige gegevens in voor voornaam, achternaam, gebruikersnaam en wachtwoord.');</script>";
    } else {
        // Hash the password before storing it
        $hashed_password = password_hash($wachtwoord, PASSWORD_DEFAULT);
        $sql = "UPDATE gebruiker SET voornaam='$voornaam', tussenvoegsel='$tussenvoegsel', achternaam='$achternaam', gebruikersnaam='$gebruikersnaam', wachtwoord='$hashed_password' WHERE id=$id";

        try {
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Gegevens succesvol opgeslagen'); window.location.href='accountbeheer.php';</script>";
                exit();
            } else {
                throw new Exception("Error bij bijwerken record: " . $conn->error);
            }
        } catch (Exception $e) {
            echo "<script>alert('" . $e->getMessage() . "');</script>";
        }
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
    <script>
        // Client-side validation
        function validateForm() {
            var voornaam = document.forms["accountForm"]["voornaam"].value;
            var achternaam = document.forms["accountForm"]["achternaam"].value;
            var gebruikersnaam = document.forms["accountForm"]["gebruikersnaam"].value;
            var wachtwoord = document.forms["accountForm"]["wachtwoord"].value;
            if (voornaam == "" || achternaam == "" || gebruikersnaam == "" || wachtwoord == "") {
                alert("Voer geldige gegevens in voor voornaam, achternaam, gebruikersnaam en wachtwoord.");
                return false;
            }
            return true;
        }
    </script>
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
        <form name="accountForm" method="post" action="account-bewerken.php" onsubmit="return validateForm()">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <label>Voornaam:</label>
            <input type="text" name="voornaam" value="<?php echo $row['voornaam']; ?>"><br>
            <label>Tussenvoegsel:</label>
            <input type="text" name="tussenvoegsel" value="<?php echo $row['tussenvoegsel']; ?>"><br>
            <label>Achternaam:</label>
            <input type="text" name="achternaam" value="<?php echo $row['achternaam']; ?>"><br>
            <label>Gebruikersnaam:</label>
            <input type="text" name="gebruikersnaam" value="<?php echo $row['gebruikersnaam']; ?>"><br>
            <label>Wachtwoord:</label>
            <input type="password" name="wachtwoord"><br>
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