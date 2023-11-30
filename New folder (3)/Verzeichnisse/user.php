<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User & Formular</title>

</head>

<body>
    <form action="user.php" method="post" enctype="multipart/form-data">
        <label for="vorname">Vorname:</label><br>
        <input type="text" name="vorname" value="<?php echo !empty($_POST['vorname']) ? $_POST['vorname'] : '' ?>" required><br>
        <label for="folder">Folder Name:</label><br>
        <input type="text" name="folder" required><br><br>
        <input type="file" name="stuff"><br><br>
        <input type="submit" name="submit" value="submit">
    </form>
</body>

<?php
// Filter Vorname should stay the same even after filtering (done)
// All pictures should be saved in images but only as jpg (as their own name)
// All other files should be saved in files
// Date folders should be deleteable through one button
// images should be represented underneath "Preview" 300 px
$path = "./users";
if (isset($_POST["submit"])) {
    if (in_array($_POST["vorname"], scandir($path))) {
        $newPath = $path . "/" . $_POST["vorname"];
        $checkpath = $newPath . "/" . $_POST["folder"];
        if (str_contains($checkpath, $_POST["folder"])) {
            $folderPath = $path . "/" . $_POST["vorname"] . "/" . $_POST["folder"];
            folders($folderPath, $path);
        } else {
            $folderPath = $path . "/" . $_POST["vorname"] . "/" . $_POST["folder"];
            $resultfolder = mkdir($folderPath);
            folders($folderPath, $path);
        }
    } else {
        $newPath = $path . "/" . $_POST["vorname"];
        mkdir($newPath);
        // create Folder
        $folderPath = $path . "/" . $_POST["vorname"] . "/" . $_POST["folder"];
        $resultfolder = mkdir($folderPath);
        folders($folderPath, $path);
    }
}

function folders($folderPath, $path)
{
    $now = time();
    $timefolder = $folderPath . "/" . $now;
    $resulttime = mkdir($timefolder);
    // create Folders for Images and Files
    $images = $timefolder . "/images";
    $files = $timefolder . "/files";
    mkdir($images);
    mkdir($files);
    if (isset($_FILES["stuff"])) {
        // mime_content_type-
        $fileinput = $_FILES["stuff"];
        if (str_contains($fileinput["type"], "image")) {
            $imagewithoutext = pathinfo($fileinput["name"], PATHINFO_FILENAME);
            $imagepathjpg = $images . "/" . $imagewithoutext . ".jpg";
            move_uploaded_file($fileinput["tmp_name"], $imagepathjpg);
        } else {
            $filepath = $files . "/" . $fileinput["name"];
            move_uploaded_file($fileinput["tmp_name"], $filepath);
        }
    }
    if ($resulttime) {
        show($path);
    }
}

function show($path)
{
    $subs = scandir($path);
    echo "<ul>";
    foreach ($subs as $thing) {
        $folderorfilepath = $path . "/" . $thing;
        if ($thing != "." && $thing != "..") {
            if (is_dir($folderorfilepath)) {
                if (is_numeric($thing) != false) {
                    echo "<li>";
                    // echo $thing . "<button type='button' id='del' onclick='removeFolder($thing)'>x</button>";
                    echo $thing . "<form action='user.php' method='post'><input type='text' name='removingfolderpath' value='$folderorfilepath' style='display: none;'><input type='submit' name='removingfoldersubmit' value='X'></form>";
                    show($folderorfilepath);
                    echo "</li>";
                } else {
                    echo "<li>";
                    echo $thing;
                    show($folderorfilepath);
                    echo "</li>";
                }
            } else if (is_file($folderorfilepath)) {
                if (str_contains(strtolower($folderorfilepath), ".jpg")) {
                    echo "<li>";
                    echo "Preview";
                    echo "</li>";
                    echo "<img height=300 width=300 src='" . $folderorfilepath . "'>";
                } else {
                    echo "<li>";
                    echo $thing;
                    echo "</li>";
                    echo "<iframe src='" . $folderorfilepath . "'>";
                }
            }
        }
    }
    echo "</ul>";
}

if (isset($_POST["removingfoldersubmit"])) {

    $deleting_folder_path = $_POST["removingfolderpath"];
    rrmdir($deleting_folder_path);
    echo "Successfully deleted folder: $deleting_folder_path" . "<br>";
    show("./users");
}

function rrmdir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $object) && !is_link($dir . "/" . $object))
                    rrmdir($dir . DIRECTORY_SEPARATOR . $object);
                else
                    unlink($dir . DIRECTORY_SEPARATOR . $object);
            }
        }
        rmdir($dir);
    }
}
?>
<!-- <script>
    // document.getElementById("del").onclick = removefolder;

    // function removefolder(folderName) {
    //     console.log(folderName);
    //     folderName = folderName.toString();
    // }
</script> -->

</html>