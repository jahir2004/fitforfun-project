<?php
session_start();
$host = 'localhost';
$dbname = 'fitforfun';
$username = 'root';
$password = '';

// Verbinding maken met de database
$conn = new mysqli($host, $username, $password, $dbname);

// Controleer verbinding
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Voeg een les toe (CREATE)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $naam = trim($_POST['naam']);
    $prijs = trim($_POST['prijs']);
    $datum = trim($_POST['datum']);
    $tijd = trim($_POST['tijd']);
    $minAantalPersonen = trim($_POST['min_aantal_personen']);
    $maxAantalPersonen = trim($_POST['max_aantal_personen']);
    $beschikbaarheid = trim($_POST['beschikbaarheid']);
    $opmerking = trim($_POST['opmerking']);

    // Controleer of de verplichte velden zijn ingevuld
    if (empty($naam) || empty($prijs) || empty($datum) || empty($tijd) || empty($minAantalPersonen) || empty($maxAantalPersonen) || empty($beschikbaarheid)) {
        $_SESSION['melding'] = '<div class="alert alert-danger">Alle verplichte velden moeten ingevuld zijn!</div>';
    } else {
        $sql = "INSERT INTO les (naam, prijs, datum, tijd, min_aantal_personen, max_aantal_personen, beschikbaarheid, opmerking)
                VALUES ('$naam', '$prijs', '$datum', '$tijd', '$minAantalPersonen', '$maxAantalPersonen', '$beschikbaarheid', '$opmerking')";

        if ($conn->query($sql) === true) {
            $_SESSION['melding'] = '<div class="alert alert-success">Nieuwe les succesvol toegevoegd!</div>';
        } else {
            $_SESSION['melding'] = '<div class="alert alert-danger">Error: ' . $conn->error . '</div>';
        }
    }
    header("Location: Lesregistratie.php");
    exit;
}

// Wijzig een les (UPDATE)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $naam = $_POST['naam'];
    $prijs = $_POST['prijs'];
    $datum = $_POST['datum'];
    $tijd = $_POST['tijd'];
    $minAantalPersonen = $_POST['min_aantal_personen'];
    $maxAantalPersonen = $_POST['max_aantal_personen'];
    $beschikbaarheid = $_POST['beschikbaarheid'];
    $opmerking = $_POST['opmerking'];

    $sql = "UPDATE les
            SET naam='$naam', prijs='$prijs', datum='$datum', tijd='$tijd', min_aantal_personen='$minAantalPersonen',
                max_aantal_personen='$maxAantalPersonen', beschikbaarheid='$beschikbaarheid', opmerking='$opmerking'
            WHERE id=$id";

    if ($conn->query($sql) === true) {
        $_SESSION['melding'] = '<div class="alert alert-success">Les succesvol bijgewerkt!</div>';
    } else {
        $_SESSION['melding'] = '<div class="alert alert-danger">Error: ' . $conn->error . '</div>';
    }
    header("Location: Lesregistratie.php");
    exit;
}

// Verwijder een les (DELETE)
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM les WHERE id=$id";

    if ($conn->query($sql) === true) {
        $_SESSION['melding'] = '<div class="alert alert-success">Les succesvol verwijderd!</div>';
    } else {
        $_SESSION['melding'] = '<div class="alert alert-danger">Error: ' . $conn->error . '</div>';
    }
    header("Location: Lesregistratie.php");
    exit;
}

