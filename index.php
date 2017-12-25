<!DOCTYPE html>
<html lang="en">

<head>
    <title>Never Give up</title>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/uniform.css"/>
    <link rel="stylesheet" href="css/matrix-style.css"/>
    <link rel="stylesheet" href="css/matrix-media.css"/>
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet"/>

</head>

<body>

<div id="content">
    <div class="container-fluid">
        <hr>
        <?php

            $dir = "./files";
            if(isset($_REQUEST["dir"])) {
                $dir = $_REQUEST["dir"];
            }

            if(isset($_REQUEST['error'])) {
                if($_REQUEST['error'] == "folderRepeat") {
                    echo "<script>alert('文件夹重复')</script>";
                }
                if($_REQUEST['error'] == "deleteFileError") {
                    echo "<script>alert('删除文件失败')</script>";
                }
                if($_REQUEST['error'] == "deleteFolderError") {
                    echo "<script>alert('删除文件夹失败')</script>";
                }
                if($_REQUEST['error'] == "uploadError") {
                    echo "<script>alert('文件上传失败')</script>";
                }
                if($_REQUEST['error'] == "uploadFileRepeat") {
                    echo "<script>alert('文件名重复')</script>";
                }
            }
        ?>

        <!-- Form -->
        <div class="widget-box">
            <div class="widget-content nopadding">
                <form action="upload.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="file">File upload input</label>
                        <div class="controls">
                            <input type="file" name="file" id="file"/>
                            <input type="hidden" name="dir" value="<?php echo $dir; ?>">
                            <span id="__submit"><i class="icon-upload-alt"></i></span>
                            <span id="__create"><i class="icon-folder-open"></i></span>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Dir -->
        <div class="navigation">
            <?php
                getNavigation($dir);
            ?>
        </div>

        <!-- Table -->
        <div class="widget-box">
            <div class="widget-content nopadding">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="90%">Files Name</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $files = scandir($dir);
                        foreach ($files as $file) {
                            $tempDir = $dir . '/' . $file;
                            if ($file == "." || $file == "..")
                                continue;
                            if (filetype($tempDir) == "file")
                                echo getFileElem($tempDir);
                            else if (filetype($tempDir) == "dir")
                                echo getFolderElem($tempDir);
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/jquery.uniform.js"></script>
<script src="js/matrix.form_common.js"></script>

<script>
    $('#__submit').click(function () {
        $('form').submit();
    });

    // Create a new folder
    $('#__create').click(function () {
        var folderName = prompt("Please Input New Folder Name:", "NewFolder");
        if (folderName !== null){
            var dir = "<?php echo $dir . '/' ?>" + folderName;
            window.location.href = "create.php?dir=" + dir;
        }
    });
</script>

</body>

</html>

<?php

function getFileElem($fullDir) {
    $file = pathinfo($fullDir)["basename"];
    $tr = "<tr>";
    $tr .= "<td><a href='download.php?fileDir=$fullDir'>$file</a></td>";
    $tr .= "<td><a href='delete.php?fileDir=$fullDir'><i class='icon-trash'></i></a></td>";
    $tr .= "</tr>";
    return $tr;
}

function getFolderElem($fullDir) {
    $folder = pathinfo($fullDir)["basename"];
    $tr = "<tr>";
    $tr .= "<td><a href='index.php?dir=$fullDir'>$folder</a></td>";
    $tr .= "<td><a href='delete.php?folderDir=$fullDir'><i class='icon-trash'></i></a></td>";
    $tr .= "</tr>";
    return $tr;
}

function getNavigation($fullDir) {
    $arr = explode("/", $fullDir);
    for($i = 0; $i < count($arr); $i++) {
        $href = "";
        if($arr[$i] == "" || $i == 0)
            continue;
        for($j = 0; $j <= $i; $j++) {
            $href .= $arr[$j] . "/";
        }
        $href = substr($href, 0, strlen($href) - 1);
        if($i == 1)
            echo "<a href='index.php'><i class='icon-home'></i> $arr[$i]</a> / ";
        else if($i == count($arr) - 1 && $i != 1)
            echo "<span href='javascript:void(0)'>$arr[$i]</span> / ";
        else
            echo "<a href='index.php?dir=$href'>$arr[$i]</a> / ";
    }
}



