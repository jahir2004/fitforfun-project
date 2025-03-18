lid.zoeken
<?php
include 'db.php';

if (isset($_GET['achternaam'])) {
    $zoekterm = '%' . $_GET['achternaam'] . '%';
    
    try {
        $stmt = $conn->prepare("
            SELECT l.*, g.voornaam, g.achternaam 
            FROM lid l
            INNER JOIN gebruiker g ON l.gebruiker_id = g.id
            WHERE g.achternaam LIKE :zoekterm
        ");
        $stmt->execute([':zoekterm' => $zoekterm]);
        $leden = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $message = "<p class='message error'>Error bij zoeken: " . $e->getMessage() . "</p>";
        $leden = [];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitForFun - Zoekresultaten</title>
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

        nav a:hover {
            color: #333;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 2em auto;
            padding: 0 1em;
        }

        .search-container {
            margin: 20px 0;
        }

        .search-container input[type="text"] {
            padding: 8px;
            width: 200px;
        }

        .search-container button {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .btn-view, .btn-edit, .btn-delete {
            padding: 5px 10px;
            color: white;
            text-decoration: none;
            border-radius: 3px;
            margin-right: 5px;
        }

        .btn-view {
            background-color: #4CAF50;
        }

        .btn-edit {
            background-color: #ffc107;
        }

        .btn-delete {
            background-color: #dc3545;
        }

        .back-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 20px;
        }

        .back-button:hover {
            background-color: #45a049;
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
    </style>
</head>
<body>
    <header>
        <h1>FitForFun</h1>
    </header>
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
    <div class="container">
        <h2>Zoekresultaten</h2>
        <a href="leden_overzicht.php" class="back-button">Terug naar overzicht</a>
        
        <?php if (isset($message)) echo $message; ?>

        <div class="search-container">
            <form action="zoek_lid.php" method="get">
                <input type="text" name="achternaam" placeholder="Zoek op achternaam..." 
                       value="<?php echo isset($_GET['achternaam']) ? htmlspecialchars($_GET['achternaam']) : ''; ?>">
                <button type="submit">Zoeken</button>
            </form>
        </div>

        <table>
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Relatienummer</th>
                <th>Mobiel</th>
                <th>Email</th>
                <th>Status</th>
                <th>Acties</th>
            </tr>
            <?php
            if (isset($leden) && !empty($leden)) {
                foreach ($leden as $lid) {
                    echo "<tr>
                            <td>" . htmlspecialchars($lid['id']) . "</td>
                            <td>" . htmlspecialchars($lid['voornaam'] . ' ' . $lid['achternaam']) . "</td>
                            <td>" . htmlspecialchars($lid['relatienummer']) . "</td>
                            <td>" . htmlspecialchars($lid['mobiel']) . "</td>
                            <td>" . htmlspecialchars($lid['email']) . "</td>
                            <td>" . ($lid['is_actief'] ? 'Ja' : 'Nee') . "</td>
                            <td>
                                <a href='lid_bekijken.php?id=" . $lid['id'] . "' class='btn-view'>Bekijken</a>
                                <a href='lid_bewerken.php?id=" . $lid['id'] . "' class='btn-edit'>Bewerken</a>
                                <a href='javascript:void(0)' onclick='confirmDelete(" . $lid['id'] . ")' class='btn-delete'>Verwijderen</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Geen leden gevonden</td></tr>";
            }
            ?>
        </table>
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm('Weet u zeker dat u dit lid wilt verwijderen?')) {
                window.location.href = 'leden_overzicht.php?delete=' + id;
            }
        }
    </script>
</body>
</html>
