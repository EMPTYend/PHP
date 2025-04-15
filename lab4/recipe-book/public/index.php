<?php include './header.php'; ?>

<h1>Все рецепты</h1>

<?php

/**
 * Абсолютный путь к файлу с рецептами
 * @var string $filePath
 */
$filePath = __DIR__ . '/../storage/recipes.txt';

/**
 * Проверка существования файла. Если нет — создаём с пустым массивом
 */
if (!file_exists($filePath)) {
    file_put_contents($filePath, json_encode([]));
}

/**
 * Получение содержимого файла и декодирование JSON
 * @var string $jsonData
 * @var array $recipes
 */
$jsonData = file_get_contents($filePath);
$recipes = json_decode($jsonData);

/**
 * Проверка, что данные — массив. Если нет — обнуляем.
 */
if (!is_array($recipes)) {
    $recipes = [];
}

/**
 * Параметры пагинации
 * @var int $recipesPerPage Количество рецептов на странице
 * @var int $totalRecipes Общее количество рецептов
 * @var int $totalPages Общее количество страниц
 * @var int $page Текущая страница
 * @var int $offset Смещение для array_slice
 * @var array $currentRecipes Рецепты на текущей странице
 */
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

<!-- Навигация по страницам -->
<div>
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>
</div>

</body>
</html>
