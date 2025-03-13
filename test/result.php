<?php
require_once 'security.php';

// Получаем имя пользователя из URL
if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $results = load_results();
    $userResult = null;

    // Находим результаты пользователя
    foreach ($results as $result) {
        if ($result['name'] === $name) {
            $userResult = $result;
            break;
        }
    }

    // Если результаты найдены, отображаем их
    if ($userResult !== null) {
        $correct_answers = $userResult['score']['correct_answers'];
        $total_questions = $userResult['score']['total_questions'];
        $percentage = ($total_questions > 0) ? round(($correct_answers / $total_questions) * 100, 2) : 0;
    } else {
        $message = "Результаты для этого пользователя не найдены.";
    }
} else {
    $message = "Имя пользователя не передано.";
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ваши результаты</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Результаты</h1>
    <div class="result-container">
        <?php if (isset($userResult) && $userResult !== null): ?>
            <p>Количество правильных ответов: <?php echo $correct_answers; ?> из <?php echo $total_questions; ?></p>
            <p class="score">Процент правильных ответов: <?php echo $percentage; ?>%</p>
        <?php else: ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <a href="dashboard.php">Все результаты</a><br>
        <a href="index.php">На главную</a>
    </div>
</body>
</html>
