<?php

//  Отправляем браузеру кодировку
header('Content-Type: text/html; charset=UTF-8');
setlocale(LC_ALL, "ru_RU.UTF-8");

$debug = array();     // Массив для отлова ошибок

//  ****    Валидация, сохранения сообщений об ошибках, запись в значений поля
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    //  Массив для хранения сообщений пользователю
    $messages = array();
    // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
    // ****************************
    //  Выдача сообщения об успешном сохранении
    //  Если в куках есть пароль, то предлагаем войти
    // ****************************
    {
        if (!empty($_COOKIE['save'])) {
            setcookie('save', '', time() + 100000);
            setcookie('login', '', 100000);
            setcookie('pass', '', 100000);
            if (!empty($_SESSION['login'])) {
                $messages[] = $_SESSION['login'];
                $messages[] = $_SESSION['password'];
                $messages[] = 'Вы успешно вошли!';
            }
            $messages[] = 'Результаты были сохранены!';
            // Если в куках есть пароль, то выводим сообщение.
            if (!empty($_COOKIE['pass'])) {
                $messages[] = sprintf(
                    '<div>Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong> и паролем <strong>%s</strong> для изменения данных.</div>',
                    strip_tags($_COOKIE['login']),
                    strip_tags($_COOKIE['pass'])
                );
            }
        }
    }
    // ****************************
    // Проверка куки на пустоту
    // Если не пусто, то достаём данные полей из куки
    // ****************************
    {
        //  Массив для хранения ошибок
        $errors = array();
        $errors['fio'] = !empty($_COOKIE['fio_error']);
        $errors['email'] = !empty($_COOKIE['email_error']);
        $errors['birthday'] = !empty($_COOKIE['birthday_error']);
        $errors['sex'] = !empty($_COOKIE['sex_error']);
        $errors['limbs'] = !empty($_COOKIE['limbs_error']);
        $errors['superpowers'] = !empty($_COOKIE['superpowers_error']);
        $errors['biography'] = !empty($_COOKIE['biography_error']);
        $errors['check'] = !empty($_COOKIE['check_error']);

        //  Сообщения об ошибках
        if ($errors['fio']) {
            setcookie('fio_error', '', time() + 24 * 60 * 60);
            $messages[] = '<div class="error">Введите ФИО.</div>';
        }
        if ($errors['email']) {
            setcookie('email_error', '', time() + 24 * 60 * 60);
            $messages[] = '<div class="error">Введите email.</div>';
        }
        if ($errors['birthday']) {
            setcookie('birthday_error', '', time() + 24 * 60 * 60);
            $messages[] = '<div class="error">Выберите дату рождения.</div>';
        }
        if ($errors['sex']) {
            setcookie('sex_error', '', time() + 24 * 60 * 60);
            $messages[] = '<div class="error">Выберите пол.</div>';
        }
        if ($errors['limbs']) {
            setcookie('limbs_error', '', time() + 24 * 60 * 60);
            $messages[] = '<div class="error">Выберите кол-во конечностей.</div>';
        }
        if ($errors['superpowers']) {
            setcookie('superpowers_error', '', time() + 24 * 60 * 60);
            $messages[] = '<div class="error">Выберите суперсилы.</div>';
        }
        if ($errors['biography']) {
            setcookie('biography_error', '', time() + 24 * 60 * 60);
            $messages[] = '<div class="error">Неверные символы, допустимы (А-Я,A-Z,0-1,-,_).</div>';
        }
        if ($errors['check']) {
            setcookie('check_error', '', time() + 24 * 60 * 60);
            $messages[] = '<div class="error">Согласитесь с условиями.</div>';
        }

        //  Сохраняем значения полей в массив
        $values = array();
        $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
        $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
        $values['birthday'] = empty($_COOKIE['birthday_value']) ? '' : $_COOKIE['birthday_value'];
        $values['sex'] = empty($_COOKIE['sex_value']) ? '' : $_COOKIE['sex_value'];
        $values['limbs'] = empty($_COOKIE['limbs_value']) ? '' : $_COOKIE['limbs_value'];
        $values['superpowers_imm'] = empty($_COOKIE['superpowers_value_imm']) ? '' : $_COOKIE['superpowers_value_imm'];
        $values['superpowers_ptw'] = empty($_COOKIE['superpowers_value_ptw']) ? '' : $_COOKIE['superpowers_value_ptw'];
        $values['superpowers_lev'] = empty($_COOKIE['superpowers_value_lev']) ? '' : $_COOKIE['superpowers_value_lev'];
        $values['biography'] = empty($_COOKIE['biography_value']) ? '' : $_COOKIE['biography_value'];
        $values['check'] = empty($_COOKIE['check_value']) ? '' : $_COOKIE['check_value'];
    }
    // ****************************
    // Если нет предыдущих ошибок ввода, есть кука сессии, начали сессию и
    // ранее в сессию записан факт успешного логина, то загружаем данные пользователя из бд.
    // ****************************
    {
        if (!empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['login'])) {

            // TODO: загрузить данные пользователя из БД
            //*************************
            $login = $_SESSION['login'];
            require('db_connect.php');      //  Подключаем скрипт.
            $query = "SET NAMES 'utf8'";
            $result = mysqli_query($db, $query);
            $query = "SELECT * FROM authorization WHERE login = '$login'";
            $data = mysqli_query($db, $query);
            $row = mysqli_fetch_array($data);
            if (mysqli_num_rows($data) > 0 and $row['login'] = $login) {
                $uid = $row['id'];
                $query = "SELECT * FROM form WHERE id = '$uid'";
                $uidform = mysqli_query($db, $query);
                $query = "SELECT * FROM super WHERE id = '$uid'";
                $uidsuper = mysqli_query($db, $query);
                $row = mysqli_fetch_array($uidform);
                $values['fio'] = $row['name'];
                $values['email'] = $row['email'];
                $values['birthday'] = $row['birthday'];
                $values['sex'] = $row['sex'];
                $values['limbs'] = $row['limbs'];
                $values['biography'] = $row['biography'];

                $row = mysqli_fetch_array($uidsuper);
                $values['superpowers_imm'] = $row['immortal'];
                $values['superpowers_ptw'] = $row['ptw'];
                $values['superpowers_lev'] = $row['levitation'];
            } else {

                setcookie('db_data_could_not-be_retrieved', '1', time() + 60 * 60);
            }
            // и заполнить переменную $values,
            // предварительно санитизовав.
            printf('!!! Вход с логином %s, uid %d', $_SESSION['login'], $_SESSION['uid']);
        }
    }

    //  Включаем файл form.php
    //  в него передаются переменные $messages, $errors, $values
    include('form.php');
}
//  **** Если метод был POST
else {
    // ****************************
    // Валидация полей 
    // Если есть ошибки, то перезагружаем страницу
    // Иначе обнуляем куки об ошибках
    // ****************************
    {
        $errors = FALSE;
        if (empty($_POST['fio'])) {
            setcookie('fio_error', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        } else {
            if (!preg_match('/^[a-zA-Zа-яёА-ЯЁ\s\-]+$/u', $_POST['fio'])) {
                setcookie('fio_error', '2', time() + 24 * 60 * 60);
                $errors = TRUE;
            } else {
                setcookie('fio_value', $_POST['fio'], time() + 31 * 24 * 60 * 60);
            }
        }
        if (empty($_POST['email'])) {
            setcookie('email_error', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        } else {
            if (!preg_match('/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/', $_POST['email'])) {
                setcookie('email_error', '2', time() + 24 * 60 * 60);
                $errors = TRUE;
            } else {
                setcookie('email_value', $_POST['email'], time() + 31 * 24 * 60 * 60);
            }
        }
        if (empty($_POST['birthday'])) {
            setcookie('birthday_error', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        } else {
            if (!preg_match('/^[1-2][0|9|8][0-9][0-9]-[0-1][0-9]-[0-3][0-9]+$/', $_POST['birthday'])) {
                setcookie('birthday_error', '2', time() + 24 * 60 * 60);
                $errors = TRUE;
            } else {
                setcookie('birthday_value', $_POST['birthday'], time() + 31 * 24 * 60 * 60);
            }
        }
        if (empty($_POST['sex'])) {
            setcookie('sex_error', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        } else {
            if (!preg_match('/^\d+$/', $_POST['sex'])) {
                setcookie('sex_error', '2', time() + 24 * 60 * 60);
                $errors = TRUE;
            } else {
                setcookie('sex_value', $_POST['sex'], time() + 31 * 24 * 60 * 60);
            }
        }
        if (empty($_POST['limbs'])) {
            setcookie('limbs_error', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        } else {
            if (!preg_match('/^\d+$/', $_POST['limbs'])) {
                setcookie('limbs_error', '2', time() + 24 * 60 * 60);
                $errors = TRUE;
            } else {
                setcookie('limbs_value', $_POST['limbs'], time() + 31 * 24 * 60 * 60);
            }
        }
        if (empty($_POST['superpowers'])) {
            setcookie('superpowers_error', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        } else {
            $sup = $_POST['superpowers'];
            for ($a = 0; $a < count($sup); $a++) {
                if (!preg_match('/^\d+$/', $sup[$a])) {
                    setcookie('superpowers_error', '2', time() + 24 * 60 * 60);
                    $errors = TRUE;
                } else {
                    if ($sup[$a] == 1) {
                        setcookie('superpowers_value_imm', '1', time() + 31 * 24 * 60 * 60);
                    } else {
                        if ($sup[$a] == 2) {
                            setcookie('superpowers_value_ptw', '1', time() + 31 * 24 * 60 * 60);
                        } else {
                            setcookie('superpowers_value_lev', '1', time() + 31 * 24 * 60 * 60);
                        }
                    }
                }
            }
        }
        if (empty($_POST['check'])) {
            setcookie('check_error', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        } else {
            if (!preg_match('/^\d+$/', $_POST['check'])) {
                setcookie('check_error', '2', time() + 24 * 60 * 60);
                $errors = TRUE;
            } else {
                setcookie('check_value', $_POST['check'], time() + 31 * 24 * 60 * 60);
            }
        }
        if (empty($_POST['biography'])) {
            setcookie('biography_value', '', time() + 31 * 24 * 60 * 60);
        } else {
            if (!preg_match('/^[a-zA-Zа-яёА-ЯЁ0-9-_]{2,255}+$/u', $_POST['biography'])) {
                setcookie('biography_error', '2', time() + 24 * 60 * 60);
                $errors = TRUE;
            } else {
                setcookie('biography_value', $_POST['biography'], time() + 31 * 24 * 60 * 60);
            }
        }

        if ($errors) {
            header('Location: index.php');
            exit();
        } else {
            setcookie('fio_error', '', 100000);
            setcookie('email_error', '', 100000);
            setcookie('birthday_error', '', 100000);
            setcookie('sex_error', '', 100000);
            setcookie('limbs_error', '', 100000);
            setcookie('superpowers_error', '', 100000);
            setcookie('biography_error', '', 100000);
            setcookie('check_error', '', 100000);
        }
    }

    // Проверяем меняются ли ранее сохраненные данные или отправляются новые.

    if (!empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['login'])) {
        // ****************************
        // Если пользователь вошёл, то перезаписываем данные в бд
        // ****************************
        {
            // TODO: перезаписать данные в БД новыми данными
            $login = $_SESSION['login'];
            $fio = $_POST['fio'];
            $email = $_POST['email'];
            $birthday = $_POST['birthday'];
            $sex = $_POST['sex'];
            $limbs = $_POST['limbs'];
            $biography = $_POST['biography'];
            $sup_imm = 0;
            $sup_ptw = 0;
            $sup_lev = 0;
            $sup = $_POST['superpowers'];
            for ($a = 0; $a < count($sup); $a++) {
                if ($sup[$a] == 1) {
                    $sup_imm = '1';
                } else {
                    if ($sup[$a] == 2) {
                        $sup_ptw = '1';
                    } else {
                        if ($sup[$a] == 3) {
                            $sup_lev = '1';
                        }
                    }
                }
            }

            require('db_connect.php');      //  Подключаем скрипт.
            $query = "SET NAMES 'utf8'";
            $result = mysqli_query($db, $query);
            $query = "SELECT * FROM authorization WHERE login = '$login'";
            $data = mysqli_query($db, $query);
            $row = mysqli_fetch_array($data);
            if (mysqli_num_rows($data) > 0 and $row['login'] = $login) {
                $uid = $row['id'];
                $query = "UPDATE form SET name = '$fio', email = '$email', birthday = '$birthday', sex = '$sex', limbs = '$limbs', biography = '$biography' WHERE id = '$uid'";
                $result = mysqli_query($db, $query);
                $query = "UPDATE super SET immortal = '$sup_imm', ptw = '$sup_ptw', levitation = '$sup_lev' WHERE id = '$uid'";
                $result = mysqli_query($db, $query);
            } else {
                //  Если в базе данных не найден такой пользователь, то сохраняем ошибку.
                setcookie('db_overwriting_error', '1', time() + 60 * 60);
            }
        }
    } else {
        // ****************************
        // Создание нового пользователя и сохранение данных в бд
        // ****************************
        {
            // Генерируем уникальный логин и пароль.
            // TODO: сделать механизм генерации, например функциями rand(), uniquid(), md5(), substr().
            $debug[] = 'Инициализированна генерация лог и пар, сохранение логина и пароля в бд';
            $login = rand(1000, 9000);
            $pass = rand(100000, 900000);
            // Сохраняем в Cookies.
            setcookie('login', $login, time() + 60);
            setcookie('pass', $pass, time() + 60);
            $pass = password_hash($pass, PASSWORD_DEFAULT);

            // TODO: Сохранение данных формы, логина и хеш md5() пароля в базу данных.
            $name = $_POST['fio'];
            $email = $_POST['email'];
            $birthday = $_POST['birthday'];
            $sex = $_POST['sex'];
            $limbs = $_POST['limbs'];
            $biography = $_POST['biography'];
            $superpowers = $_POST['superpowers'];
            $sup_imm = 0;
            $sup_ptw = 0;
            $sup_lev = 0;
            $sup = $_POST['superpowers'];
            for ($a = 0; $a < count($sup); $a++) {
                if ($sup[$a] == 1) {
                    $sup_imm = 1;
                } else {
                    if ($sup[$a] == 2) {
                        $sup_ptw = 1;
                    } else {
                        if ($sup[$a] == 3) {
                            $sup_lev = 1;
                        }
                    }
                }
            }

            require('db_connect.php');      //  Подключаем скрипт.
            $query = "SET NAMES 'utf8'";
            $result = mysqli_query($db, $query);
            $query = "INSERT INTO form (name, email, birthday, sex, limbs, biography) VALUES ('$name', '$email', '$birthday', '$sex', '$limbs', '$biography')";
            $result = mysqli_query($db, $query);
            $query = "INSERT INTO super (immortal, ptw, levitation) VALUES ('$sup_imm', '$sup_ptw', '$sup_lev')";
            $result = mysqli_query($db, $query);
            $query = "INSERT INTO authorization (login, password) VALUES ('$login', '$pass')";
            $result = mysqli_query($db, $query);
        }
    }

    setcookie('save', '1');
    header('Location: index.php');
}
