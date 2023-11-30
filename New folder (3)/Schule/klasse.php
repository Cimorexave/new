<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Klassen</title>
</head>

<body>
    <ul>
        <li>
            <a href="schueler.php">Schüler</a>
        </li>
        <li>
            <a href="raeume.php">Räume</a>
        </li>
    </ul>
</body>

</html>
<?php
require("./includes/conn.inc.php");
// Geben Sie die Klasseninformationen aus: Name der Klasse, Raumnummer, 
// Klassenvorstand sowie sämtliche Schüler, welche diese Klasse besuchen.

$sql_klasse = "SELECT tbl_klassen.*, tbl_raeume.IDRaum, tbl_raeume.Bezeichnung as bz, tbl_lehrer.*
FROM tbl_klassen
INNER JOIN tbl_raeume
ON tbl_klassen.FIDRaum = tbl_raeume.IDRaum
INNER JOIN tbl_lehrer
ON tbl_klassen.FIDKV = tbl_lehrer.IDLehrer;";

$result_klasse = $conn->query($sql_klasse) or die("Fehler in der QUery: " . $conn->error);
while ($row_result = mysqli_fetch_assoc($result_klasse)) {
    echo "Klasse (" . $row_result["Bezeichnung"] . "), Raumnummer: (" . $row_result["bz"] . "), Klassenvorstand (" .  $row_result["Vorname"] . " " . $row_result["Nachname"] . "): <br>";

    $sql_students = "SELECT tbl_klassen.*, tbl_schueler.*
    FROM tbl_klassen
    INNER JOIN tbl_schueler
    ON tbl_klassen.IDKlasse = tbl_schueler.FIDKlasse
    WHERE tbl_schueler.FIDKlasse = '1a'; ";

    $result_students = $conn->query($sql_klasse) or die("Fehler in der Query: " . $conn->error);
    echo "Schüler: <br>";
    echo "<ul>";
    while ($row_students = mysqli_fetch_assoc($result_students)) {

        echo "<li>";
        echo $row_students["Vorname"] . " " . $row_students["Nachname"] .  " <br>";
        echo "</li>";
    }
    echo "</ul>";
}
