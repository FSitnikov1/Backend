<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' || !preg_match('/^[\d]{1,255}+$/', $_POST['chid'])) {
    header('Location: admin.php');
} else {
    $chid = $_POST['chid'];
    require_once 'db_connect.php';
    $query = "SELECT * FROM authorization WHERE id ='$chid'";
    $result = mysqli_query($db, $query);
    $result = mysqli_fetch_row($result);
    if (empty($result)) {
        setcookie('mesch', 'Пользователь не найден!', time() + 60 * 10);
        header('Location: admin.php');
    } else {
        session_start();
        $_SESSION['login'] = $result[1];
        $_SESSION['uid'] = $result[0];
        header('Location: index.php');
    }
}
