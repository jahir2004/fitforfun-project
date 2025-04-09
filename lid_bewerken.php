<?php
include 'db.php';
$message = '';
 
if (!isset($_GET['id'])) {
    header("Location: leden_overzicht.php");
    exit();
}
 
$lid_id = $_GET['id'];
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Update lid information
        $stmt = $conn->prepare("UPDATE lid SET
                               mobiel = :mobiel,
                               email = :email,
                               is_actief = :is_actief
                               WHERE id = :id");
       
        $stmt->execute([
            ':mobiel' => $_POST['mobiel'],
            ':email' => $_POST['email'],
            ':is_actief' => isset($_POST['is_actief']) ? 1 : 0,
            ':id' => $lid_id
        ]);
 
        // Update gebruiker information
        $stmt = $conn->prepare("UPDATE gebruiker SET
                               voornaam = :voornaam,
                               achternaam = :achternaam
                               WHERE id = (SELECT gebruiker_id FROM lid WHERE id = :lid_id)");
       
        $stmt->execute([
            ':voornaam' => $_POST['voornaam'],
            ':achternaam' => $_POST['achternaam'],
            ':lid_id' => $lid_id
        ]);
       
        $message = "<div class='alert alert-success'>Lid succesvol bijgewerkt!</div>";
    } catch (PDOException $e) {
        $message = "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}
 
// Fetch current lid information
try {
    $stmt = $conn->prepare("
        SELECT l.*, g.voornaam, g.achternaam
        FROM lid l
        INNER JOIN gebruiker g ON l.gebruiker_id = g.id
        WHERE l.id = :id
    ");
    $stmt->execute([':id' => $lid_id]);
    $lid = $stmt->fetch(PDO::FETCH_ASSOC);
   
    if (!$lid) {
        header("Location: leden_overzicht.php");
        exit();
    }
} catch (PDOException $e) {
    $message = "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
}
?>
 
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lid Bewerken - FitForFun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Lid Bewerken</h2>
            <a href="leden_overzicht.php" class="btn btn-secondary">Terug naar overzicht</a>
        </div>
 
        <?php echo $message; ?>
       
        <div class="card">
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="voornaam" class="form-label">Voornaam</label>
                        <input type="text" class="form-control" id="voornaam" name="voornaam"
                               value="<?php echo htmlspecialchars($lid['voornaam']); ?>" required>
                    </div>
                   
                    <div class="mb-3">
                        <label for="achternaam" class="form-label">Achternaam</label>
                        <input type="text" class="form-control" id="achternaam" name="achternaam"
                               value="<?php echo htmlspecialchars($lid['achternaam']); ?>" required>
                    </div>
                   
                    <div class="mb-3">
                        <label for="relatienummer" class="form-label">Relatienummer</label>
                        <input type="text" class="form-control" id="relatienummer"
                               value="<?php echo htmlspecialchars($lid['relatienummer']); ?>" readonly>
                    </div>
                   
                    <div class="mb-3">
                        <label for="mobiel" class="form-label">Mobiel</label>
                        <input type="tel" class="form-control" id="mobiel" name="mobiel"
                               value="<?php echo htmlspecialchars($lid['mobiel']); ?>" required>
                    </div>
                   
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="<?php echo htmlspecialchars($lid['email']); ?>" required>
                    </div>
                   
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_actief" name="is_actief"
                               <?php echo $lid['is_actief'] ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="is_actief">Actief</label>
                    </div>
                   
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Wijzigingen Opslaan</button>
                        <a href="leden_overzicht.php" class="btn btn-secondary">Annuleren</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>