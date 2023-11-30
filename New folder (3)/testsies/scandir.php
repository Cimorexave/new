<?php
// scandir: scans an address (path) that you give it and returns all
// the files and folders that exist in that path

// current folder
// scandir("./")

// parent of current folder
// scandir("../")

// parent of parent of current folder
// scandir("../../")

// parent of parent of parent of current folder
// scandir("../../../")

// $filesandfolders = scandir("../");

// echo "<pre>";
// var_dump($filesandfolders);
// echo "</pre>";

get_all_subfolders_and_subfiles("../");

function get_all_subfolders_and_subfiles($path)
{
    $subs = scandir($path);
    echo "<ul>";
    foreach ($subs as $thing) {
        $fullpath = $path . "/" . $thing;
        // echo $thing . "is folder? " . is_dir($thing) . "is file? " . is_file($thing) . "<br>";
        if (is_dir($fullpath) && $thing != "." && $thing != "..") {
            echo "<li>";
            echo "folder: " . $thing . "<br>";
            get_all_subfolders_and_subfiles($fullpath);
            echo "</li>";
        } else if (is_file($fullpath)) {
            if (str_contains($fullpath, ".jpg")) {
                echo "<li>";
                echo "preview: ";
                echo "</li>";
                echo "<img src='$fullpath' width=150 height=150 >";
            } else {
                echo "<li>";
                echo "file: " . $thing . "<br>";
                echo "</li>";
            }
        }
    }
    echo "</ul>";
}

// echo "<br>";
// $info = pathinfo("./scandir.php");
// echo "<pre>";
// var_dump($info);
// echo "</pre>";

// make directory(folder):
// mkdir("./newfoldertestsies");

// remove directory(folder):
// rmdir("./newfoldertestsies");

// delete file
// unlink("./boob.php");
