<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Login and Register</title>

    <style>
        /* Split the screen in half */
        .split {
            height: 100%;
            width: 50%;
            position: fixed;
            z-index: 1;
            top: 0;
            overflow-x: hidden;
            padding-top: 150px;
        }

        /* Control the left side */
        .left {
            left: 0;
        }

        /* Control the right side */
        .right {
            right: 0;
        }

        /* If you want the content centered horizontally and vertically */
        .centered {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }
    </style>
</head>

<body>
    <ul>
        <li><a href="logreg.php">Login/Register</a></li>
        <li><a href="reisen.php">Reisen</a></li>
        <li><a href="bewertungen.php">Bewertungen</a></li>
    </ul>

    <div class="split left">
        <p><b>Register</b></p>
        <form action="logreg.php" method="post">
            <fieldset style="width:200px">
                <legend>Pflichtangaben</legend>
                <label for="email">Emailadresse:</label><br>
                <input type="email" name="email" required><br>
                <label for="pass1">Password (mind. 8 Zeichen):</label><br>
                <input type="password" name="pass1" minlength="8" required><br><br>
                <input type="password" name="pass2" placeholder="Password wiederholen" required><br>
                <label for="vorname">Vorname:</label><br>
                <input type="text" name="vorname" required>
            </fieldset>
            <br>
            <fieldset style="width:200px">
                <legend>optionale Angaben</legend>
                <label for="nachname">Nachname:</label><br>
                <input type="text" name="nachname"><br>
                <label for="beschreibung">Eigene Beschreibung:</label><br>
                <textarea name="beschreibung" cols="21" rows="10"></textarea><br>
            </fieldset>
            <br>
            <input style="width:223px" type="submit" name="register" value="registrieren">
        </form>
    </div>

    <div class="split right">
        <p><b>Login</b></p>
        <form action="logreg.php" method="post">
            <fieldset style="width:200px">
                <label for="emaillog">Emailadresse:</label><br>
                <input type="email" name="emaillog" required><br>
                <label for="passlog">Password (mind. 8 Zeichen):</label><br>
                <input type="password" name="passlog" required><br>
            </fieldset>
            <br>
            <input style="width:223px" type="submit" name="login" value="einloggen">
        </form>

    </div>
</body>

</html>

<?php
require("./includes/conn.inc.php");


if (isset($_POST["register"])) {
    $userexists = false;
    if (!empty($_POST["email"]) && !empty(["pass1"]) && !empty(["pass2"]) && !empty(["vorname"])) {
        $sql_user = "SELECT * FROM tbl_user;";
        $result_user = $conn->query($sql_user) or die("Fehler in der Query: " . $conn->error);
        while ($row_user = mysqli_fetch_assoc($result_user)) {
            if ($row_user["Emailadresse"] == $_POST["email"]) {
                echo "This E-Mail Address already exists!";
                $userexists = true;
            }
        }
        if (!$userexists) {
            if ($_POST["pass1"] == $_POST["pass2"]) {
                $mail = "'" . $conn->real_escape_string($_POST["email"]) . "'";
                $pass = "'" . password_hash($_POST["pass1"], PASSWORD_DEFAULT) . "'";
                $vorname = "'" . $conn->real_escape_string($_POST["vorname"]) . "'";
                $nachname = !empty($_POST["nachname"]) ? "'" . $conn->real_escape_string($_POST["nachname"]) . "'" : "NULL";
                $beschreibung = !empty($_POST["beschreibung"]) ? "'" . $conn->real_escape_string($_POST["beschreibung"]) . "'" : "NULL";
                $regtime = "'" . date("Y-m-d H:i:s") . "'";

                // Hallo1234
                $sql_insert_user = "INSERT INTO tbl_user (Emailadresse, Passwort, Vorname, Nachname, Beschreibung, RegZeitpunkt)
                VALUES ($mail, $pass, $vorname, $nachname, $beschreibung, $regtime);";

                $ok = $conn->query($sql_insert_user) or die("Fehler in der Query: " . $conn->error);
                if ($ok) {
                    echo "Successfully Registered!";
                }
            } else {
                echo "Passwords aren't matching!";
            }
        }
    } else {
        echo "Please enter all required fields!";
    }
}
if (isset($_POST["login"])) {
    $sql_user = "SELECT * FROM tbl_user;";
    $result_user = $conn->query($sql_user) or die("Fehler in der Query: " . $conn->error);
    $userandpassmatch = false;
    $id = "";
    while ($row_user = mysqli_fetch_assoc($result_user)) {
        if ($_POST["emaillog"] == $row_user["Emailadresse"] && password_verify($_POST["passlog"], $row_user["Passwort"])) {
            $id = $row_user["IDUser"];
            $userandpassmatch = true;
        }
    }
    if ($userandpassmatch) {
        echo "Login was successful!";
    }
}
