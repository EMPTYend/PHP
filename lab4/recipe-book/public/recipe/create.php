<?php include '../header.php'; 
    include_once '../../src/handlers/process.php';
?>


<h1>Добавить рецепт</h1>

<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
    <label for="title">Название рецепта:</label>
    <input type="text" id="title" name="title" required><br>

    <label for="category">Категория:</label>
    <select id="category" name="category">
        <option>Завтрак</option>
        <option>Обед</option>
        <option>Ужин</option>
    </select><br>

    <label for="ingredients">Ингредиенты:</label><br>
    <textarea id="ingredients" name="ingredients" required></textarea><br>

    <label for="description">Описание:</label><br>
    <textarea id="description" name="description" required></textarea><br>

    <label for="tags">Тэги:</label><br>
    <select id="tags" name="tags[]" multiple>
        <option value="Быстро">Быстро</option>
        <option value="Полезно">Полезно</option>
        <option value="Вегетарианское">Вегетарианское</option>
    </select><br>

    <div id="stepsContainer">
        <label for="step1">Шаг 1:</label><br>
        <input type="text" name="steps[]" required><br>
    </div>
    <button type="button" onclick="addStep()">Добавить шаг</button><br>

    <button type="submit">Отправить</button>
</form>

<script>
function addStep() {
    const stepsContainer = document.getElementById('stepsContainer');
    const stepCount = stepsContainer.querySelectorAll('input[name="steps[]"]').length + 1;
    const newStep = document.createElement('div');
    newStep.innerHTML = `<label for="step${stepCount}">Шаг ${stepCount}:</label><br><input type="text" name="steps[]" required><br>`;
    stepsContainer.appendChild(newStep);
}
</script>

</body>
</html>
