<?php include '../header.php'; ?>

<?php
// Путь к файлу рецептов
$filePath = __DIR__ . '/../../storage/recipes.txt';

// Если файла нет, создаём его с пустым массивом
if (!file_exists($filePath)) {
    file_put_contents($filePath, json_encode([]));
}

// Читаем данные из файла
$jsonData = file_get_contents($filePath);

// Декодируем JSON в массив объектов
$recipes = json_decode($jsonData);

// Если декодирование не удалось или результат не массив, устанавливаем пустой массив
if (!is_array($recipes)) {
    $recipes = [];
}

// Фильтруем массив, чтобы исключить null-значения
$recipes = array_filter($recipes, function($recipe) {
    return $recipe !== null;
});

// Пагинация
$recipesPerPage = 5;
$totalRecipes = count($recipes);
$totalPages = $totalRecipes > 0 ? ceil($totalRecipes / $recipesPerPage) : 1;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $recipesPerPage;
$currentRecipes = array_slice($recipes, $offset, $recipesPerPage);
?>

<h1>Все рецепты</h1>

<?php foreach ($currentRecipes as $recipe): ?>
    <?php if (isset($recipe->title) && isset($recipe->description)) : ?>
        <h2><?php echo htmlspecialchars($recipe->title); ?></h2>
        <p><?php echo htmlspecialchars($recipe->description); ?></p>
    <?php else: ?>
        <p>Некорректные данные рецепта.</p>
    <?php endif; ?>
<?php endforeach; ?>

<div>
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>
</div>
