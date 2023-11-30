<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>
    <ul>
        <li><a href="interpreten.php">Interpreten</a></li>
        <li><a href="songs.php">Songs</a></li>
    </ul>
</body>

</html>
<?php

require("./Includes/conn.inc.php");

$sql_alben = "SELECT tbl_alben.*, tbl_interpreten.*
FROM tbl_alben
INNER JOIN tbl_interpreten
ON tbl_alben.FIDInterpret = tbl_interpreten.IDInterpret;";

$result_alben = $conn->query($sql_alben) or die("Fehler in der Query: " . $conn->error);
echo "<ul>";
while ($row_alben = mysqli_fetch_assoc($result_alben)) {

    echo "<li>";
    echo "„" . $row_alben["Albumtitel"] . "“ von " . $row_alben["Interpret"] . "(" . $row_alben["Erscheinungsjahr"] . ")";

    $sql_songs = "SELECT tbl_songs.*, tbl_alben.* 
        FROM tbl_songs 
        INNER JOIN tbl_alben
        ON tbl_songs.FIDAlbum = tbl_alben.IDAlbum
        WHERE tbl_alben.IDAlbum = " . $row_alben['IDAlbum'] . ";";
    $result_songs = $conn->query($sql_songs) or die("Fehler in der Query: " . $conn->error);
    echo "<ol>";
    while ($row_songs = mysqli_fetch_assoc($result_songs)) {
        echo "<li>";
        echo $row_songs["Songtitel"] . "<br>";
        echo "</li>";
    }

    echo "</ol>";
    echo "</li>";
}
echo "</ul>";
