<?php

//  Отправляем браузеру кодировку
header('Content-Type: text/html; charset=UTF-8');
setlocale(LC_ALL, "ru_RU.UTF-8");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    //  Массив для хранения сообщений пользователю
    $messages = array();
    // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
    if (!empty($_COOKIE['save'])) {
        setcookie('save', '', time() + 24 * 60 * 60);
        $messages[] = 'Результаты были сохранены!';
    }
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
    /*
    if ($errors['biography']) {
        setcookie('biography_error', '', time() + 24 * 60 * 60);
        $messages[] = '<div class="error">Что-то пошло не так.</div>';
    }
    */
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
    $values['superpowers'] = empty($_COOKIE['superpowers_value']) ? '' : $_COOKIE['superpowers_value'];
    $values['biography'] = empty($_COOKIE['biography_value']) ? '' : $_COOKIE['biography_value'];
    $values['check'] = empty($_COOKIE['check_value']) ? '' : $_COOKIE['check_value'];

    //  Включаем файл form.php
    //  в него передаются переменные $messages, $errors, $values
    include('form.php');
} else {
    //  Если метод был POST
    //  Флаг для отлова ошибок полей
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
        if (!preg_match('/^\d+$/', $_POST['superpowers'])) {
            setcookie('superpowers_error', '2', time() + 24 * 60 * 60);
            $errors = TRUE;
        } else {
            $asup = $_POST['superpowers'];
            setcookie('superpowers_value', $_POST['superpowers'], time() + 31 * 24 * 60 * 60);
        }
    }
    /*
    if (empty($_POST['biography'])) {
        setcookie('biography_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {*/

    setcookie('biography_value', $_POST['biography'], time() + 31 * 24 * 60 * 60);
    /*
    }
    */
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
    //*************************

    $user = 'u46491';
    $pass = '2600028';

    try {
        $db = new mysqli("localhost", "u46491", "2600028", "u46491");
    } catch (PDOException $e) {
        die($e->getMessage());
    }

    $name = $_POST['username'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];
    $sex = $_POST['sex'];
    $limbs = $_POST['limbs'];
    $biography = $_POST['biography'];
    $superpowers = $_POST['superpowers'];



    $db->query("SET NAMES 'utf8'");
    $db->query("INSERT INTO `form` (`name`, `email`, `birthday`, `sex`, `limbs`, `biography`) VALUES ('$name', '$email', '$birthday', '$sex', '$limbs', '$biography');
    INSERT INTO `super` (`superpowers`) VALUES ('$superpowers');");
    $db->close();
    if ($db->connect_error) {
        echo "Error Number: " . $db->connect_errno . "<br>";
        echo "Error: " . $db->connect_error;
    }

    //*************************

    setcookie('save', '1');
    header('Location: index.php');
}
