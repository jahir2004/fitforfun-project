<?php
// Verbind met de database
$host = 'localhost';
$dbname = 'fitforfun';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Haal de lessen op uit de database met filters
$search = isset($_GET['filter']) ? $_GET['filter'] : '';
$priceFilter = isset($_GET['priceFilter']) ? $_GET['priceFilter'] : '';
$dateFilter = isset($_GET['dateFilter']) ? $_GET['dateFilter'] : '';

$query = "SELECT * FROM les WHERE 1=1";
$params = [];

if ($search) {
    $query .= " AND naam LIKE :search";
    $params[':search'] = "%$search%";
}

if ($priceFilter) {
    $query .= " AND prijs = :price";
    $params[':price'] = $priceFilter;
}

if ($dateFilter) {
    $query .= " AND datum = :date";
    $params[':date'] = $dateFilter;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$lessen = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Unieke datums ophalen voor de datumfilter
$dateStmt = $pdo->query("SELECT DISTINCT datum FROM les ORDER BY datum");
$dates = $dateStmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lessenoverzicht</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/Fitforfun/Lessenoverzicht/Lessenoverzicht.css" />
      
</head>
<body>

<header>
        <nav>
            <div class="logo">FITFORFUN</div>
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="login.php">Account</a></li>
                    <li><a href="leden_overzicht.php">Lid</a></li>
                    <li><a href="lessenoverzicht.php">Les</a></li>

                    <li><a href="#">Contact</a></li>
                    <div class="menu-icon">☰</div>
                </ul>
        </nav>
    </header>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Lessenoverzicht</h2>


        <!-- Filterformulier -->
        <div class="mb-4">
            <form method="get" action="" class="row g-3">
                <div class="col-12 col-sm-6 col-md-4">
                    <input type="text" id="filter" name="filter" class="form-control" placeholder="Zoek een sportles..." value="<?= htmlspecialchars($search) ?>">
                </div>
                <div class="col-6 col-md-3">
                    <select id="priceFilter" name="priceFilter" class="form-select">
                        <option value="">Prijs</option>
                        <?php for ($i = 30; $i <= 60; $i += 5): ?>
                            <option value="<?= $i ?>" <?= $priceFilter == $i ? 'selected' : '' ?>>
                                &euro;<?= $i ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <select id="dateFilter" name="dateFilter" class="form-select">
                        <option value="">Lesdatum</option>
                        <?php foreach ($dates as $date): ?>
                            <option value="<?= htmlspecialchars($date) ?>" <?= $dateFilter == $date ? 'selected' : '' ?>>
                                <?= htmlspecialchars($date) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
                <div class="col-6 col-md-2">
                    <a href="?" class="btn btn-secondary w-100">Reset</a>
                </div>
            </form>
        </div>

        <!-- Overzicht van alle lessen -->
        <div id="lessonList" class="row">
            <?php if (empty($lessen)): ?>
                <p id="noResults" class="text-danger text-center mt-3">Er zijn geen lessen beschikbaar binnen deze prijsklasse.</p>
            <?php else: ?>
                <?php foreach ($lessen as $les): ?>
                    <div class="col-12 col-sm-6 col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"> <?= htmlspecialchars($les['naam']) ?> </h5>
                                <p class="text-muted">Prijs: &euro;<?= htmlspecialchars($les['prijs']) ?></p>
                                <p>Datum: <?= htmlspecialchars($les['datum']) ?></p>
                                <p>Tijd: <?= htmlspecialchars($les['tijd']) ?></p>
                                <p>Min: <?= htmlspecialchars($les['min_aantal_personen']) ?> | Max: <?= htmlspecialchars($les['max_aantal_personen']) ?></p>
                                <p class="fw-bold">Beschikbaarheid: <?= htmlspecialchars($les['beschikbaarheid']) ?></p>
                                <p class="text-secondary"> <?= htmlspecialchars($les['opmerking']) ?> </p>
                            </div>
                            <div class="card-footer bg-light text-center">
                                <a href="#" class="btn btn-success w-100">Reserveer Nu</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
