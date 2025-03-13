<?php
require_once 'includes/functions.php';

/**
 * Получает имя пользователя из запроса и загружает его результаты.
 *
 * @return array|null Возвращает массив с результатами пользователя или null, если не найдено.
 */
function getUserResult() {
    if (!isset($_GET['name'])) {
        return null;
    }
    
    $name = htmlspecialchars($_GET['name']); // Защита от XSS
    $results = load_results();
    
    foreach ($results as $result) {
        if ($result['name'] === $name) {
            return $result;
        }
    }
    
    return null;
}

$userResult = getUserResult();
$message = $userResult ? null : "Результаты для этого пользователя не найдены.";
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ваши результаты</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Результаты</h1>
    <div class="result-container">
        <?php if ($userResult): ?>
            <?php 
                $correct_answers = (int) $userResult['score']['correct_answers'];
                $total_questions = (int) $userResult['score']['total_questions'];
                $percentage = ($total_questions > 0) ? round(($correct_answers / $total_questions) * 100, 2) : 0;
            ?>
            <p>Количество правильных ответов: <?php echo $correct_answers; ?> из <?php echo $total_questions; ?></p>
            <p class="score">Процент правильных ответов: <?php echo $percentage; ?>%</p>
        <?php else: ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <a href="dashboard.php">Все результаты</a><br>
        <a href="index.php">На главную</a>
    </div>
</body>
</html>
