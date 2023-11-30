<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Schüler</title>
</head>

<body>

    <body>
        <ul>
            <li>
                <a href="klasse.php">Klassen</a>
            </li>
            <li>
                <a href="raeume.php">Räume</a>
            </li>
        </ul>
    </body>
    <form action="schueler.php" method="post">
        <label for="vor">Vorname:</label>
        <input type="text" name="vor">
        <label for="nach">Nachname:</label>
        <input type="text" name="nach">
        <input type="submit" name="search" value="Suchen">
    </form>
</body>

</html>

<?php
// Geben Sie alle Schüler, sortiert nach Nach- und Vornamen in einer Liste aus. 
// Erstellen Sie eine Möglichkeit, nach Schülern zu suchen, und zwar nach sowohl dem 
// Nach-, als auch nach dem Vornamen (nur Nachname, nur Vorname oder beides 
// gemeinsam). Gehen Sie dabei so vor, dass nur ein Teil des Namens eingegeben 
// werden muss, sodass sie ein entsprechendes Suchergebnis erzielen: wird 
// beispielsweise im Nachnamen »ler« eingegeben, so sollen die Namen »Müller«, 
// »Obermüller«, »Lernfried«, »Kettler« usw. ausgeworfen werden

require("./includes/conn.inc.php");
$conditions = [];
if (isset($_POST["search"])) {
    $Vorname = $_POST["vor"];
    $Nachname = $_POST["nach"];

    if (!empty($Vorname)) {
        $conditions[] = " tbl_schueler.Vorname LIKE '%" . mysqli_real_escape_string($conn, $Vorname) . "%' ";
    }
    if (!empty($Nachname)) {
        $conditions[] = " tbl_schueler.Nachname LIKE '%" . mysqli_real_escape_string($conn, $Nachname) . "%' ";
    }
    $where = "";
    if (count($conditions) > 0) {
        $where = "WHERE " . implode(" AND ", $conditions);
    }
    $sql_schueler = "SELECT * FROM tbl_schueler " . $where;
    echo "<ul>";
    $result_schueler = $conn->query($sql_schueler) or die("Fehler in der Query: " . $conn->error);
    while ($row_schueler = mysqli_fetch_assoc($result_schueler)) {
        echo "<li>";
        echo $row_schueler["Vorname"] . " " . $row_schueler["Nachname"];
        echo "</li>";
    }
    echo "</ul>";
} else {
    $sql_schueler = "SELECT * FROM tbl_schueler  
    ORDER BY tbl_schueler.Vorname ASC, tbl_schueler.Nachname ASC;";
    echo "<ul>";
    $result_schueler = $conn->query($sql_schueler) or die("Fehler in der Query: " . $conn->error);
    while ($row_schueler = mysqli_fetch_assoc($result_schueler)) {
        echo "<li>";
        echo $row_schueler["Vorname"] . " " . $row_schueler["Nachname"];
        echo "</li>";
    }
    echo "</ul>";
}
