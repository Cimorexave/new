<?php
// Write a function that gets all the folders in htdocs
// and shows all the files and folders in it in nested lists
// and presents pictures as well

show("../");

function show($path)
{
    $stuff = scandir($path);
    echo "<ul>";
    foreach ($stuff as $thing) {
        $folderorfilepath = $path . "/" . $thing;
        if ($thing != "." & $thing != "..") {
            if (is_dir($folderorfilepath)) {
                echo "<li>";
                echo $thing;
                show($folderorfilepath);
                echo "</li>";
            } elseif (is_file($folderorfilepath)) {
                if (str_contains($thing, ".jpg")) {
                    echo "<li>";
                    echo "<img width=150 height=150 src='" . $folderorfilepath . "'>";
                    echo "</li>";
                } else {
                    echo "<li>";
                    echo $thing;
                    echo "</li>";
                }
            }
        }
    }
    echo "</ul>";
}
