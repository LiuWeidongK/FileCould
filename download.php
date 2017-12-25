<?php

$fileDir = $_REQUEST["fileDir"];

$fileName = pathinfo($fileDir)["basename"];
$fp = fopen($fileDir,"r");
$fileSize = filesize($fileDir);
header("Content-type: application/octet-stream");
header("Accept-Length: " . $fileSize);
header("Accept-Ranges: bytes");
header("Content-Disposition: attachment; filename=" . $fileName);

$buffer = 1024;
while(!feof($fp)){
    $file_data = fread($fp, $buffer);
    echo $file_data;
}
fclose($fp);
  