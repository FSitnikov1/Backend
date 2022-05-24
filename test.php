<?php

/**
 * Файл login.php для не авторизованного пользователя выводит форму логина.
 * При отправке формы проверяет логин/пароль и создает сессию,
 * записывает в нее логин и id пользователя.
 * После авторизации пользователь перенаправляется на главную страницу
 * для изменения ранее введенных данных.
 **/

// Отправляем браузеру правильную кодировку,
// файл login.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

$bduser = 'root';   // Пользователь и по совместительству имя бд
$bdpass = 'root';  // Пароль от пользователя
$bdname = 'u46491';   // НАзвание бд

// Начинаем сессию.
session_start();

// В суперглобальном массиве $_SESSION хранятся переменные сессии.
// Будем сохранять туда логин после успешной авторизации.
if (!empty($_SESSION['login'])) {
    // session_destroy();
    // Если есть логин в сессии, то пользователь уже авторизован.
    // TODO: Сделать выход (окончание сессии вызовом session_destroy()
    //при нажатии на кнопку Выход).
    // Делаем перенаправление на форму.
    header('Location: ./index.php');
}

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>
    <div>
        <div>
            <a href="./index.php">Вернуться</a>
        </div>
        <form action="" method="post">
            <div>
                <input name="login" placeholder="Логин" />
            </div>
            <div>
                <input name="pass" placeholder="Пароль" />
            </div>
            <div>
                <input type="submit" value="Войти"></input>
            </div>
        </form>
        <div>
            <?php
            if (!empty($_COOKIE['mes'])) {
                print($_COOKIE['mes']);
            }
            if (!empty($_COOKIE['ex'])) {
                print($_COOKIE['ex']);
            }
            ?>
        </div>
    </div>
<?php
}
// Иначе, если запрос был методом POST, т.е. нужно сделать авторизацию с записью логина в сессию.
else {

    // TODO: Проверть есть ли такой логин и пароль в базе данных.
    // Выдать сообщение об ошибках.

    {
        try {
            $db = new mysqli("localhost", "$bduser", "$bdpass", "$bdname");
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        try {
            $_SESSION['login'] = $_POST['login'];
            $_SESSION['password'] = $_POST['pass'];
            $login = $_SESSION['login'];
            $password = $_SESSION['password'];

            $query = "SET NAMES 'utf8'";
            $db->query($query);
            $query = "SELECT * FROM `authorization` WHERE `login` = '$login' and `password` = '$password'";
            $logform = $db->query($query);
        } catch (Exception $e) {
            setcookie('ex', "Проблема с доступом", time() + 24 * 60 * 60);
        }
        $db->close();
        if ($db->connect_error) {
            echo "Error Number: " . $db->connect_errno . "<br>";
            echo "Error: " . $db->connect_error;
        }
    }

    if (mysqli_num_rows($logform) > 0) {
        $row = mysqli_fetch_array($logform);
        // Если все ок, то авторизуем пользователя.
        $_SESSION['login'] = $_POST['login'];
        // Записываем ID пользователя.
        $_SESSION['uid'] = $row['id'];
        setcookie('wow', "Huray!!!", time() + 24 * 60);
        print("Совпадение найдено!");
    } else {
        $log = $logform['id'];
        setcookie('mes', "Совпадений логина и пароля не найдено!'$log'", time() + 24 * 60 * 60);
        $_SESSION['login'] = "";
        $_SESSION['password'] = "";
        header('Location: test.php');
    }
}
