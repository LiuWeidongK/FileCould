<?php

$dir = $_REQUEST["dir"];
$dirName = pathinfo($dir)["dirname"];
$option = iconv("UTF-8", "GBK", $dir);
if (!file_exists($option)){
    mkdir($option,0777,true);
    header("location: index.php?dir=" . $dirName);
} else {
    header("location: index.php?error=folderRepeat&dir=" . $dirName);
}