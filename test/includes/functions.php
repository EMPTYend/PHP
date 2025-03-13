<?php
require_once 'security.php';

/**
 * Загрузка вопросов из JSON файла.
 * 
 * @return array Массив с вопросами.
 */
function load_questions() {
    return json_decode(file_get_contents('data/questions.json'), true);
}
function load_results() {
    $filePath = 'data/results.json';
    if (file_exists($filePath)) {
        $data = file_get_contents($filePath);
        return json_decode($data, true);
    }
    return [];
}

/**
 * Сохранение результатов теста в файл.
 * 
 * @param string $name Имя пользователя.
 * @param float $score Баллы пользователя.
 */
function save_results($name, $score) {
    $file = 'data/results.json';

    // Проверка существования файла
    if (!file_exists($file)) {
        // Если файл не существует, создаём пустой массив
        file_put_contents($file, json_encode([]));
    }

    // Загружаем текущие результаты
    $results = json_decode(file_get_contents($file), true);

    // Проверяем, что результат не является null
    if ($score['correct_answers'] === null || $score['total_questions'] === null) {
        echo "Ошибка: один из результатов имеет значение null.";
        return; // Не сохраняем результат, если один из них null
    }

    // Добавляем новый результат
    $results[] = [
        'name' => $name,
        'score' => [
            'correct_answers' => $score['correct_answers'],
            'total_questions' => $score['total_questions']
        ]
    ];

    // Сохраняем обновлённый список результатов обратно в файл
    file_put_contents($file, json_encode($results, JSON_PRETTY_PRINT));
}




/**
 * Подсчет результатов теста.
 * 
 * @param array $options Ответы пользователя.
 * @param array $questions Вопросы теста.
 * @return float Процент правильных ответов.
 */
    function calculate_score($options, $questions) {
    $score = 0;
    $totalQuestions = count($questions); // Общее количество вопросов
    $totalCorrectAnswers = 0; // Общее количество правильных ответов

    // Проверяем, есть ли вопросы
    if ($totalQuestions === 0) {
        return [
            'correct_answers' => 0,
            'total_questions' => 0
        ];
    }

    foreach ($questions as $index => $question) {
        // Получаем правильные ответы для текущего вопроса
        $correctOptions = $question['correct_options'];
        $totalCorrectAnswers += count($correctOptions); // Суммируем все правильные ответы

        // Проверка на существование ответа пользователя для этого вопроса
        if (isset($options[$index])) {
            if (is_array($options[$index])) {
                // Для вопросов с несколькими правильными ответами
                $correctAnswers = count(array_intersect($options[$index], $correctOptions)); // Считаем пересечение
                $score += $correctAnswers; // Добавляем количество правильных ответов
            } else {
                // Для вопросов с одним правильным ответом
                if (in_array($options[$index], $correctOptions)) {
                    $score++; // Добавляем 1 балл за правильный ответ
                }
            }
        }
    }

    // Если нет правильных ответов, возвращаем ноль
    if ($totalCorrectAnswers === 0) {
        return [
            'correct_answers' => 0,
            'total_questions' => 0
        ];
    }

    // Подсчитываем процент правильных ответов
    $percentage = ($score / $totalCorrectAnswers) * 100;
    
    return [
        'correct_answers' => $score,
        'total_questions' => $totalCorrectAnswers
    ];
}



?>
