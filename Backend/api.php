<?php
header("Content-Type: application/json");
require_once "db.php";

$method = $_SERVER["REQUEST_METHOD"];

if ($method == "GET") {

    if (isset($_GET["id"])) {
        $id = $_GET["id"];

        $sql = "SELECT * FROM produkte WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $produkt = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode($produkt);

    } else {
        $sql = "SELECT * FROM produkte";
        $stmt = $pdo->query($sql);
        $produkte = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($produkte);
    }


}
if ($method == "POST") {
    $datei = file_get_contents("php://input");
    $json=json_decode($datei, true);
    $name = $json["name"];
    $preis = $json["preis"];
    $beschreibung = $json["beschreibung"];
    $lagerbestand = $json["lagerbestand"];

    $sql = "INSERT INTO produkte (name, preis, beschreibung, lagerbestand) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $preis, $beschreibung, $lagerbestand]);

    echo json_encode(["message" => "Produkt wurde erstellt"]);
}
if ($method == "PUT") {
    $datei = file_get_contents("php://input");
    $json = json_decode($datei, true);

    $id = $json["id"];
    $name = $json["name"];
    $preis = $json["preis"];
    $beschreibung = $json["beschreibung"];
    $lagerbestand = $json["lagerbestand"];

    $sql = "UPDATE produkte SET name = ?, preis = ?, beschreibung = ?, lagerbestand = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $preis, $beschreibung, $lagerbestand, $id]);

    echo json_encode(["message" => "Produkt wurde aktualisiert"]);
}
if ($method == "DELETE") {
    if (!isset($_GET["id"])) {
        echo json_encode(["message" => "Produkt nicht gefunden."]);
    } else {
        $id = $_GET["id"];

        $sql = "DELETE FROM produkte WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        echo json_encode(["message" => "Produkt wurde erfolgreich gelöscht."]);
    }
}
?>