// Haal alle lessen op (READ)
$sql = 'SELECT * FROM les';
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lesregistratie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="Lesregistratie.css" />
    <style>
        .error-message {
            color: red;
            font-size: 0.875em;
            margin-top: 0.25rem;
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
                    <li><a href="lessenoverzicht.php">Les</a></li>
                    <li><a href="lesregistratie.php">Lesregistratie</a></li>

                    <li><a href="#">Contact</a></li>
                    <div class="menu-icon">☰</div>
                </ul>
        </nav>
    </header>

    <div class="container mt-3 mt-md-5">
        <h1 class="text-center mb-4">Les Registratie</h1>

        <!-- Toon sessiemelding als deze bestaat -->
        <?php if (isset($_SESSION['melding'])): ?>
            <?php echo $_SESSION['melding']; ?>
            <?php unset($_SESSION['melding']); ?>
        <?php endif; ?>

        <!-- Formulier voor het toevoegen van een nieuwe les -->
        <form method="POST" action="Lesregistratie.php" id="lesForm">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="naam" class="form-label">Lesnaam:</label>
                    <input type="text" class="form-control" id="naam" name="naam">
                    <div class="error-message" id="naamError"></div>
                </div>
                <div class="col-md-6">
                    <label for="prijs" class="form-label">Prijs:</label>
                    <input type="text" class="form-control" id="prijs" name="prijs">
                    <div class="error-message" id="prijsError"></div>
                </div>
                <div class="col-md-6">
                    <label for="datum" class="form-label">Datum:</label>
                    <input type="date" class="form-control" id="datum" name="datum">
                    <div class="error-message" id="datumError"></div>
                </div>
                <div class="col-md-6">
                    <label for="tijd" class="form-label">Tijd:</label>
                    <input type="time" class="form-control" id="tijd" name="tijd">
                    <div class="error-message" id="tijdError"></div>
                </div>
                <div class="col-md-6">
                    <label for="min_aantal_personen" class="form-label">Minimaal aantal personen:</label>
                    <input type="number" class="form-control" id="min_aantal_personen" name="min_aantal_personen">
                    <div class="error-message" id="minError"></div>
                </div>
                <div class="col-md-6">
                    <label for="max_aantal_personen" class="form-label">Maximaal aantal personen:</label>
                    <input type="number" class="form-control" id="max_aantal_personen" name="max_aantal_personen">
                    <div class="error-message" id="maxError"></div>
                </div>
                <div class="col-md-6">
                    <label for="beschikbaarheid" class="form-label">Beschikbaarheid:</label>
                    <select class="form-select" id="beschikbaarheid" name="beschikbaarheid">
                        <option value="">Selecteer een optie</option>
                        <option value="Beschikbaar">Beschikbaar</option>
                        <option value="Niet Beschikbaar">Niet Beschikbaar</option>
                    </select>
                    <div class="error-message" id="beschikbaarheidError"></div>
                </div>
                <div class="col-md-6">
                    <label for="opmerking" class="form-label">Opmerking:</label>
                    <textarea class="form-control" id="opmerking" name="opmerking"></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" name="add" class="btn btn-primary">Opslaan</button>
                </div>
            </div>
        </form>

        <hr class="my-4">

        <!-- Lijst van alle lessen -->
        <h2>Alle Lessen</h2>
        <div class="table-responsive">
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Lesnaam</th>
                        <th>Prijs</th>
                        <th>Datum</th>
                        <th>Tijd</th>
                        <th>Min. Personen</th>
                        <th>Max. Personen</th>
                        <th>Beschikbaarheid</th>
                        <th>Opmerking</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td data-label="#"><?php echo $row['id']; ?></td>
                            <td data-label="Lesnaam"><?php echo $row['naam']; ?></td>
                            <td data-label="Prijs">€<?php echo $row['prijs']; ?></td>
                            <td data-label="Datum"><?php echo $row['datum']; ?></td>
                            <td data-label="Tijd"><?php echo $row['tijd']; ?></td>
                            <td data-label="Min. Personen"><?php echo $row['min_aantal_personen']; ?></td>
                            <td data-label="Max. Personen"><?php echo $row['max_aantal_personen']; ?></td>
                            <td data-label="Beschikbaarheid"><?php echo $row['beschikbaarheid']; ?></td>
                            <td data-label="Opmerking"><?php echo $row['opmerking']; ?></td>
                            <td data-label="Acties">
                                <!-- Bewerken formulier met lesgegevens -->
                                <button type="button" class="btn btn-warning btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">Bewerken</button>
                                
                                <!-- Modal voor bewerken -->
                                <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel<?php echo $row['id']; ?>">Les Bewerken</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="Lesregistratie.php">
                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                    <div class="mb-3">
                                                        <label for="naam" class="form-label">Lesnaam:</label>
                                                        <input type="text" class="form-control" id="naam" name="naam" value="<?php echo $row['naam']; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="prijs" class="form-label">Prijs:</label>
                                                        <input type="text" class="form-control" id="prijs" name="prijs" value="<?php echo $row['prijs']; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="datum" class="form-label">Datum:</label>
                                                        <input type="date" class="form-control" id="datum" name="datum" value="<?php echo $row['datum']; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="tijd" class="form-label">Tijd:</label>
                                                        <input type="time" class="form-control" id="tijd" name="tijd" value="<?php echo $row['tijd']; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="min_aantal_personen" class="form-label">Minimaal aantal personen:</label>
                                                        <input type="number" class="form-control" id="min_aantal_personen" name="min_aantal_personen" value="<?php echo $row['min_aantal_personen']; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="max_aantal_personen" class="form-label">Maximaal aantal personen:</label>
                                                        <input type="number" class="form-control" id="max_aantal_personen" name="max_aantal_personen" value="<?php echo $row['max_aantal_personen']; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="beschikbaarheid" class="form-label">Beschikbaarheid:</label>
                                                        <select class="form-select" id="beschikbaarheid" name="beschikbaarheid">
                                                            <option value="Beschikbaar" <?php echo ($row['beschikbaarheid'] == 'Beschikbaar') ? 'selected' : ''; ?>>Beschikbaar</option>
                                                            <option value="Niet Beschikbaar" <?php echo ($row['beschikbaarheid'] == 'Niet Beschikbaar') ? 'selected' : ''; ?>>Niet Beschikbaar</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="opmerking" class="form-label">Opmerking:</label>
                                                        <textarea class="form-control" id="opmerking" name="opmerking"><?php echo $row['opmerking']; ?></textarea>
                                                    </div>
                                                    <button type="submit" name="update" class="btn btn-primary">Bijwerken</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Verwijderen knop -->
                                <a href="Lesregistratie.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Weet je zeker dat je deze les wilt verwijderen?')">Verwijderen</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('lesForm').addEventListener('submit', function(event) {
            let isValid = true;
            
            // Reset error messages
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
            
            // Check fields
            const naam = document.getElementById('naam');
            if (!naam.value.trim()) {
                document.getElementById('naamError').textContent = 'Vul de lesnaam in';
                isValid = false;
            }
            
            const prijs = document.getElementById('prijs');
            if (!prijs.value.trim()) {
                document.getElementById('prijsError').textContent = 'Vul de prijs in';
                isValid = false;
            }
            
            const datum = document.getElementById('datum');
            if (!datum.value) {
                document.getElementById('datumError').textContent = 'Vul de datum in';
                isValid = false;
            }
            
            const tijd = document.getElementById('tijd');
            if (!tijd.value) {
                document.getElementById('tijdError').textContent = 'Vul de tijd in';
                isValid = false;
            }
            
            const minPersonen = document.getElementById('min_aantal_personen');
            if (!minPersonen.value) {
                document.getElementById('minError').textContent = 'Vul het minimaal aantal personen in';
                isValid = false;
            }
            
            const maxPersonen = document.getElementById('max_aantal_personen');
            if (!maxPersonen.value) {
                document.getElementById('maxError').textContent = 'Vul het maximaal aantal personen in';
                isValid = false;
            }
            
            const beschikbaarheid = document.getElementById('beschikbaarheid');
            if (!beschikbaarheid.value) {
                document.getElementById('beschikbaarheidError').textContent = 'Selecteer een beschikbaarheid';
                isValid = false;
            }
            
            if (!isValid) {
                event.preventDefault();
                alert('Vul alle vereiste velden in');
            }
        });
    </script>
</body>
</html>
<?php $conn->close(); ?>