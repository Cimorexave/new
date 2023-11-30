<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Songs</title>
</head>

<body>
    <ul>
        <li><a href="interpreten.php">Interpreten</a></li>
        <li><a href="alben.php">Alben</a></li>
    </ul>
    <form action="songs.php" method="post">
        <input type="text" name="songsearch">
        <input type="submit" value="Suchen" name="search">
    </form>
</body>

</html>

<?php

require("./Includes/conn.inc.php");

if (isset($_POST["search"])) {
    $search = $_POST['songsearch'];
    $sql_songsfilter = $sql_songs = "SELECT tbl_songs.*, tbl_interpreten.*, tbl_alben.*
    FROM tbl_songs
    INNER JOIN tbl_alben
    ON tbl_songs.FIDAlbum = tbl_alben.IDAlbum
    INNER JOIN tbl_interpreten 
    ON tbl_alben.FIDInterpret = tbl_interpreten.IDInterpret
    WHERE tbl_songs.Songtitel LIKE '" . $search . "%' ;";

    $result_songs_filter = $conn->query($sql_songsfilter) or die("Fehler in der Query: " . $conn->error);
    echo "<ul>";
    while ($row_songs_result = mysqli_fetch_assoc($result_songs_filter)) {
        echo "<li>";
        echo $row_songs_result["Songtitel"] . " aus dem Album " . $row_songs_result["Albumtitel"] . " (" . $row_songs_result["Erscheinungsjahr"] . ") von " . $row_songs_result["Interpret"];
        echo "</li>";
    }
    echo "</ul>";
} else {
    $sql_songs = "SELECT tbl_songs.*, tbl_interpreten.*, tbl_alben.*
    FROM tbl_songs
    INNER JOIN tbl_alben
    ON tbl_songs.FIDAlbum = tbl_alben.IDAlbum
    INNER JOIN tbl_interpreten 
    ON tbl_alben.FIDInterpret = tbl_interpreten.IDInterpret
    ORDER BY tbl_songs.Songtitel ASC;";

    $result_songs = $conn->query($sql_songs) or die("Fehler in  der Query: " . $conn->error);
    echo "<ul>";
    while ($row_songs = mysqli_fetch_assoc($result_songs)) {
        echo "<li>";
        echo $row_songs["Songtitel"] . " aus dem Album " . $row_songs["Albumtitel"] . " (" . $row_songs["Erscheinungsjahr"] . ") von " . $row_songs["Interpret"];
        echo "</li>";
    }
    echo "</ul>";
}
