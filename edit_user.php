<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM gebruiker WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$gebruiker) {
        die("Gebruiker niet gevonden.");
    }
}

if (isset($_POST['update'])) {
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $status = isset($_POST['is_actief']) ? 1 : 0;

    $sql = "UPDATE gebruiker SET voornaam = ?, achternaam = ?, gebruikersnaam = ?, is_actief = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$voornaam, $achternaam, $gebruikersnaam, $status, $id]);

    header("Location: accountbeheer.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Gebruiker Bewerken</title>
</head>
<body>
    <h2>Gebruiker Bewerken</h2>
    <form method="post">
        <label>Voornaam:</label>
        <input type="text" name="voornaam" value="<?= $gebruiker['voornaam'] ?>" required><br>

        <label>Achternaam:</label>
        <input type="text" name="achternaam" value="<?= $gebruiker['achternaam'] ?>" required><br>

        <label>Gebruikersnaam:</label>
        <input type="text" name="gebruikersnaam" value="<?= $gebruiker['gebruikersnaam'] ?>" required><br>

        <label>Actief:</label>
        <input type="checkbox" name="is_actief" <?= $gebruiker['is_actief'] ? 'checked' : '' ?>><br>

        <button type="submit" name="update">Opslaan</button>
    </form>
</body>
</html>
