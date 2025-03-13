<?php
/**
 * Основной обработчик теста.
 * Загружает вопросы, обрабатывает ответы пользователя и сохраняет результаты.
 */

require_once 'includes/functions.php';

// Загружаем вопросы и результаты
$questions = load_questions();
$results = load_results();

/**
 * Проверка наличия файла с вопросами и его корректного формата.
 */
if (!$questions) {
    die("Ошибка: вопросы не загружены. Проверьте формат файла questions.json.");
}

// Проверяем, был ли отправлен POST-запрос
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /**
     * Получаем имя пользователя и ответы из формы.
     * Фильтруем ввод для предотвращения XSS-атак.
     *
     * @var string $username Имя пользователя
     * @var array $answers Ответы пользователя
     */
    $username = htmlspecialchars(trim($_POST['username'] ?? ''), ENT_QUOTES, 'UTF-8');
    $answers = $_POST['answer'] ?? [];

    // Проверка наличия имени пользователя
    if (empty($username)) {
        die("Ошибка: имя пользователя не может быть пустым.");
    }

    /**
     * Подсчет результата теста.
     * 
     * @var array $score Массив с количеством правильных ответов и общим числом вопросов.
     */
    $score = calculate_score($answers, $questions);

    // Сохраняем результаты теста
    save_results($username, $score);

    // Перенаправляем на страницу с результатами
    header("Location: result.php?name=" . urlencode($username));
    exit();
}
?>
