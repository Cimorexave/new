<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Arzt & Patiente</title>
</head>

<body>
    <form action="arztpat.php" method="post">
        <label for="von">von:</label><br>
        <input type="date" name="von" value="<?php echo isset($_POST['von']) ? $_POST['von'] : ''; ?>"><br>
        <label for="bis">bis:</label><br>
        <input type="date" name="bis" value="<?php echo isset($_POST['bis']) ? $_POST['bis'] : ''; ?>"><br>
        <input type="submit" name="filter" value="filtern">
    </form>
</body>

</html>
<?php
require("./includes/conn.inc.php");
// $row_patients["PatientSeit"]
$conditions = [];
if (isset($_POST["filter"])) {
    if (!empty($_POST["von"])) {
        $conditions[] = "tbl_patienten.PatientSeit >= '" . $_POST["von"] . "'";
    }
    if (!empty($_POST["bis"])) {
        $conditions[] = "tbl_patienten.PatientSeit <= '" . $_POST["bis"] . "'";
    }

    if (!empty($conditions)) {
        $where = implode(" AND ", $conditions);

        $sql_con = "SELECT DISTINCT tbl_patienten.FIDMedical
        FROM tbl_patienten
        WHERE " . $where . ";";

        $medicalid = "";
        $result_con = $conn->query($sql_con) or die("Fehler in der Query: " . $conn->error);
        while ($row_con = mysqli_fetch_assoc($result_con)) {
            $medicalid = $row_con["FIDMedical"];

            $sql_arzt = "SELECT tbl_medical_person.*, tbl_medical.*, tbl_medical_fachrichtungen.*, tbl_fachrichtungen.*, tbl_staaten.Staat as 'Country'
            FROM tbl_medical_person
            INNER JOIN tbl_medical
            ON tbl_medical_person.FIDMedical = tbl_medical.IDMedical
            INNER JOIN tbl_medical_fachrichtungen
            ON tbl_medical.IDMedical = tbl_medical_fachrichtungen.FIDMedical
            INNER JOIN tbl_fachrichtungen
            ON tbl_medical_fachrichtungen.FIDFachrichtung = tbl_fachrichtungen.IDFachrichtung
            INNER JOIN tbl_staaten
            ON tbl_medical.FIDStaat = tbl_staaten.IDStaat
            WHERE tbl_fachrichtungen.Fachrichtung = 'Arzt für Allgemeinmedizin' AND 
            tbl_medical.IDMedical = " . $medicalid . ";";

            $result_arzt = $conn->query($sql_arzt) or die("Fehler in der Query: " . $conn->error);
            echo "<ul>";
            while ($row_arzt = mysqli_fetch_assoc($result_arzt)) {
                echo "<li>";
                echo "<b>" . $row_arzt["Titel"] . " " . $row_arzt["Vorname"] . " " . $row_arzt["Nachname"] . " </b><br>";
                echo $row_arzt["Fachrichtung"] . "<br>";
                echo $row_arzt["Strasse"] . ", " . $row_arzt["PLZ"] . " " . $row_arzt["Ort"] . ", " . $row_arzt["Country"];


                $sql_patients = "SELECT tbl_patienten.*, tbl_medical.*, tbl_medical_person.IDMedicalPerson, tbl_medical_person.FIDMedical, tbl_personen.*, tbl_staaten.*
                FROM tbl_patienten
                INNER JOIN tbl_medical
                ON tbl_patienten.FIDMedical = tbl_medical.IDMedical
                INNER JOIN tbl_medical_person
                ON tbl_medical.IDMedical = tbl_medical_person.FIDMedical
                INNER JOIN tbl_personen
                ON tbl_patienten.FIDPerson = tbl_personen.IDPerson
                INNER JOIN tbl_staaten
                ON tbl_personen.FIDStaat = tbl_staaten.IDStaat
                WHERE tbl_medical_person.IDMedicalPerson = " . $row_arzt["IDMedicalPerson"] . " AND " . $where . ";";

                echo "<ul>";
                $result_patients = $conn->query($sql_patients) or die("Fehler in der Query: " . $conn->error);
                while ($row_patients = mysqli_fetch_assoc($result_patients)) {
                    echo "<li>";
                    $originalDate = $row_patients["PatientSeit"];
                    $newDate = date("j.n.Y", strtotime($originalDate));
                    echo $row_patients["Vorname"] . " " . $row_patients["Nachname"] . "<br>";
                    echo $row_patients["Adresse"] . ", " . $row_patients["PLZ"] . " " . $row_patients["Ort"] . ", " . $row_patients["Staat"] . "<br>";
                    echo "Patient Seit: " . $newDate;

                    echo "</li>";
                }
                echo "</ul>";

                echo "</li>";
            }
            echo "</ul>";
        }
    }
} else {
    $sql_arzt = "SELECT tbl_medical_person.*, tbl_medical.*, tbl_medical_fachrichtungen.*, tbl_fachrichtungen.*, tbl_staaten.Staat as 'Country'
    FROM tbl_medical_person
    INNER JOIN tbl_medical
    ON tbl_medical_person.FIDMedical = tbl_medical.IDMedical
    INNER JOIN tbl_medical_fachrichtungen
    ON tbl_medical.IDMedical = tbl_medical_fachrichtungen.FIDMedical
    INNER JOIN tbl_fachrichtungen
    ON tbl_medical_fachrichtungen.FIDFachrichtung = tbl_fachrichtungen.IDFachrichtung
    INNER JOIN tbl_staaten
    ON tbl_medical.FIDStaat = tbl_staaten.IDStaat
    WHERE tbl_fachrichtungen.Fachrichtung = 'Arzt für Allgemeinmedizin';";

    $result_arzt = $conn->query($sql_arzt) or die("Fehler in der Query: " . $conn->error);
    echo "<ul>";
    while ($row_arzt = mysqli_fetch_assoc($result_arzt)) {
        echo "<li>";
        echo "<b>" . $row_arzt["Titel"] . " " . $row_arzt["Vorname"] . " " . $row_arzt["Nachname"] . " </b><br>";
        echo $row_arzt["Fachrichtung"] . "<br>";
        echo $row_arzt["Strasse"] . ", " . $row_arzt["PLZ"] . " " . $row_arzt["Ort"] . ", " . $row_arzt["Country"];

        $sql_patients = "SELECT tbl_patienten.*, tbl_medical.*, tbl_medical_person.IDMedicalPerson, tbl_medical_person.FIDMedical, tbl_personen.*, tbl_staaten.*
        FROM tbl_patienten
        INNER JOIN tbl_medical
        ON tbl_patienten.FIDMedical = tbl_medical.IDMedical
        INNER JOIN tbl_medical_person
        ON tbl_medical.IDMedical = tbl_medical_person.FIDMedical
        INNER JOIN tbl_personen
        ON tbl_patienten.FIDPerson = tbl_personen.IDPerson
        INNER JOIN tbl_staaten
        ON tbl_personen.FIDStaat = tbl_staaten.IDStaat
        WHERE tbl_medical_person.IDMedicalPerson =" . $row_arzt["IDMedicalPerson"] . ";";

        echo "<ul>";
        $result_patients = $conn->query($sql_patients) or die("Fehler in der Query: " . $conn->error);
        while ($row_patients = mysqli_fetch_assoc($result_patients)) {
            echo "<li>";
            $originalDate = $row_patients["PatientSeit"];
            $newDate = date("j.n.Y", strtotime($originalDate));
            echo $row_patients["Vorname"] . " " . $row_patients["Nachname"] . "<br>";
            echo $row_patients["Adresse"] . ", " . $row_patients["PLZ"] . " " . $row_patients["Ort"] . ", " . $row_patients["Staat"] . "<br>";
            echo "Patient Seit: " . $newDate;

            echo "</li>";
        }
        echo "</ul>";

        echo "</li>";
    }
    echo "<ul>";
}
