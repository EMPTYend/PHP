<?php
/**
 * Валидация и фильтрация входных данных.
 */

/**
 * Фильтрует строку от нежелательных символов.
 * 
 * @param string $data Данные для фильтрации.
 * @return string Отфильтрованная строка.
 */
function sanitize_input($data) {
    return htmlspecialchars(trim($data));
}

/**
 * Валидирует имя пользователя (не пустое, без спецсимволов).
 * 
 * @param string $name Имя пользователя.
 * @return bool Возвращает true, если имя валидно, иначе false.
 */
function validate_name($name) {
    $name = sanitize_input($name);
    return !empty($name) && preg_match("/^[a-zA-Zа-яА-Я\s]+$/", $name);
}

/**
 * Валидирует ответы, проверяя их на корректность.
 * 
 * @param mixed $answers Ответы пользователя.
 * @param int $questionIndex Индекс вопроса.
 * @return bool Возвращает true, если ответы валидны, иначе false.
 */
function validate_answers($options, $questionIndex) {
    if (is_array($options)) {
        // Для вопросов с несколькими ответами
        return !empty($options);
    } else {
        // Для вопросов с одним ответом
        return !empty($options);
    }
}

/**
 * Перенаправляет на указанную страницу.
 * 
 * @param string $url URL для редиректа.
 */
function redirect($url) {
    header("Location: $url");
    exit();
}
?>
