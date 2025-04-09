<?php
include 'db.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // First, create the gebruiker
        $stmt = $conn->prepare("INSERT INTO gebruiker (voornaam, achternaam, gebruikersnaam, wachtwoord) 
                               VALUES (:voornaam, :achternaam, :gebruikersnaam, :wachtwoord)");
        
        $wachtwoord_hash = password_hash($_POST['wachtwoord'], PASSWORD_DEFAULT);
        
        $stmt->execute([
            ':voornaam' => $_POST['voornaam'],
            ':achternaam' => $_POST['achternaam'],
            ':gebruikersnaam' => $_POST['email'], // Using email as username
            ':wachtwoord' => $wachtwoord_hash
        ]);
        
        $gebruiker_id = $conn->lastInsertId();
        
        // Then, create the lid
        $stmt = $conn->prepare("INSERT INTO lid (gebruiker_id, relatienummer, mobiel, email) 
                               VALUES (:gebruiker_id, :relatienummer, :mobiel, :email)");
        
        $stmt->execute([
            ':gebruiker_id' => $gebruiker_id,
            ':relatienummer' => $_POST['relatienummer'],
            ':mobiel' => $_POST['mobiel'],
            ':email' => $_POST['email']
        ]);
        
        header("Location: leden_overzicht.php");
        exit();
    } catch (PDOException $e) {
        $message = "<p class='message error'>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuw Lid Toevoegen - FitForFun</title>
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
            background-color: #ffc107; 
        }
        .back-btn {
            background-color: #6c757d; 
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
        .container {
            width: 90%;
            max-width: 800px;
            margin: 2em auto;
            padding: 0 1em;
        }
        .form-card {
            background-color: white;
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 1em;
        }
        label {
            display: block;
            margin-bottom: 0.5em;
            color: #333;
        }
        input[type="text"],
        input[type="number"],
        input[type="tel"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
            color: #333; /* Zwarte kleur voor tekst */
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            color: white;
        }
        .btn-primary {
            background-color: #4CAF50;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .btn:hover {
            opacity: 0.9;
        }
        @media (max-width: 768px) {
            .container {
                width: 95%;
            }
            .button-group {
                flex-direction: column;
                gap: 10px;
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
    <section class="hero">
        <div class="hero-content container">
            <h1>Nieuw Lid Toevoegen</h1>
            <?php echo $message; ?>
            <div class="form-card">
                <form method="post" action="lid_toevoegen.php">
                    <div class="form-group">
                        <label for="voornaam">Voornaam</label>
                        <input type="text" id="voornaam" name="voornaam" required>
                    </div>
                    <div class="form-group">
                        <label for="achternaam">Achternaam</label>
                        <input type="text" id="achternaam" name="achternaam" required>
                    </div>
                    <div class="form-group">
                        <label for="relatienummer">Relatienummer</label>
                        <input type="number" id="relatienummer" name="relatienummer" required>
                    </div>
                    <div class="form-group">
                        <label for="mobiel">Mobiel</label>
                        <input type="tel" id="mobiel" name="mobiel" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="wachtwoord">Wachtwoord</label>
                        <input type="password" id="wachtwoord" name="wachtwoord" required>
                    </div>
                    <div class="button-group">
                        <button type="submit" class="btn btn-primary">Toevoegen</button>
                        <a href="leden_overzicht.php" class="btn btn-secondary">Annuleren</a>
                    </div>
                </form>
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