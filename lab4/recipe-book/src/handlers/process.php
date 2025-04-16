<?php

/**
 * Обработка формы добавления рецепта
 * 
 * При успешной валидации данные сохраняются в файл `recipes.txt`,
 * иначе — выводятся ошибки.
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Сохраняем POST-данные для отладки
    file_put_contents('debug.txt', print_r($_POST, true));

    // Получение и фильтрация данных из формы
    /** @var string $title Название рецепта */
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    /** @var string $category Категория рецепта */
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    /** @var string $ingredients Ингредиенты */
    $ingredients = filter_input(INPUT_POST, 'ingredients', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    /** @var string $description Описание рецепта */
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    /** @var array $tags Теги (без фильтрации — массив строк) */
    $tags = isset($_POST['tags']) && is_array($_POST['tags']) ? array_map('htmlspecialchars', $_POST['tags']) : [];

    /** @var array $steps Шаги (без фильтрации — массив строк) */
    $steps = isset($_POST['steps']) && is_array($_POST['steps']) ? array_map('htmlspecialchars', $_POST['steps']) : [];

    // Вывод отладочной информации (можно отключить позже)
    echo "title: " . htmlspecialchars($title) . "<br>";
    echo "category: " . htmlspecialchars($category) . "<br>";
    echo "ingredients: " . htmlspecialchars($ingredients) . "<br>";
    echo "description: " . htmlspecialchars($description) . "<br>";
    echo "tags: " . implode(', ', $tags) . "<br>";
    echo "steps:<br><ul>";
    foreach ($steps as $step) {
        echo "<li>$step</li>";
    }
    echo "</ul>";

    // Простая валидация
    $errors = [];

    if (empty($title)) {
        $errors[] = 'Название рецепта обязательно.';
    }

    // Если ошибок нет — сохраняем рецепт
    if (empty($errors)) {
        $recipe = [
            'title'       => $title,
            'category'    => $category,
            'ingredients' => $ingredients,
            'description' => $description,
            'tags'        => $tags,
            'steps'       => $steps
        ];

        /** @var string $filePath Путь к файлу с рецептами */
        $filePath = __DIR__ . '/../../storage/recipes.txt';

        // Чтение и декодирование текущих данных
        $existingData = file_get_contents($filePath);
        $data = $existingData ? json_decode($existingData, true) : [];
        if (!is_array($data)) {
            $data = [];
        }

        // Добавление рецепта и сохранение
        $data[] = $recipe;
        
        file_put_contents($filePath, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        // Перенаправление на главную страницу
        header('Location: /public/index.php');
        exit;

    } else {
        // Отображение ошибок
        echo "<h3>Ошибки:</h3><ul>";
        foreach ($errors as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        echo "</ul>";
    }

} else {
    echo "Неверный метод запроса.";
}
