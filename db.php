<?php
include 'config.php'; // Haal databasegegevens op

try {
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 
} catch (PDOException $e) {
    die("Verbindingsfout: " . $e->getMessage());
}
?>
