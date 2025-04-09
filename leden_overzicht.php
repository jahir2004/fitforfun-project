<?php
session_start();
include 'db.php';

$message = '';

// Delete functionality
if (isset($_POST['delete_lid'])) {
    $lid_id = $_POST['lid_id'];
    try {
        $stmt = $conn->prepare("DELETE FROM lid WHERE id = ?");
        $stmt->execute([$lid_id]);
        $message = "<p class='message success'>Lid succesvol verwijderd.</p>";
    } catch (PDOException $e) {
        $message = "<p class='message error'>Error bij verwijderen: " . $e->getMessage() . "</p>";
    }
}

// Fetch all members with user information
try {
    $stmt = $conn->prepare("
        SELECT 
            l.id,
            l.gebruiker_id,
            l.relatienummer, 
            l.mobiel,
            l.email,
            l.is_actief,
            g.voornaam,
            g.achternaam
        FROM lid l
        INNER JOIN gebruiker g ON l.gebruiker_id = g.id
        ORDER BY l.id DESC
    ");
    $stmt->execute();
    $leden = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $message = "<p class='message error'>Error bij ophalen leden: " . $e->getMessage() . "</p>";
    $leden = [];
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitForFun - Leden Overzicht</title>
    <link rel="stylesheet" href="home.css">
    <style>
        .cta-button, .edit-btn, .delete-btn {
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
            background-color: #2196F3; 
        }
        .delete-btn {
            background-color: #f44336; 
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
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-family: Arial, sans-serif;
            color: #333; /* Zwarte kleur voor tekst */
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        @media (max-width: 768px) {
            .header-actions {
                flex-direction: column;
                gap: 10px;
            }
            
            .add-button {
                width: 100%;
                text-align: center;
                justify-content: center;
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
        <div class="hero-content">
            <h1>Leden Overzicht</h1>
            <a href="lid_toevoegen.php" class="cta-button">+ Nieuw Lid</a>

            <?php echo $message; ?>

            <div class="search-container">
                <form action="zoek_lid.php" method="get">
                    <input type="text" name="achternaam" placeholder="Zoek op achternaam...">
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
                <?php if (!empty($leden)): ?>
                    <?php foreach ($leden as $lid): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($lid['id']); ?></td>
                            <td><?php echo htmlspecialchars($lid['voornaam'] . ' ' . $lid['achternaam']); ?></td>
                            <td><?php echo htmlspecialchars($lid['relatienummer']); ?></td>
                            <td><?php echo htmlspecialchars($lid['mobiel']); ?></td>
                            <td><?php echo htmlspecialchars($lid['email']); ?></td>
                            <td><?php echo ($lid['is_actief'] ? 'Ja' : 'Nee'); ?></td>
                            <td class='actions'>
                                <a href="lid_bekijken.php?id=<?php echo $lid['id']; ?>" class="edit-btn">Bekijken</a>
                                <a href="lid_bewerken.php?id=<?php echo $lid['id']; ?>" class="edit-btn">Bewerken</a>
                                <a href="javascript:void(0)" onclick="confirmDelete(<?php echo $lid['id']; ?>)" class="delete-btn">Verwijderen</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Geen leden gevonden</td>
                    </tr>
                <?php endif; ?>
            </table>
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

    <script>
        function confirmDelete(id) {
            if (confirm('Weet u zeker dat u dit lid wilt verwijderen?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'leden_overzicht.php';
                
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'lid_id';
                input.value = id;
                
                const submitButton = document.createElement('input');
                submitButton.type = 'hidden';
                submitButton.name = 'delete_lid';
                
                form.appendChild(input);
                form.appendChild(submitButton);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>
<?php
// Close the PDO connection
$conn = null;
?>