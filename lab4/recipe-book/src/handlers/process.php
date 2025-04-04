
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Для отладки: выводим данные, полученные методом POST
    file_put_contents('debug.txt', print_r($_POST, true));
    
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $ingredients = filter_input(INPUT_POST, 'ingredients', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $tags = isset($_POST['tags']) ? $_POST['tags'] : [];
    $steps = isset($_POST['steps']) ? $_POST['steps'] : [];
    
    // Вывод для отладки (можно временно убрать)
    echo "title: " . htmlspecialchars($title) . "<br>";
    echo "category: " . htmlspecialchars($category) . "<br>";
    echo "ingredients: " . htmlspecialchars($ingredients) . "<br>";
    echo "description: " . htmlspecialchars($description) . "<br>";
    echo "tags: " . print_r($tags, true) . "<br>";
    echo "steps: " . print_r($steps, true) . "<br>";

    // Простейшая валидация (например, проверка обязательного поля title)
    $errors = [];
    if (empty($title)) {
        $errors[] = 'Название рецепта обязательно.';
    }

    if (empty($errors)) {
        // Формируем массив рецепта
        $recipe = [
            'title'       => $title,
            'category'    => $category,
            'ingredients' => $ingredients,
            'description' => $description,
            'tags'        => $tags,
            'steps'       => $steps
        ];

        // Определяем путь к файлу для хранения рецептов
        $filePath = __DIR__ . '/../../storage/recipes.txt';
        
        // Читаем существующие данные
        $existingData = file_get_contents($filePath);
        $data = $existingData ? json_decode($existingData, true) : [];
        if (!is_array($data)) {
            $data = [];
        }
        
        // Добавляем новый рецепт
        $data[] = $recipe;
        
        // Сохраняем обновленные данные в файл
        file_put_contents($filePath, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        
        // Перенаправляем на главную страницу или на страницу с рецептами
        header('Location: /public/index.php');
        exit;
    } else {
        // Если есть ошибки, выводим их
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
} else {
    echo "Неверный метод запроса.";
}
