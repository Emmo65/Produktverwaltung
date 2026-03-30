# 🛒 Produktverwaltung (PHP + REST API)

Dieses Projekt ist eine einfache Fullstack-Webanwendung zur Verwaltung von Produkten.
Es besteht aus einem PHP-Backend (REST API), einer MySQL-Datenbank und einem Frontend mit HTML, CSS und PHP.

---

## 🚀 Funktionen

### 🔧 Backend (REST API)

* `GET` – alle Produkte abrufen
* `GET ?id=...` – einzelnes Produkt abrufen
* `POST` – neues Produkt erstellen
* `PUT` – Produkt aktualisieren
* `DELETE` – Produkt löschen

---

### 💻 Frontend

* 📋 Produktliste in Tabellenform
* ➕ Produkt hinzufügen
* ✏️ Produkt bearbeiten
* 🗑️ Produkt löschen
* 🌙 Darkmode (umschaltbar)
* 🎨 Styling mit externer CSS-Datei

---

## 🗂️ Projektstruktur

```
Produktverwaltung/
│
├── Backend/
│   ├── api.php
│   └── db.php
│
├── index.php
├── style.css
└── README.md
```

---

## ⚙️ Voraussetzungen

* XAMPP / WAMP / MAMP oder ähnliches
* PHP 8+
* MySQL / MariaDB
* Webbrowser

---

## 🛠️ Installation

1. Projekt in den `htdocs`-Ordner kopieren
   (z. B. `C:\xampp\htdocs\Produktverwaltung`)

2. Datenbank erstellen (z. B. `produktverwaltung`)

3. Tabelle anlegen:

```sql
CREATE TABLE produkte (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    preis DECIMAL(10,2),
    beschreibung TEXT
);
```

4. Datenbankverbindung in `Backend/db.php` anpassen:

```php
$pdo = new PDO("mysql:host=localhost;dbname=produktverwaltung", "root", "");
```

5. Server starten (z. B. über XAMPP)

6. Im Browser öffnen:

```
http://localhost/Produktverwaltung/index.php
```

---

## 🔌 API-Beispiele

### GET alle Produkte

```
GET http://localhost/Produktverwaltung/Backend/api.php
```

### GET einzelnes Produkt

```
GET http://localhost/Produktverwaltung/Backend/api.php?id=1
```

### POST neues Produkt

```json
POST http://localhost/Produktverwaltung/Backend/api.php
Content-Type: application/json

{
  "name": "Maus",
  "preis": 29.99,
  "beschreibung": "Office Maus"
}
```

### PUT Produkt aktualisieren

```json
PUT http://localhost/Produktverwaltung/Backend/api.php
Content-Type: application/json

{
  "id": 1,
  "name": "Gaming Maus",
  "preis": 39.99,
  "beschreibung": "Ergonomisch"
}
```

### DELETE Produkt löschen

```
DELETE http://localhost/Produktverwaltung/Backend/api.php?id=1
```

---

## 🎨 Features im Detail

* Responsive Tabelle
* Formular für CRUD-Operationen
* Dynamisches Formular (Add / Edit)
* Darkmode mit Toggle + Speicherung im Browser
* Hover-Effekte und verbessertes UI

---

## 📚 Lernziele

Dieses Projekt zeigt:

* Arbeiten mit REST APIs in PHP
* JSON-Verarbeitung (`php://input`)
* CRUD-Operationen mit PDO
* Trennung von Backend und Frontend
* Grundlagen von CSS und UI-Design
* Einbindung von JavaScript für Interaktionen

---

## 👨‍💻 Autor

Projekt im Rahmen der Ausbildung / Umschulung zum
**Fachinformatiker für Anwendungsentwicklung**

---

## 📌 Status

✅ Funktionsfähig (CRUD vollständig)
🚧 Erweiterbar (z. B. Validierung, JavaScript, UI-Verbesserungen)

---
