<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fitforfun";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        throw new Exception("Verbinding mislukt: " . $conn->connect_error);
    }

    // ✅ Verwijderen van account via POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["id"]) && is_numeric($_POST["id"])) {
            $id = $_POST["id"];

            $stmt = $conn->prepare("DELETE FROM gebruiker WHERE id = ?");
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $stmt->close();
                    $conn->close();
                    header("Location: accountbeheer.php?status=success");
                    exit();
                } else {
                    echo "De account kan niet worden verwijderd. Controleer de selectie en probeer opnieuw.";
                }
            } else {
                throw new Exception("Fout bij verwijderen: " . $conn->error);
            }

            $stmt->close();
        } else {
            echo "de account kan niet worden verwijderd.";
        }
        $conn->close();
        exit();
    }

    // ✅ Ophalen van account via GET
    if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
        $id = $_GET["id"];

        $stmt = $conn->prepare("SELECT * FROM gebruiker WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
        } else {
            throw new Exception("Fout: Geen gebruiker gevonden met deze ID.");
        }

        $stmt->close();
    } else {
        throw new Exception("Fout: Geen geldige ID opgegeven.");
    }

    $conn->close();
} catch (Exception $e) {
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Verwijderen</title>
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
        <h1>Account Verwijderen</h1>
        <p>Weet je zeker dat je het account van <strong><?php echo htmlspecialchars($row['voornaam'] . " " . $row['achternaam']); ?></strong> wilt verwijderen?</p>
        <form method="post" action="account-verwijderen.php">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
            <input type="submit" value="Verwijderen" class="cta-button">
            <a href="accountbeheer.php" class="cta-button">Annuleren</a>
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