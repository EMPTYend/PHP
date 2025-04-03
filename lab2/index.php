<?php
$dayOfWeek = date('N'); 

$john_schedule = ($dayOfWeek == 1 || $dayOfWeek == 3 || $dayOfWeek == 5) ? "8:00-12:00" : "Нерабочий день";
$jane_schedule = ($dayOfWeek == 2 || $dayOfWeek == 4 || $dayOfWeek == 6) ? "12:00-16:00" : "Нерабочий день";

//for

$a_for = 0;
$b_for = 0;
$for_results = [];

for ($i = 0; $i <= 5; $i++) {
    $a_for += 10;
    $b_for += 5;
    $for_results[] = "Шаг $i: a = $a_for, b = $b_for";
}

//while
$a_while = 0;
$b_while = 0;
$i = 0;
$while_results = [];

while ($i <= 5) {
    $a_while += 10;
    $b_while += 5;
    $while_results[] = "Шаг $i: a = $a_while, b = $b_while";
    $i++;
}

//do-while
$a_do = 0;
$b_do = 0;
$i = 0;
$do_while_results = [];

do {
    $a_do += 10;
    $b_do += 5;
    $do_while_results[] = "Шаг $i: a = $a_do, b = $b_do";
    $i++;
} while ($i <= 5);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Расписание и Циклы</title>
</head>
<body>

    <h2>Расписание сотрудников</h2>
    <table cellpadding="5">
        <tr>
            <th>Nr</th>
            <th>Фамилия Имя</th>
            <th>График работы</th>
        </tr>
        <tr>
            <td>1</td>
            <td>John Styles</td>
            <td><?= $john_schedule; ?></td>
        </tr>
        <tr>
            <td>2</td>
            <td>Jane Doe</td>
            <td><?= $jane_schedule; ?></td>
        </tr>
    </table>

    <hr>

    <h2>Результаты цикла (for)</h2>
    <?php foreach ($for_results as $result) : ?>
        <p><?= $result; ?></p>
    <?php endforeach; ?>
    <strong>a = <?= $a_for; ?>, b = <?= $b_for; ?></strong>

    <hr>

    <h2>Результаты цикла (while)</h2>
    <?php foreach ($while_results as $result) : ?>
        <p><?= $result; ?></p>
    <?php endforeach; ?>
    <strong>a = <?= $a_while; ?>, b = <?= $b_while; ?></strong>

    <hr>

    <h2>Результаты цикла (do-while)</h2>
    <?php foreach ($do_while_results as $result) : ?>
        <p><?= $result; ?></p>
    <?php endforeach; ?>
    <strong>a = <?= $a_do; ?>, b = <?= $b_do; ?></strong>

</body>
</html>
