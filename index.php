<?php
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
    header("Location: index.php");
    exit;
}

if (isset($_POST["speichern"])) {
    $produkt = [
        "name" => $_POST["name"],
        "preis" => $_POST["preis"],
        "beschreibung" => $_POST["beschreibung"]
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
    header("Location: index.php");
    exit;
}

if (isset($_POST["update"])) {
    $produkt = [
        "id" => $_POST["id"],
        "name" => $_POST["name"],
        "preis" => $_POST["preis"],
        "beschreibung" => $_POST["beschreibung"]
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
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produktverwaltung</title>
</head>
<body>
    <h1>Produktübersicht</h1>

    <table border="1">
        <tr>
            <th>Name</th>
            <th>Preis</th>
            <th>Beschreibung</th>
            <th>Aktion</th>
        </tr>

        <?php foreach ($produkte as $produkt) { ?>
            <tr>
                <td><?php echo $produkt["name"]; ?></td>
                <td><?php echo $produkt["preis"]; ?></td>
                <td><?php echo $produkt["beschreibung"]; ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $produkt["id"]; ?>">
                        <button type="submit" name="loeschen">Löschen</button>
                    </form>

                    <a href="?edit=<?php echo $produkt["id"]; ?>">Bearbeiten</a>
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

        <button type="submit" name="<?php echo $editProdukt ? "update" : "speichern"; ?>">
            <?php echo $editProdukt ? "Aktualisieren" : "Produkt speichern"; ?>
        </button>
    </form>
</body>
</html>