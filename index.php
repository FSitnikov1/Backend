<!DOCTYPE html>
<html lang="Ru">

<head>
    <!-- Кодировка веб-страницы -->
    <meta charset="UTF-8">
    <!-- Настройка viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Подключение css файла -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Название веб-страницы во вкладках -->
    <title>DATABASE_Form</title>
</head>

<body>
    <div class="main">
        <form class="formula" action="form.php" method="POST">
            <h2 id="forma" class="undershape">Форма</h2>
            <div class="form_item">
                <label class="form_label labe">
                    Имя:<br>
                    <input type="text" name="username">
                </label>
            </div>
            <div class="form_item">
                <label class="form_label labe">
                    E-mail:<br>
                    <input type="email" name="email">
                </label>
            </div>
            <div class="form_item">
                <label class="form_label labe">
                    Дата рождения:<br>
                    <input type="date" name="birthday">
                </label>
            </div>
            <div class="form_item">
                <br>Пол:
                <label class="form_label labe">
                    <input type="radio" name="sex" value=1>
                    женский
                </label>
                <label class="form_label labe">
                    <input type="radio" name="sex" value=2>
                    мужской
                </label>
            </div>
            <div class="form_item">
                <br>Количество конечностей:<br>
                <label class="form_label">
                    <input type="radio" name="limbs" value=1>
                    0
                </label>
                <label class="form_label">
                    <input type="radio" name="limbs" value=2>
                    1
                </label>
                <label class="form_label">
                    <input type="radio" name="limbs" value=3>
                    2
                </label>
                <label class="form_label">
                    <input type="radio" name="limbs" value=4>
                    3
                </label>
                <label class="form_label">
                    <input type="radio" checked="checked" name="limbs" value=5>
                    4
                </label>
            </div>
            <div class="form_item">
                Сверхспособности:<br>
                <label class="form_label labe">
                    <select name="superpowers" multiple="multiple">
                        <option value=0 selected="selected">Бессмертие</option>
                        <option value=1>Прохождение сквозь стены</option>
                        <option value=2>Левитация</option>
                    </select>
                </label>
            </div>
            <div class="form_item">
                Биография: <br>
                <label class="form_label labe">
                    <textarea name="biography" autofocus></textarea>
                </label>
            </div>
            <div class="form_item">
                <label>
                    <input type="checkbox" name="checkbox" value = 1> с контрактом ознакомлен (а) <br>
                </label>
            </div>
            <div class="form_item btn">
                <input class="form_button" type="submit" «Отправить»>
            </div>
        </form>
    </div>
</body>

</html>