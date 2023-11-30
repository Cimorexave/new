<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Practice</title>
</head>

<body>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="">upload your file:</label>
        <input type="file" name="fileinput">
        <input type="submit" value="Submit" name="fileuploadsubmit">
    </form>
</body>
<?php
if (isset($_POST["fileuploadsubmit"])) {
    echo "<pre>";
    var_dump($_FILES);
    echo "</pre>";

    $uploaded_file = $_FILES["fileinput"];
    if (!is_dir("./uploadedfiles")) {
        mkdir("./uploadedfiles");
    }
    move_uploaded_file($uploaded_file["tmp_name"], "./uploadedfiles/" . $uploaded_file["name"]);
}
?>

</html>