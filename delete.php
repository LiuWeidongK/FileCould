<?php

if(isset($_REQUEST["fileDir"])) {
    deleteFile($_REQUEST["fileDir"]);
}

if(isset($_REQUEST["folderDir"])) {
    deleteFolder($_REQUEST["folderDir"]);
}

function deleteFile($fileDir) {
    $dirName = pathinfo($fileDir)["dirname"];
    if (!unlink($fileDir)) {
        header("location: index.php?error=deleteFileError&dir=" . $dirName);
    }
    else {
        header("location: index.php?dir=" . $dirName);
    }
}

function deleteFolder($folderDir) {
    $dirName = pathinfo($folderDir)["dirname"];
    $dh = opendir($folderDir);
    while ($file = readdir($dh)) {
        if($file != "." && $file != "..") {
            $fullpath = $folderDir . "/" . $file;
            if(!is_dir($fullpath)) {
                unlink($fullpath);
            } else {
                deleteFolder($fullpath);
            }
        }
    }

    closedir($dh);

    if(rmdir($folderDir)) {
        header("location: index.php?dir=" . $dirName);
    } else {
        header("location: index.php?error=deleteFolderError&dir=" . $dirName);
    }

}