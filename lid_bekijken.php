<?php
include 'db.php';
$message = '';

if (!isset($_GET['id'])) {
    header("Location: leden_overzicht.php");
    exit();
}

$lid_id = $_GET['id'];

try {
    $stmt = $conn->prepare("
        SELECT 
            l.*,
            g.voornaam,
            g.achternaam,
            g.gebruikersnaam,
            g.is_ingelogd,
            g.ingelogd,
            g.uitgelogd,
            g.datum_aangemaakt as gebruiker_aangemaakt
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
    $message = "<p class='message error'>Error: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lid Details - FitForFun</title>
    <link rel="stylesheet" href="home.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1em 0;
        }
        form button:hover {
            background-color: #555;
        
        }
        nav {
            background-color: #444;
            padding: 1em 0;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 0.5em 1em;
            margin: 0 0.5em;
        }
        .container {
            width: 90%;
            max-width: 800px;
            margin: 2em auto;
            padding: 0 1em;
        }

        .card {
            background-color: white;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 20px;
            margin-top: 20px;
        }

        .detail-row {
            display: flex;
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }

        .detail-label {
            font-weight: bold;
            width: 200px;
            color: #333;
        }

        .detail-value {
            flex-grow: 1;
        }

        .button-group {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            color: white;
        }

        .btn-edit {
            background-color: #ffc107;
        }

        .btn-back {
            background-color: #6c757d;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.9em;
            color: white;
        }

        .status-active {
            background-color: #4CAF50;
        }

        .status-inactive {
            background-color: #dc3545;
        }

        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 768px) {
            .container {
                width: 95%;
            }

            .detail-row {
                flex-direction: column;
            }

            .detail-label {
                width: 100%;
                margin-bottom: 5px;
            }

            .button-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>FitForFun</h1>
    </header>
    <nav>
        <a href="index.html">Home</a>
        <a href="account_overzicht.php">Accounten</a>
        <a href="medewerker_overzicht.php">Medewerkers</a>
        <a href="leden_overzicht.php">Leden</a>
        <a href="lessen_overzicht.php">Lessen</a>
        <a href="reservering_overzicht.php">Reserveringen</a>
        <a href="geplande_lessen.php">Geplande Lessen</a>
    </nav>
    <div class="container">
        <h2>Lid Details</h2>
        <?php echo $message; ?>

        <div class="card">
            <div class="detail-row">
                <div class="detail-label">Naam</div>
                <div class="detail-value">
                    <?php echo htmlspecialchars($lid['voornaam'] ?? '') . ' ' . htmlspecialchars($lid['achternaam'] ?? ''); ?>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Relatienummer</div>
                <div class="detail-value"><?php echo htmlspecialchars($lid['relatienummer'] ?? ''); ?></div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Mobiel</div>
                <div class="detail-value"><?php echo htmlspecialchars($lid['mobiel'] ?? ''); ?></div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Email</div>
                <div class="detail-value"><?php echo htmlspecialchars($lid['email'] ?? ''); ?></div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Status</div>
                <div class="detail-value">
                    <span class="status-badge <?php echo ($lid['is_actief'] ?? false) ? 'status-active' : 'status-inactive'; ?>">
                        <?php echo ($lid['is_actief'] ?? false) ? 'Actief' : 'Inactief'; ?>
                    </span>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Laatste Inlog</div>
                <div class="detail-value"><?php echo htmlspecialchars($lid['ingelogd'] ?? 'Nog niet ingelogd'); ?></div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Account Aangemaakt</div>
                <div class="detail-value"><?php echo htmlspecialchars($lid['gebruiker_aangemaakt'] ?? ''); ?></div>
            </div>

            <div class="button-group">
                <a href="lid_bewerken.php?id=<?php echo $lid_id; ?>" class="btn btn-edit">Bewerken</a>
                <a href="leden_overzicht.php" class="btn btn-back">Terug naar overzicht</a>
            </div>
        </div>
    </div>
</body>
</html>