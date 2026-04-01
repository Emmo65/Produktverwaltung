<?php
session_start();
$apiUrl = "http://localhost/Produktverwaltung/Backend/api.php";

if (isset($_POST["loeschen"])) {
    $id = $_POST["id"];

    $options = [
        "http" => [
            "method" => "DELETE"
        ]
    ];

    $context = stream_context_create($options);
    file_get_contents($apiUrl . "?id=" . $id, false, $context);

    $_SESSION["message"] = "Produkt gelöscht";
    header("Location: index.php");
    exit;
}

if (isset($_POST["speichern"])) {
    $produkt = [
        "name" => $_POST["name"],
        "preis" => $_POST["preis"],
        "beschreibung" => $_POST["beschreibung"],
        "lagerbestand" => $_POST["lagerbestand"]
    ];

    $jsonDaten = json_encode($produkt);

    $options = [
        "http" => [
            "method"  => "POST",
            "header"  => "Content-Type: application/json",
            "content" => $jsonDaten
        ]
    ];

    $context = stream_context_create($options);
    file_get_contents($apiUrl, false, $context);

    $_SESSION["message"] = "Produkt gespeichert";
    header("Location: index.php");
    exit;
}

if (isset($_POST["update"])) {
    $produkt = [
        "id" => $_POST["id"],
        "name" => $_POST["name"],
        "preis" => $_POST["preis"],
        "beschreibung" => $_POST["beschreibung"],
        "lagerbestand" => $_POST["lagerbestand"]
    ];

    $jsonDaten = json_encode($produkt);

    $options = [
        "http" => [
            "method"  => "PUT",
            "header"  => "Content-Type: application/json",
            "content" => $jsonDaten
        ]
    ];

    $context = stream_context_create($options);
    file_get_contents($apiUrl, false, $context);

    $_SESSION["message"] = "Produkt aktualisiert";
    header("Location: index.php");
    exit;
}

$editProdukt = null;

if (isset($_GET["edit"])) {
    $editId = $_GET["edit"];
    $daten = file_get_contents($apiUrl . "?id=" . $editId);
    $editProdukt = json_decode($daten, true);
}

$daten = file_get_contents($apiUrl);
$produkte = json_decode($daten, true);

$suche = $_GET["suche"] ?? "";
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Produktverwaltung</title>
</head>
<body>
    <div class="container">
        <div class="topbar">
            <label class="switch">
                <input type="checkbox" id="darkmode-toggle">
                <span class="slider"></span>
            </label>
            <span>Dark Mode</span>
        </div>

        <h1>Produktübersicht</h1>

        <?php if (isset($_SESSION["message"])) { ?>
            <p class="message"><?php echo $_SESSION["message"]; ?></p>
            <?php unset($_SESSION["message"]); ?>
        <?php } ?>

        <form method="GET" class="search-form">
            <input type="text" name="suche" placeholder="Produkt suchen">
            <button type="submit">Suchen</button>
        </form>

        <table border="1">
            <tr>
                <th>Name</th>
                <th>Preis</th>
                <th>Beschreibung</th>
                <th>Bestand</th>
                <th>Aktion</th>
            </tr>

            <?php foreach ($produkte as $produkt) { ?>
                <?php
                if ($suche != "" && stripos($produkt["name"], $suche) === false) {
                    continue;
                }
                ?>
                <tr>
                    <td><?php echo $produkt["name"]; ?></td>
                    <td><?php echo $produkt["preis"]; ?></td>
                    <td><?php echo $produkt["beschreibung"]; ?></td>
                    <td>
                        <?php
                        $bestand = $produkt["lagerbestand"];
                        $klasse = "";

                        if ($bestand == 0) {
                            $klasse = "stock-empty";
                        } elseif ($bestand <= 5) {
                            $klasse = "stock-low";
                        } else {
                            $klasse = "stock-good";
                        }
                        ?>
                        <span class="<?php echo $klasse; ?>">
                            <?php echo $bestand; ?>
                        </span>
                    </td>
                    <td>
                        <form method="POST" style="display:inline;" onsubmit="return confirm('Wirklich löschen?')">
                            <input type="hidden" name="id" value="<?php echo $produkt["id"]; ?>">
                            <button type="submit" name="loeschen">Löschen</button>
                        </form>

                        <a href="?edit=<?php echo $produkt["id"]; ?>" class="edit-btn">Bearbeiten</a>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <h2><?php echo $editProdukt ? "Produkt bearbeiten" : "Produkt hinzufügen"; ?></h2>

        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $editProdukt["id"] ?? ""; ?>">

            <input type="text" name="name" placeholder="Produktname"
                value="<?php echo $editProdukt["name"] ?? ""; ?>" required>
            <br><br>

            <input type="text" name="preis" placeholder="Preis"
                value="<?php echo $editProdukt["preis"] ?? ""; ?>" required>
            <br><br>

            <input type="text" name="beschreibung" placeholder="Beschreibung"
                value="<?php echo $editProdukt["beschreibung"] ?? ""; ?>" required>
            <br><br>

            <input type="number" name="lagerbestand" placeholder="Lagerbestand"
                value="<?php echo $editProdukt["lagerbestand"] ?? ""; ?>" required>
            <br><br>

            <button type="submit" name="<?php echo $editProdukt ? "update" : "speichern"; ?>">
                <?php echo $editProdukt ? "Aktualisieren" : "Produkt speichern"; ?>
            </button>
        </form>
    </div>

    <script>
        const toggle = document.getElementById("darkmode-toggle");

        toggle.addEventListener("change", function () {
            document.body.classList.toggle("dark");
        });
    </script>
</body>
</html>