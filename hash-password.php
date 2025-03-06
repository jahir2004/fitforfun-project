<?php
// Databaseverbinding
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fitforfun";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Hash het wachtwoord
$new_password = 'MijnNieuwWachtwoord123'; // Vervang dit door je eigen wachtwoord
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// Voeg de gebruiker toe aan de database
$sql = "INSERT INTO gebruiker (voornaam, tussenvoegsel, achternaam, gebruikersnaam, wachtwoord)
VALUES ('Admin', NULL, 'User', 'admin', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
    // Verkrijg het ID van de nieuw toegevoegde gebruiker
    $gebruiker_id = $conn->insert_id;

    // Voeg een rol toe voor deze gebruiker
    $sql = "INSERT INTO rol (gebruiker_id, naam)
    VALUES ($gebruiker_id, 'Administrator')";

    if ($conn->query($sql) === TRUE) {
        echo "Nieuwe admin gebruiker succesvol toegevoegd.";
    } else {
        echo "Fout bij het toevoegen van de rol: " . $conn->error;
    }
} else {
    echo "Fout bij het toevoegen van de gebruiker: " . $conn->error;
}

$conn->close();
?>