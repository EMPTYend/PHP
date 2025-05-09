онтрольные вопросы
1. Что такое массивы в PHP?
Массивы в PHP — это структуры данных, которые позволяют хранить множество значений в одной переменной. Каждый элемент массива ассоциирован с уникальным ключом (числовым или строковым), по которому можно получить доступ к значению. PHP поддерживает как индексированные (числовые ключи), так и ассоциативные массивы (строковые ключи).

2. Каким образом можно создать массив в PHP?
Массив можно создать несколькими способами:

// Простой индексированный массив
$fruits = ['apple', 'banana', 'orange'];

// Ассоциативный массив
$user = [
    'name' => 'Alice',
    'email' => 'alice@example.com'
];

// Старый синтаксис
$numbers = array(1, 2, 3, 4);

3. Для чего используется цикл foreach?
Цикл foreach используется для перебора элементов массива. Это удобный способ пройтись по всем значениям массива без необходимости отслеживать индексы вручную.

Пример использования:

$fruits = ['apple', 'banana', 'orange'];

foreach ($fruits as $fruit) {
    echo $fruit . "<br>";
}

$person = ['name' => 'Alice', 'email' => 'alice@example.com'];

foreach ($person as $key => $value) {
    echo "$key: $value<br>";
}
