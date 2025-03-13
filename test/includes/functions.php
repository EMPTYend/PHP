<?php
require_once 'security.php';

/**
 * Загружает вопросы из JSON-файла.
 *
 * @return array Массив с вопросами.
 */
function load_questions() {
    return json_decode(file_get_contents('data/questions.json'), true);
}

/**
 * Загружает результаты тестов из JSON-файла.
 *
 * @return array Массив с результатами тестов.
 */
function load_results() {
    $filePath = 'data/results.json';
    if (file_exists($filePath)) {
        $data = file_get_contents($filePath);
        return json_decode($data, true);
    }
    return [];
}

/**
 * Сохраняет результаты теста в файл.
 *
 * @param string $name Имя пользователя.
 * @param array $score Массив с результатами теста (количество правильных ответов и общее количество вопросов).
 *
 * @return void
 */
function save_results($name, $score) {
    $file = 'data/results.json';

    // Проверка существования файла
    if (!file_exists($file)) {
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
 * Подсчитывает результаты теста.
 *
 * @param array $options Ответы пользователя, где ключ - индекс вопроса, а значение - выбранные варианты.
 * @param array $questions Вопросы теста.
 *
 * @return array Ассоциативный массив с количеством правильных ответов и общим количеством вопросов.
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
        
        // Если вопрос с несколькими правильными ответами
        if ($question['type'] === 'multiple') {
            $totalCorrectAnswers += count($correctOptions); // Суммируем все правильные ответы
            if (isset($options[$index]) && is_array($options[$index])) {
                $score += count(array_intersect($options[$index], $correctOptions)); // Считаем пересечение
            }
        } else {
            // Для вопросов с одним правильным ответом
            $totalCorrectAnswers += 1; // Один правильный ответ на вопрос
            if (isset($options[$index]) && in_array($options[$index], $correctOptions)) {
                $score++; // Добавляем 1 балл за правильный ответ
            }
        }
    }

    return [
        'correct_answers' => $score,
        'total_questions' => $totalQuestions
    ];
}
