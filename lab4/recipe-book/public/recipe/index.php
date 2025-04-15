<?php include '../header.php'; ?>

<?php
/**
 * Путь к файлу с рецептами
 * @var string $filePath
 */
$filePath = __DIR__ . '/../../storage/recipes.txt';

/**
 * Если файл не существует, создать его с пустым JSON-массивом
 */
if (!file_exists($filePath)) {
    file_put_contents($filePath, json_encode([]));
}

/**
 * Получение содержимого файла рецептов
 * @var string $jsonData
 */
$jsonData = file_get_contents($filePath);

/**
 * Декодирование JSON-строки в массив объектов
 * @var array|null $recipes
 */
$recipes = json_decode($jsonData);

/**
 * Если декодирование не удалось или результат не массив — сбросить в пустой массив
 */
if (!is_array($recipes)) {
    $recipes = [];
}

/**
 * Фильтрация массива рецептов: удаление null-значений
 */
$recipes = array_filter($recipes, function($recipe) {
    return $recipe !== null;
});

/**
 * Количество рецептов на странице
 * @var int $recipesPerPage
 */
$recipesPerPage = 5;

/**
 * Общее количество рецептов
 * @var int $totalRecipes
 */
$totalRecipes = count($recipes);

/**
 * Общее количество страниц
 * @var int $totalPages
 */
$totalPages = $totalRecipes > 0 ? ceil($totalRecipes / $recipesPerPage) : 1;

/**
 * Текущая страница
 * @var int $page
 */
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

/**
 * Смещение для текущей страницы
 * @var int $offset
 */
$offset = ($page - 1) * $recipesPerPage;

/**
 * Массив рецептов для текущей страницы
 * @var array $currentRecipes
 */
$currentRecipes = array_slice($recipes, $offset, $recipesPerPage);
?>

<h1>Все рецепты</h1>

<?php foreach ($currentRecipes as $recipe): ?>
    <?php if (isset($recipe->title) && isset($recipe->description)) : ?>
        <h2><?php echo htmlspecialchars($recipe->title, ENT_QUOTES, 'UTF-8'); ?></h2>
        <p><?php echo htmlspecialchars($recipe->description, ENT_QUOTES, 'UTF-8'); ?></p>
        <p><?php echo htmlspecialchars($recipe->category, ENT_QUOTES, 'UTF-8'); ?></p>
        <p><?php echo htmlspecialchars($recipe->ingredients, ENT_QUOTES, 'UTF-8'); ?></p>
        <p>
        <?php 
            foreach($recipe->tags as $tag){
                echo htmlspecialchars($tag, ENT_QUOTES, 'UTF-8') . ' ';
            }
        ?>
        </p>

        <ul>
        <?php 
            foreach($recipe->steps as $stepo){
                echo "<li>" . htmlspecialchars($stepo, ENT_QUOTES, 'UTF-8') . "</li>";
            }
        ?>
        </ul>

    <?php else: ?>
        <p>Некорректные данные рецепта.</p>
    <?php endif; ?>
<?php endforeach; ?>

<div>
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>
</div>
