<?php include './header.php'; ?>

<h1>Все рецепты</h1>
<?php

// Абсолютный путь к файлу
$filePath = __DIR__ . '/../storage/recipes.txt';

// Проверка существования файла
if (!file_exists($filePath)) {
    // Если файл не существует, создаем его
    file_put_contents($filePath, json_encode([])); // Пустой массив JSON
}

// Чтение данных из файла
$jsonData = file_get_contents($filePath);

// Декодирование JSON в массив объектов
$recipes = json_decode($jsonData);

// Если декодирование не удалось или данные не массив, используем пустой массив
if (!is_array($recipes)) {
    $recipes = [];
}

// Пагинация
$recipesPerPage = 5;
$totalRecipes = count($recipes);
$totalPages = ceil($totalRecipes / $recipesPerPage);
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $recipesPerPage;
$currentRecipes = array_slice($recipes, $offset, $recipesPerPage);
?>

<?php foreach ($currentRecipes as $recipe): ?>
    <?php if (isset($recipe->title) && isset($recipe->description)): ?>
        <h2><?php echo htmlspecialchars($recipe->title); ?></h2>
        <p><?php echo htmlspecialchars($recipe->description); ?></p>
    <?php else: ?>
        <p>Данные рецепта не найдены.</p>
    <?php endif; ?>
<?php endforeach; ?>




</body>
</html>
