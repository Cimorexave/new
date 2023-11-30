<?php

require("./includes/conn.inc.php");

$fid = $_GET["fid"];

$sql_produkte = "SELECT tbl_produkte.*, tbl_lieferbarkeiten.*
FROM tbl_produkte
INNER JOIN tbl_lieferbarkeiten
ON tbl_produkte.FIDLieferbarkeit = tbl_lieferbarkeiten.IDLieferbarkeit
WHERE tbl_produkte.FIDKategorie = " . $fid . ";";

$result_produkte = $conn->query($sql_produkte) or die("Fehler in der Query: " . $conn->error);
echo "<ul>";
while ($row_produkte = mysqli_fetch_assoc($result_produkte)) {
    echo "<li>";
    echo $row_produkte["Artikelnummer"] . " " . $row_produkte["Produkt"] . " " . $row_produkte["Lieferbarkeit"];
    echo "</li>";
}
echo "<ul>";
