<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Upload</title>
</head>

<body>
    <form action="uploadarmita.php" method="post" enctype="multipart/form-data">
        <input type="file" name="file">
        <input type="submit" name="submit">
    </form>
</body>

</html>
<?php
if (isset($_POST["submit"])) {
    echo "<pre>";
    echo var_dump($_FILES["file"]);
    echo "</pre>";

    $myfile = $_FILES["file"];
    $path = "./armita/" . $myfile["name"];
    $result = move_uploaded_file($myfile["tmp_name"], $path);
    if ($result) {
        echo "Successfully uploaded!";
    }
}
