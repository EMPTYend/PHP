<?php

/**
 * This file is the entry point of the application.
 * It loads transactions from a JSON file, sorts them by date and amount, and performs further operations.
 */

declare(strict_types=1);

require_once 'functions.php';

$filename = 'transaction.json';
$transactions = loadTransactions($filename);

sortTransactionsByDate($transactions);
sortTransactionsByAmount($transactions);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Банковские транзакции</title>
    <link rel="stylesheet" href="gallery/css/style.css">
</head>
<body>

<?php include '../lab3/gallery/header.php'; ?>

    <h2>Список банковских транзакций</h2>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Дата</th>
                <th>Сумма</th>
                <th>Описание</th>
                <th>Получатель</th>
                <th>Дней с момента транзакции</th>
            </tr>
        </thead>
        <tbody>
            <!-- /**
             * Renders a table row for each transaction in the $transactions array.
             *
             * @param array $transactions The array of transactions.
             */ -->
            <?php foreach ($transactions as $transaction) : ?>
                <tr>
                    <td><?= htmlspecialchars((string)$transaction["id"]); ?></td>
                    <td><?= htmlspecialchars($transaction["date"]); ?></td>
                    <td><?= htmlspecialchars(number_format($transaction["amount"], 2)); ?> $</td>
                    <td><?= htmlspecialchars($transaction["description"]); ?></td>
                    <td><?= htmlspecialchars($transaction["merchant"]); ?></td>
                    <td><?= daysSinceTransaction($transaction["date"]); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5">Total Amount</th>
                <td><?php echo calculateTotalAmount($transactions)?></td>
            </tr>
        </tfoot>
    </table>


</body>

<?php include '../lab3/gallery/footer.php'; ?>

</html>
