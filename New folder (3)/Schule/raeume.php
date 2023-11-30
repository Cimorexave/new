<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Räume</title>
</head>

<body>

    <body>
        <ul>
            <li>
                <a href="schueler.php">Schüler</a>
            </li>
            <li>
                <a href="klasse.php">Klassen</a>
            </li>
        </ul>
    </body>
</body>

</html>
<?php
require("./includes/conn.inc.php");

$sql_raeume = "SELECT * FROM tbl_raeume";

$result_raeume = $conn->query($sql_raeume) or die("Fehler in der Query: " . $conn->error);
echo "<ul>";
while ($row_raeume = mysqli_fetch_assoc($result_raeume)) {
    echo "<li>";
    echo $row_raeume["Bezeichnung"] . ": ";

    $sql_klassen = "SELECT tbl_raeume.IDRaum, tbl_klassen.*
    FROM tbl_raeume
    INNER JOIN tbl_klassen
    ON tbl_raeume.IDRaum = tbl_klassen.FIDRaum
    WHERE tbl_klassen.FIDRaum = " . $row_raeume["IDRaum"] . ";";
    $result_klassen = $conn->query($sql_klassen) or die("Fehler in der Query " . $conn->error);
    echo "<ul>";
    while ($row_klassen = mysqli_fetch_assoc($result_klassen)) {
        echo "<li>";
        echo $row_klassen["Bezeichnung"];
        echo "</li>";
    }
    echo "</ul>";
    echo "</li>";
}
echo "</ul>";
