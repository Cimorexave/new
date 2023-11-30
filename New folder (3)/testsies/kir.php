<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Kir</title>
</head>

<body>
    <form action="kir.php" method="post">
        <label for="fn">Folder Name:</label> <br>
        <input type="text" name="fn"> <br>
        <input type="submit" name="add" value="add">
    </form>

</body>

</html>
<?php
// form with input
// input is for folder name
// create a new folder with that name
if (isset($_POST["add"])) {
    $directory = scandir("./");
    if (in_array($_POST["fn"], $directory)) {
        echo "Folder " . $_POST["fn"] . " already exists!";
    } else {
        $path = "./";
        $foldername = $_POST["fn"];
        $newpath = $path . "/" . $foldername;
        mkdir($newpath);
        //rmdir($newpath);
    }
}
