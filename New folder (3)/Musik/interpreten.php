<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>
    <ul>
        <li><a href="alben.php">Alben</a></li>
        <li><a href="songs.php">Songs</a></li>
    </ul>
</body>

</html>
<?php
require("./Includes/conn.inc.php");

// ol interpreter:, underneath another ol for (album) (Year)
$sql_interpret = "SELECT * FROM tbl_interpreten;";
$result_interpret = $conn->query($sql_interpret) or die("Fehler in der Query: " . $conn->error);
echo "<ul>";
while ($row_interpret = mysqli_fetch_assoc($result_interpret)) {
    echo "<li>";
    echo $row_interpret["Interpret"] . ": ";

    $sql_album = "SELECT tbl_interpreten.*, tbl_alben.*
    FROM tbl_interpreten
    INNER JOIN tbl_alben
    ON tbl_interpreten.IDInterpret = tbl_alben.FIDInterpret
    WHERE tbl_interpreten.IDInterpret =" . $row_interpret["IDInterpret"] . ";";
    $result_album = $conn->query($sql_album) or die("Fehler in der QUery: " . $conn->error);
    echo "<ul>";
    while ($row_album = mysqli_fetch_assoc($result_album)) {
        echo "<li>";
        echo "(" . $row_album["Albumtitel"] . ") " . "(" . $row_album["Erscheinungsjahr"] . ") <br>";
        echo "</li>";
    }
    echo "</ul>";
    echo "</li>";
}
echo "</ul>";
