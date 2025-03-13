<?php
// Загружаем вопросы и результаты
require_once 'includes/security.php';
require_once 'includes/functions.php';
$questions = load_questions();
$results = load_results();

// Получаем данные из формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $answers = $_POST['answer'];

    // Рассчитываем количество правильных ответов
    $score = calculate_score($answers, $questions);

    // Сохраняем результаты
    save_results($username, $score);

    // Перенаправляем на страницу с результатами
    header("Location: result.php?name=" . urlencode($username));
    exit();
}
?>
