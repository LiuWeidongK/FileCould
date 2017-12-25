<?php

$dir = $_REQUEST["dir"];

if ($_FILES["file"]["error"] > 0) {
    header("location: index.php?error=uploadError&dir=" . $dir);
} else {
    if (file_exists($dir . '/' . $_FILES["file"]["name"])) {
        header("location: index.php?error=uploadFileRepeat&dir=" . $dir);
    } else {
        move_uploaded_file($_FILES["file"]["tmp_name"], $dir . '/' . $_FILES["file"]["name"]);
        header("location: index.php?dir=" . $dir);
    }
}
