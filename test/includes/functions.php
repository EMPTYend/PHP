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
    $totalQuestions = count($questions);
    $totalCorrectAnswers = 0;

    if ($totalQuestions === 0) {
        return [
            'correct_answers' => 0,
            'total_questions' => 0
        ];
    }

    foreach ($questions as $index => $question) {
        $correctOptions = $question['correct_options'];
        
        if ($question['type'] === 'multiple') {
            $totalCorrectAnswers++;
            if (isset($options[$index]) && is_array($options[$index])) {
                $selectedOptions = $options[$index];
                $correctCount = count(array_intersect($selectedOptions, $correctOptions));
                $incorrectCount = count(array_diff($selectedOptions, $correctOptions));
                
                if ($correctCount === count($correctOptions) && $incorrectCount === 0) {
                    $score++;
                }
            }
        } else {
            $totalCorrectAnswers++;
            if (isset($options[$index]) && in_array($options[$index], $correctOptions)) {
                $score++;
            }
        }
    }

    return [
        'correct_answers' => $score,
        'total_questions' => $totalQuestions
    ];
}

