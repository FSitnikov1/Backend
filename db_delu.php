<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' || !preg_match('/^[\d]{1,255}+$/', $_POST['did'])) {
    header('Location: admin.php');
} else {
    $did = $_POST['did'];
    require_once 'db_connect.php';
    $query = "DELETE FROM form WHERE `form`.`id` = '$did'";
    $result = mysqli_query($db, $query);
    if ($result) {
        setcookie('mes', 'Пользователь не найден!', time() + 60 * 10);
        header('Location: admin.php');
    } else {
        setcookie('mes', 'Пользователь уcпешно удалён!', time() + 60 * 10);
        header('Location: admin.php');
    }
}
