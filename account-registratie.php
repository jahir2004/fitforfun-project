<?php
if (isset($_POST['submit'])) {

    /**
     * We halen de inloggegevens van config.php binnen
     */
    include('config/config.php');

    /**
     * Maak een dsn (datasourcename-string) om in te loggen 
     * op de mysql-server en database
     */
    $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";

    /**
     * Maak een nieuw PDO-object zodat we verbinding kunnen maken met de
     * mysql-server en database
     */
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Foutmeldingen inschakelen voor debuggen

    // SQL-query voorbereiden
    $sql = "INSERT INTO gebruiker
            (
                 voornaam
                ,tussenvoegsel
                ,achternaam
                ,gebruikersnaam
                ,wachtwoord
                ,is_ingelogd
                ,ingelogd
                ,uitgelogd
                ,is_actief
                ,opmerking
                ,datum_aangemaakt
                ,datum_gewijzigd
            )
            VALUES
            (    
                 :voornaam
                ,:tussenvoegsel
                ,:achternaam
                ,:gebruikersnaam
                ,:wachtwoord
                ,0
                ,NULL
                ,NULL
                ,1
                ,NULL
                ,CURRENT_TIMESTAMP(6)
                ,CURRENT_TIMESTAMP(6)
            )";

    // Voorbereiden van de statement
    $statement = $pdo->prepare($sql);

    // Filter de POST-gegevens om ze schoon te maken
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Binden van de waarden aan de placeholders
    $statement->bindValue(':voornaam', $_POST['voornaam'], PDO::PARAM_STR);
    $statement->bindValue(':tussenvoegsel', $_POST['tussenvoegsel'], PDO::PARAM_STR);
    $statement->bindValue(':achternaam', $_POST['achternaam'], PDO::PARAM_STR);
    $statement->bindValue(':gebruikersnaam', $_POST['gebruikersnaam'], PDO::PARAM_STR);
    $statement->bindValue(':wachtwoord', password_hash($_POST['wachtwoord'], PASSWORD_DEFAULT), PDO::PARAM_STR);

    // Statement uitvoeren
    $statement->execute();

    // Redirect na 3 seconden naar index.php
    header('refresh:3;url=index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="account.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">FITFORFUN</div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="account.php">Account</a></li>
                <li><a href="#">Lid</a></li>
                <li><a href="#">Les</a></li>
                <li><a href="#">Contact</a></li>
                <div class="menu-icon">☰</div>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Register</h2>
        <form action="confirmation.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit">aanmelden</button>
        </form>
    </div>

    <footer>
        <div class="footer-content">
            <ul>
                <li><a href="account.php">Account</a></li>
                <li><a href="#">Lid</a></li>
                <li><a href="#">Les</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
    </footer>
</body>
</html>