<html>

<head></head>

<body>
    <button type="button" onclick="history.back();">back </button>
    <button type="button" onclick="history.forward();">forward</button>
</body>

</html>
<?php

// Geben Sie alle Produktkategorien in einer hierarchischen Liste aus. Bei Klick auf 
// eine Produktkategorie sollen sämtliche Informationen zu den zugehörigen Produkten
// auf einer eigenen Seite dargestellt werden (inkl. der Verfügbarkeit)

require("./includes/conn.inc.php");

$sql_hardwarekomponente = "SELECT * FROM tbl_kategorien";

$result_komponente = $conn->query($sql_hardwarekomponente) or die("Fehler in der Query " . $conn->error);
while ($row_komponente = mysqli_fetch_assoc($result_komponente)) {
    echo "<ul>";
    if ($row_komponente["FIDKategorie"] == null) {
        echo "<li>";
        echo "<a href='produkte.php?fid = " . $row_komponente["IDKategorie"] . "'>" . $row_komponente["Kategorie"] . "</a>";
        echo "<ul>";
        if ($row_komponente["IDKategorie"] != null) {
            subkategorie($row_komponente["IDKategorie"], $conn);
        }
        echo "</ul>";
        echo "</li>";
    }
    echo "</ul>";
}

function subkategorie($kat, $conn)
{
    $sql_sub = "SELECT * FROM tbl_kategorien
    WHERE tbl_kategorien.FIDKategorie = " . $kat . ";";

    $result_sub = $conn->query($sql_sub) or die("Fehler in der Query " . $conn->error);
    while ($row_sub = mysqli_fetch_assoc($result_sub)) {
        echo "<li>";
        echo "<a href='produkte.php?fid=" . $row_sub["IDKategorie"] . "'>" . $row_sub["Kategorie"] . "</a>";
        echo "</li>";
        echo "<ul>";
        if ($row_sub["IDKategorie"] != null) {
            subkategorie($row_sub["IDKategorie"], $conn);
        }
        echo "</ul>";
    }
}
