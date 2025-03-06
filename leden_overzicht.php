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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitForFun - Leden Overzicht</title>
    <link rel="stylesheet" href="home.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 2em auto;
            padding: 0 1em;
        }

        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .add-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .add-button:hover {
            background-color: #45a049;
            color: white;
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

        .search-container button:hover {
            background-color: #45a049;
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
<body>
<header>
        <nav>
            <div class="logo">FITFORFUN</div>
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li class="dropdown">
                        <a href="account-registratie.php" class="dropbtn">Account</a>
                            <div class="dropdown-content">
                            <a href="accountbeheer.php">Beheer</a>
                                <a href="accountoverzicht.php">Overzicht</a>
                                    <a href="login.php">login</a> 
                        </div>
                    </li>
                    <li><a href="leden_overzicht.php">Lid</a></li>
                    <li><a href="#">Les</a></li>
                    <li><a href="#">Contact</a></li>
                    <div class="menu-icon">☰</div>
                </ul>
        </nav>
    </header>
    <div class="hero">
        <div class="hero-content">
                <h2>Leden Overzicht</h2>
                <a href="lid_toevoegen.php" class="add-button">+ Nieuw Lid</a>
            
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
                            <td>
                                <a href="lid_bekijken.php?id=<?php echo $lid['id']; ?>" class="btn-view">Bekijken</a>
                                <a href="lid_bewerken.php?id=<?php echo $lid['id']; ?>" class="btn-edit">Bewerken</a>
                                <a href="javascript:void(0)" onclick="confirmDelete(<?php echo $lid['id']; ?>)" class="btn-delete">Verwijderen</a>
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
    </div>

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