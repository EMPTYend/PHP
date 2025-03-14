<?php
/**
 * Файл для отображения теста пользователю.
 * Загружает вопросы из JSON-файла и формирует HTML-форму.
 */
$questionsFile = 'data/questions.json';  // Путь к файлу с вопросами

/**
 * Проверка существования файла и загрузка вопросов.
 */

if (file_exists($questionsFile)) {
    $json = file_get_contents($questionsFile);
    $questions = json_decode($json, true);
    
    // Вывод содержимого для отладки
    if ($questions === null) {
        echo "Ошибка при декодировании JSON";
    } 
} else {
    echo "Файл не найден.";
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Прохождение теста</title>
    
    <!-- Подключение внешнего CSS -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Тест</h1>
    <form action="submit.php" method="post" novalidate>
    <label>Введите ваше имя:</label>
    <input type="text" name="username" required>
    <br><br>

    <?php foreach ($questions as $index => $question): ?><div>
        <p><?php echo ($index + 1) . ". " . $question['question']; ?></p>
        <?php if ($question['type'] === 'single'): ?>
            <?php foreach ($question['options'] as $key => $answer): ?>
                <label>
                    <input type="radio" name="answer[<?php echo $index; ?>]" value="<?php echo $key; ?>" required>
                    <?php echo $answer; ?>
                </label><br>
            <?php endforeach; ?>
        <?php else: ?>
            <?php foreach ($question['options'] as $key => $answer): ?>
                <label>
                    <input type="checkbox" name="answer[<?php echo $index; ?>][]" value="<?php echo $key; ?>">
                    <?php echo $answer; ?>
                </label><br>
            <?php endforeach; ?>
        <?php endif; ?>
        <br>
        </div>
    <?php endforeach; ?>

    <button type="submit">Завершить тест</button>
</form>

</body>
</html>

