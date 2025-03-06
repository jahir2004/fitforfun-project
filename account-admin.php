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

// Functie om het wachtwoord te verifiëren
function verify_password($username, $password, $conn) {
    $sql = "SELECT wachtwoord FROM gebruiker WHERE gebruikersnaam = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($password, $hashed_password)) {
        return true;
    } else {
        return false;
    }
}

// Voeg de admin gebruiker toe aan de gebruiker tabel als deze nog niet bestaat
$admin_username = 'admin';
$admin_password = password_hash('admin_wachtwoord', PASSWORD_DEFAULT); // Versleutel het wachtwoord

$sql_check = "SELECT * FROM gebruiker WHERE gebruikersnaam = '$admin_username'";
$result = $conn->query($sql_check);

if ($result->num_rows == 0) {
    $sql = "INSERT INTO gebruiker (voornaam, tussenvoegsel, achternaam, gebruikersnaam, wachtwoord, is_ingelogd, ingelogd, uitgelogd, is_actief, opmerking)
    VALUES ('Admin', NULL, 'User', '$admin_username', '$admin_password', 0, NULL, NULL, 1, 'Administrator account')";

    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        $sql_role = "INSERT INTO rol (gebruiker_id, naam, is_actief, opmerking)
        VALUES ('$last_id', 'Administrator', 1, 'Admin rol voor beheerder')";
        if ($conn->query($sql_role) === TRUE) {
            echo "Admin account succesvol aangemaakt!";
        } else {
            echo "Fout bij het toevoegen van de rol: " . $conn->error;
        }
    } else {
        echo "Fout bij het toevoegen van de gebruiker: " . $conn->error;
    }
}

// Controleer of de POST-variabelen zijn ingesteld
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Ontvang de gegevens van het formulier
    $login_username = $_POST['username'];
    $login_password = $_POST['password'];

    if (verify_password($login_username, $login_password, $conn)) {
        echo "Wachtwoord is correct! Welkom, $login_username.";
        // Hier kun je de gebruiker doorverwijzen naar de admin dashboard pagina
        // header("Location: admin_dashboard.php");
    } else {
        echo "Wachtwoord is onjuist!";
    }
} else {
    echo "Gebruikersnaam en wachtwoord zijn vereist!";
}

$conn->close();
?>

<form method="post" action="">
    Gebruikersnaam: <input type="text" name="username" required><br>
    Wachtwoord: <input type="password" name="password" required><br>
    <input type="submit" value="Log in">
</form>