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
  // Если есть логин в сессии, то пользователь уже авторизован.
  // TODO: Сделать выход (окончание сессии вызовом session_destroy()
  session_destroy();
  //при нажатии на кнопку Выход).
  // Делаем перенаправление на форму.
  header('Location: ./index.php');
}

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>
  <!DOCTYPE html>

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="css/style.css">
  </head>

  <body>
    <div class="container" style="
            background-color:dimgray;
            max-width: 400px;
            padding: 15px;
            margin: 10% auto;
            border-width: 2px;
            border-style: solid;
            border-radius: 15px;

        ">
      <div>
        <button type="button" class="btn btn-primary" style="max-width: 60px; max-height: 40px;"><a style="text-decoration: none; color: white;" href="./index.php">Back</a></button>
      </div>
      <form class="form_loginin" action="" method="post" style="padding: 10px;">
        <?php if (!empty($_COOKIE['mes'])) { ?> <div class="alert alert-danger" role="alert"><?php echo $_COOKIE['mes'] ?></div><?php } ?>
        <div class="mb-3">
          <label for="exampleInputUsername" class="form-label" style="font-size:20px;">Username</label>
          <input type="text" name="login" class="form-control" placeholder="Login" value="<?php if (!empty($_COOKIE['login'])) print $_COOKIE['login']; ?>">
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label" style="font-size:20px;">Password</label>
          <input type="password" name="pass" placeholder="Password" class="form-control" value="<?php if (!empty($_COOKIE['pass'])) print $_COOKIE['pass']; ?>">
        </div>
        <div class="text-center m-2">
          <button type="submit" class="btn btn-primary">Sign In</button>
        </div>
        <div class="text-center m-2">
          <button type="button" class="btn btn-primary"><a href="./admin.php" style="text-decoration: none; color: white;">Signin like admin</a></button>
        </div>
      </form>
    </div>
  </body>
<?php
}
// Иначе, если запрос был методом POST, т.е. нужно сделать авторизацию с записью логина в сессию.
else {

  // TODO: Проверть есть ли такой логин и пароль в базе данных.
  // Выдать сообщение об ошибках.

  {
    require('db_connect.php');      //  Подключаем скрипт.
    $login = $_POST['login'];
    $password = $_POST['pass'];
    $query = "SET NAMES 'utf8'";
    $result = mysqli_query($db, $query);
    $query = "SELECT * FROM authorization WHERE login = '$login'";
    $logform = mysqli_query($db, $query);
  }

  $row = mysqli_fetch_array($logform);
  if (mysqli_num_rows($logform) > 0 and $row['login'] = $_POST['login'] && password_verify($password, $row['password']) && preg_match('/^[\d]{1,255}+$/', $_POST['login']) && preg_match('/^[\d]{1,255}+$/', $_POST['pass'])) {
    // Если все ок, то авторизуем пользователя.
    $_SESSION['login'] = $_POST['login'];
    // Записываем ID пользователя.
    $_SESSION['uid'] = $row['id'];

    setcookie('mes', '', 10000);

    // Запускаем скрипт index.php заново.
    header('Location: index.php');
  } else {
    // Сообщаем об ошибке и перезапускаем эту страницу.
    setcookie('mes', "Совпадений логина и пароля не найдено!", time() + 24 * 60 * 60);
    header('Location: login.php');
  }
}
