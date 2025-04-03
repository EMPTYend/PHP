<?php

declare(strict_types=1);

// Загрузка транзакций из JSON-файла
function loadTransactions(string $filename): array {
    if (!file_exists($filename)) {
        return [];
    }
    $data = file_get_contents($filename);
    return json_decode($data, true) ?? [];
}

// Сохранение транзакций в JSON-файл
function saveTransactions(string $filename, array $transactions): void {
    file_put_contents($filename, json_encode($transactions, JSON_PRETTY_PRINT));
}

// Вычисление общей суммы транзакций
function calculateTotalAmount(array $transactions): float {
    return array_reduce($transactions, fn($total, $transaction) => $total + $transaction["amount"], 0);
}

// Поиск транзакции по части описания
function findTransactionByDescription(array $transactions, string $descriptionPart): array {
    return array_filter($transactions, fn($transaction) => stripos($transaction["description"], $descriptionPart) !== false);
}

// Поиск транзакции по ID
function findTransactionById(array $transactions, int $id): ?array {
    foreach ($transactions as $transaction) {
        if ($transaction["id"] === $id) {
            return $transaction;
        }
    }
    return null;
}

// Поиск транзакции по ID с array_filter
function findTransactionByIdFilter(array $transactions, int $id): ?array {
    $filtered = array_filter($transactions, fn($transaction) => $transaction["id"] === $id);
    return count($filtered) > 0 ? array_values($filtered)[0] : null;
}

// Подсчет дней с момента транзакции
function daysSinceTransaction(string $date): int {
    $transactionDate = new DateTime($date);
    $currentDate = new DateTime();
    return $currentDate->diff($transactionDate)->days;
}

// Добавление новой транзакции
function addTransaction(string $filename, array &$transactions, int $id, string $date, float $amount, string $description, string $merchant): void {
    $transactions[] = [
        "id" => $id,
        "date" => $date,
        "amount" => $amount,
        "description" => $description,
        "merchant" => $merchant,
    ];
    saveTransactions($filename, $transactions);
}

// Сортировка по дате
function sortTransactionsByDate(array &$transactions): void {
    usort($transactions, fn($a, $b) => strcmp($a["date"], $b["date"]));
}

// Сортировка по убыванию суммы
function sortTransactionsByAmount(array &$transactions): void {
    usort($transactions, fn($a, $b) => $b["amount"] <=> $a["amount"]);
}
?>
