<?php
/**
 * Простая реализация функции filter_input_array.
 * 
 * @param int   $type       Тип источника (например, INPUT_POST или INPUT_GET)
 * @param array $definition Массив с ключами и соответствующими фильтрами
 * 
 * @return array Ассоциативный массив с отфильтрованными значениями
 */
function filters_input_array($type, $definition) {
    $data = [];
    foreach ($definition as $key => $filter) {
        $data[$key] = filter_input($type, $key, $filter);
    }
    return $data;
}

/**
 * Reads and decodes JSON data from a file.
 *
 * @param string $filePath The path to the JSON file.
 *
 * @throws RuntimeException If the file cannot be read or the JSON is invalid.
 *
 * @return array The decoded JSON data as an associative array.
 */
function getJsonDataFromFile($filePath) {
    if (!file_exists($filePath) || !is_readable($filePath)) {
        throw new RuntimeException("Ошибка: файл $filePath не существует или недоступен для чтения");
    }

    $jsonData = file_get_contents($filePath);
    $data = json_decode($jsonData, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new RuntimeException("Ошибка: не удалось декодировать JSON из файла $filePath");
    }

    return $data;
}

