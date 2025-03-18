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
        .cta-button, .edit-btn, .back-btn {
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
            background-color:rgb(7, 127, 255); 
        }
        .back-btn {
            background-color:rgb(251, 0, 0); 
        }
        .actions {
            display: flex;
        }
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .success {
            background-color: #d4edda;
            color:rgb(21, 85, 87);
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
            color: #333; /* Zwarte kleur voor tekst */
        }
        .button-group {
            margin-top: 20px;
            display: flex;
            gap: 10px;
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
        <div class="hero-content container">
            <h1>Lid Details</h1>
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
                    <a href="lid_bewerken.php?id=<?php echo $lid_id; ?>" class="edit-btn">Bewerken</a>
                    <a href="leden_overzicht.php" class="back-btn">Terug naar overzicht</a>
                </div>
            </div>
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