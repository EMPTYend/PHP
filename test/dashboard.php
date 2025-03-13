<?php
require_once 'includes/security.php';
require_once 'includes/functions.php';

/**
 * Загружает и отображает результаты тестирования.
 * Проверяет наличие результатов и выводит их в виде таблицы.
 */

// Загрузка результатов из файла
$results = load_results();

// Проверка на наличие данных
if (empty($results)) {
    echo "Нет результатов!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Результаты тестов</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Все результаты</h1>
        <?php if (empty($results)): ?>
            <p>Нет результатов!</p>
        <?php else: ?>
            <table>
                <tr>
                    <th>Имя</th>
                    <th>Правильные ответы</th>
                    <th>Процент</th>
                </tr>
                <?php foreach ($results as $result): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($result['name']); ?></td>
                        <td><?php echo (int) $result['score']['correct_answers']; ?> из <?php echo (int) $result['score']['total_questions']; ?></td>
                        <td>
                            <?php
                                $correct_answers = (int) $result['score']['correct_answers'];
                                $total_questions = (int) $result['score']['total_questions'];
                                $percentage = ($total_questions > 0) ? round(($correct_answers / $total_questions) * 100, 2) : 0;
                                echo $percentage . '%';
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
        <a href="index.php">На главную</a>
    </div>
</body>
</html>
