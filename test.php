<?php
session_start();
require 'config.php'; // Databaseverbinding

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Selecteer alle gebruikers
$stmt = $pdo->query("SELECT * FROM gebruiker");
$gebruikers = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FitForFun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Gebruikersoverzicht</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Voornaam</th>
                    <th>Achternaam</th>
                    <th>Gebruikersnaam</th>
                    <th>Status</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($gebruikers as $gebruiker): ?>
                    <tr>
                        <td><?= htmlspecialchars($gebruiker['id']) ?></td>
                        <td><?= htmlspecialchars($gebruiker['voornaam']) ?></td>
                        <td><?= htmlspecialchars($gebruiker['achternaam']) ?></td>
                        <td><?= htmlspecialchars($gebruiker['gebruikersnaam']) ?></td>
                        <td><?= $gebruiker['is_actief'] ? 'Actief' : 'Inactief' ?></td>
                        <td>
                            <a href="bewerk_gebruiker.php?id=<?= $gebruiker['id'] ?>" class="btn btn-warning btn-sm">Bewerken</a>
                            <a href="verwijder_gebruiker.php?id=<?= $gebruiker['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?');">Verwijderen</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
