<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Pcs</title>
</head>

<body>
    <form action="pcs.php" method="post">
        <label for="k">Produktbezeichnung</label>
        <input type="text" name="k">
        <label for="a">Artikelnummer</label>
        <input type="text" name="a">
        <input type="submit" name="search" value="Suchen">
    </form>
</body>

</html>

<?php

// Geben Sie alle individuell zusammengestellten PCs samt der Komponenten 
// (sämtliche Informationen zu den Komponenten wie in der ersten Auswertung) und 
// dem Gesamtpreis (Summe aller Komponenten-Preisee) aus. 

// Hierbei soll es möglich 
// sein, dass nach Komponenten gesucht wird (nach (Teilen) der Produktbezeichnung 
// oder (Teilen) der Artikelnummer), wobei alsdann nur diejenigen individuell 
// zusammengestellten PCs dargestellt werden sollen, in welchen diese Komponente 
// vorkommt

require("./includes/conn.inc.php");

$searchConditions = [];
if (isset($_POST["search"])) {
    if (!empty($_POST["k"])) {
        $productName = $_POST["k"];
        $searchConditions[] = "tbl_produkte.Produkt LIKE '%$productName%'";
    }
    if (!empty($_POST["a"])) {
        $articleNumber = $_POST["a"];
        $searchConditions[] = "tbl_produkte.Artikelnummer LIKE '%$articleNumber%'";
    }

    if (!empty($searchConditions)) {
        $where = implode("AND ", $searchConditions);
    }

    $sql_pro = "SELECT * FROM tbl_produkte WHERE " . $where;
    $result_pro = $conn->query($sql_pro) or die("Fehler in der Query " . $conn->error);

    while ($row_pro = mysqli_fetch_assoc($result_pro)) {
        $id = $row_pro["IDProdukt"];

        $sql_id = "SELECT * FROM tbl_konfigurator
        WHERE tbl_konfigurator.FIDKomponente = " . $id . ";";

        $result_id = $conn->query($sql_id) or die("Fehler in der Query " . $conn->error);
        while ($row_pcs = mysqli_fetch_assoc($result_id)) {
            $fid = $row_pcs["FIDPC"];

            $sql_pcs = "SELECT * FROM tbl_produkte
            WHERE tbl_produkte.IDProdukt =" . $fid . ";";
            echo "<ul>";
            $result_pcs = $conn->query($sql_pcs) or die("Fehler in der Query " . $conn->error);
            while ($row_pcs = mysqli_fetch_assoc($result_pcs)) {
                echo "<li>";
                echo $row_pcs["Produkt"];
                echo "</li>";
                if ($row_pcs["IDProdukt"] != null) {
                    $sql_kom = "SELECT tbl_konfigurator.*, tbl_produkte.*, tbl_lieferbarkeiten.*
                    FROM tbl_konfigurator
                    INNER JOIN tbl_produkte
                    ON tbl_konfigurator.FIDKomponente = tbl_produkte.IDProdukt
                    INNER JOIN tbl_lieferbarkeiten
                    ON tbl_produkte.FIDLieferbarkeit = tbl_lieferbarkeiten.IDLieferbarkeit
                    WHERE tbl_konfigurator.FIDPC = " . $row_pcs["IDProdukt"] . ";";
                    echo "<ul>";
                    $gesamt = 0;
                    $result_kom = $conn->query($sql_kom) or die("Fehler in der Query " . $conn->error);
                    // $summe = 0;

                    while ($row_kom = mysqli_fetch_assoc($result_kom)) {
                        echo "<li>";
                        echo $row_kom["Artikelnummer"] . " " . $row_kom["Produkt"] . " " . $row_kom["Lieferbarkeit"] . " " . $row_kom["Anzahl"] . " " . $row_kom["Preis"];
                        $summe = $row_kom["Anzahl"] *  $row_kom["Preis"];
                        $gesamt += $summe;
                        echo "</li>";
                    }
                    echo "<li>Total Price: " . $gesamt . "</li>";
                    echo "</ul>";
                }
            }
            echo "</ul>";
        }
    }
} else {
    $sql_pcs = "SELECT * FROM tbl_produkte
    WHERE tbl_produkte.FIDKategorie = 2;";
    echo "<ul>";
    $result_pcs = $conn->query($sql_pcs) or die("Fehler in der Query " . $conn->error);
    while ($row_pcs = mysqli_fetch_assoc($result_pcs)) {
        echo "<li>";
        echo $row_pcs["Produkt"];
        echo "</li>";
        if ($row_pcs["IDProdukt"] != null) {
            $sql_kom = "SELECT tbl_konfigurator.*, tbl_produkte.*, tbl_lieferbarkeiten.*
        FROM tbl_konfigurator
        INNER JOIN tbl_produkte
        ON tbl_konfigurator.FIDKomponente = tbl_produkte.IDProdukt
        INNER JOIN tbl_lieferbarkeiten
        ON tbl_produkte.FIDLieferbarkeit = tbl_lieferbarkeiten.IDLieferbarkeit
        WHERE tbl_konfigurator.FIDPC = " . $row_pcs["IDProdukt"] . ";";


            echo "<ul>";
            $gesamt = 0;
            $result_kom = $conn->query($sql_kom) or die("Fehler in der Query " . $conn->error);
            // $summe = 0;

            while ($row_kom = mysqli_fetch_assoc($result_kom)) {
                echo "<li>";
                echo $row_kom["Artikelnummer"] . " " . $row_kom["Produkt"] . " " . $row_kom["Lieferbarkeit"] . " " . $row_kom["Anzahl"] . " " . $row_kom["Preis"];
                $summe = $row_kom["Anzahl"] *  $row_kom["Preis"];
                $gesamt += $summe;
                echo "</li>";
            }
            echo "<li>Total Price: " . $gesamt . "</li>";
            echo "</ul>";
        }
    }
    echo "</ul>";
}
