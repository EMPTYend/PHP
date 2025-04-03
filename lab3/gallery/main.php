<?php

$dir = 'image/';
$files = scandir($dir);

$images = array_filter($files, function ($file) use ($dir) {
    return is_file($dir . $file) && preg_match('/\.(jpg|jpeg)$/i', $file);
});

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Галерея изображений</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'header.php'; ?>

    <main>
        <h2>Галерея изображений</h2>
        <div class="gallery">
            <?php foreach ($images as $image) : ?>
                <div class="gallery-item">
                    <img src="<?= $dir . htmlspecialchars($image); ?>" alt="Image">
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <?php include 'footer.php'; ?>

</body>
</html>
