<html>

<head>
    <title>multiple files upload</title>
</head>

<body>
    <form action="multipleupload.php" method="post" enctype="multipart/form-data">
        <label for="">upload files:</label><br>
        <input type="file" name="files[]" multiple>
        <input type="submit" value="Upload" name="submit">
    </form>
</body>

</html>
<?php
if (isset($_POST["submit"])) {
    if (!in_array("multipleupload", scandir("./"))) {
        mkdir("./multipleupload");
    }
    $save_path = "./multipleupload";

    echo "<pre>";
    var_dump($_FILES);
    echo "</pre>";

    for ($i = 0; $i < count($_FILES["files"]["name"]); $i++) {
        // $file = $_FILES["files"][$i];

        $file = [];
        $file["name"] = $_FILES["files"]["name"][$i];
        $file["type"] = $_FILES["files"]["type"][$i];
        $file["tmp_name"] = $_FILES["files"]["tmp_name"][$i];

        move_uploaded_file($file["tmp_name"], $save_path . "/" . $file["name"]);
    }
}
