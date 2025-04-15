<?php
ob_start();  // Включаем буферизацию вывода
include '../header.php';
?>

<h1>Добавить рецепт</h1>

<?php
/**
 * Обработка отправки формы
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /**
     * Получаем данные из POST-запроса и фильтруем спецсимволы
     * @var string $title
     * @var string $category
     * @var string $ingredients
     * @var string $description
     * @var array $tags
     * @var array $steps
     */
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $ingredients = filter_input(INPUT_POST, 'ingredients', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $tags = isset($_POST['tags']) ? $_POST['tags'] : [];
    $steps = isset($_POST['steps']) ? $_POST['steps'] : [];

    /**
     * Валидация данных формы
     * @var array $errors
     */
    $errors = [];
    if (empty($title)) {
        $errors['title'] = 'Название рецепта обязательно';
    }

    if (empty($errors)) {
        /**
         * Формируем массив рецепта для записи в файл
         * @var array $recipe
         */
        $recipe = [
            'title' => $title,
            'category' => $category,
            'ingredients' => $ingredients,
            'description' => $description,
            'tags' => $tags,
            'steps' => $steps
        ];

        /**
         * Путь к файлу хранения рецептов
         * @var string $filePath
         */
        $filePath = __DIR__ . '/../../storage/recipes.txt';

        /**
         * Получение существующих данных и декодирование
         * @var string $existingData
         * @var array $data
         */
        $existingData = file_get_contents($filePath);
        $data = $existingData ? json_decode($existingData, true) : [];

        // Добавление нового рецепта и сохранение обратно
        $data[] = $recipe;

        /**
         * Сохраняем обновлённый массив в файл
         * @var bool|int $result
         */
        $result = file_put_contents($filePath, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        if ($result === false) {
            echo "Ошибка записи в файл.<br>";
        } else {
            echo "Данные успешно записаны в файл.<br>";
            header('Location: /public/index.php');
            exit;
        }
    } else {
        // Отображение ошибок пользователю
        foreach ($errors as $field => $error) {
            echo "<p>$error</p>";
        }
    }
}
?>

<form action="create.php" method="post">
    <label for="title">Название рецепта:</label>
    <input type="text" id="title" name="title" required><br>

    <label for="category">Категория:</label>
    <select id="category" name="category">
        <option>Завтрак</option>
        <option>Обед</option>
        <option>Ужин</option>
    </select><br>

    <label for="ingredients">Ингредиенты:</label><br>
    <textarea id="ingredients" name="ingredients" required></textarea><br>

    <label for="description">Описание:</label><br>
    <textarea id="description" name="description" required></textarea><br>

    <label for="tags">Тэги:</label><br>
    <select id="tags" name="tags[]" multiple>
        <option value="Быстро">Быстро</option>
        <option value="Полезно">Полезно</option>
        <option value="Вегетарианское">Вегетарианское</option>
    </select><br>

    <div id="stepsContainer">
        <label for="step1">Шаг 1:</label><br>
        <input type="text" name="steps[]" required><br>
    </div>
    <button type="button" onclick="addStep()">Добавить шаг</button><br>

    <button type="submit">Отправить</button>
</form>

<script>
/**
 * Добавление дополнительного поля для ввода шага рецепта
 */
function addStep() {
    const stepsContainer = document.getElementById('stepsContainer');
    const stepCount = stepsContainer.querySelectorAll('input[name="steps[]"]').length + 1;
    const newStep = document.createElement('div');
    newStep.innerHTML = `<label for="step${stepCount}">Шаг ${stepCount}:</label><br><input type="text" name="steps[]" required><br>`;
    stepsContainer.appendChild(newStep);
}
</script>

<?php
ob_end_flush();  // Завершение буферизации и вывод содержимого
?>
</body>
</html>



<!-- <?php include '../header.php'; ?>


<h1>Добавить рецепт</h1>

<form action="process.php" method="post">
    <label for="title">Название рецепта:</label>
    <input type="text" id="title" name="title" required><br>

    <label for="category">Категория:</label>
    <select id="category" name="category">
        <option>Завтрак</option>
        <option>Обед</option>
        <option>Ужин</option>
    </select><br>

    <label for="ingredients">Ингредиенты:</label><br>
    <textarea id="ingredients" name="ingredients" required></textarea><br>

    <label for="description">Описание:</label><br>
    <textarea id="description" name="description" required></textarea><br>

    <label for="tags">Тэги:</label><br>
    <select id="tags" name="tags[]" multiple>
        <option value="Быстро">Быстро</option>
        <option value="Полезно">Полезно</option>
        <option value="Вегетарианское">Вегетарианское</option>
    </select><br>

    <div id="stepsContainer">
        <label for="step1">Шаг 1:</label><br>
        <input type="text" name="steps[]" required><br>
    </div>
    <button type="button" onclick="addStep()">Добавить шаг</button><br>

    <button type="submit">Отправить</button>
</form>

<script>
function addStep() {
    const stepsContainer = document.getElementById('stepsContainer');
    const stepCount = stepsContainer.children.length + 1;
    const newStep = document.createElement('div');
    newStep.innerHTML = `<label for="step${stepCount}">Шаг ${stepCount}:</label><br>
                         <input type="text" name="steps[]" required><br>`;
    stepsContainer.appendChild(newStep);
}
</script>

</body>
</html> -->
