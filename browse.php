<?php

$uploadDirPath = $_SERVER['DOCUMENT_ROOT'] . "/upload/";
$filesList = scandir($uploadDirPath);

if (isset($_POST["del"])) {
    foreach ($_POST as $key => $fileName) {
        if ($key !== "del") {
            foreach ($filesList as $i => $image) {
                if ($fileName == $image) {
                    unlink($uploadDirPath . $fileName);
                }
            }
        };
    };
};

function printFileSize(string $pathToTheFile)
{
    $fileSize = filesize($pathToTheFile);
    if ($fileSize <= 10240) {
        echo $fileSize . "b";
    } else if ($fileSize > 10240 && $fileSize <= 1048576) {
        echo round($fileSize / 1024) . "Kb";
    } else {
        echo round($fileSize / 1048576) . "Mb";
    }
}

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP Gallery | Browse images</title>
    <style>
        body {
            background-color: #fff;
            color: #000;
        }
    </style>
</head>
<body>
<a href="/">Вернуться к странице загрузки</a>
<br>
<br>
<?php
$filesList = scandir($uploadDirPath);

unset($filesList[0], $filesList[1]);

if (!empty($filesList)) { ?>

    <form action="<?= $_SERVER['PHP_SELF'] ?>"
          method="post"
          id="delForm"
          style="
            display:flex;
            flex-wrap: wrap;
          "
    >
        <?php
        natsort($filesList);
        foreach ($filesList as $fileName) {
            ?>
            <label style="margin-right: 10px">
                <img src="<?= "/upload/" . $fileName ?>" alt="img" style="height: 200px;">
                <p style="margin: 0;">Имя файла: <?= $fileName ?></p>
                <p style="margin: 0;">Размер файла: <?php printFileSize($uploadDirPath . $fileName) ?></p>
                <p style="margin: 0;">Дата загрузки: <?= date("d.m.Y", filemtime($uploadDirPath . $fileName)) ?>
                    г.</p>
                <span><input type="checkbox" name="image<?= $fileName ?>ToDel" value="<?= $fileName ?>">Удалить</span>
            </label>
            <br>
            <br>
            <?php
        }
        ?>
    </form>
    <button type="submit" form="delForm" name="del" value="true">Удалить отмеченные изображения</button>

    <br>
    <br>
    <?php
} else {
    echo "<div>Загруженных изображений нет</div>";
};
?>
</body>
</html>
