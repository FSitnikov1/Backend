<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
if (!empty($_GET['save'])){
    echo'<script>alert("Результаты сохранены!");</script>';
}
include('index.php');
exit();
}

$errors = FALSE;
if(empty($_POST['username'])){
    print('Заполните поле имя.<br/>');
    $errors = TRUE;
}
if(empty($_POST['email'])){
    print('Заполните поле E-mail.<br/>');
    $errors = TRUE;
}
if(empty($_POST['birthday'])){
    print('Выберите дату рождения.<br/>');
    $errors = TRUE;
}
if(empty($_POST['sex'])){
    print('Выберите пол.<br/>');
    $errors = TRUE;
}
if(empty($_POST['limbs'])){
    print('Выберите количество конечностей.<br/>');
    $errors = TRUE;
}
if(empty($_POST['superpowers'])){
    print('Выберите сверхспособности.<br/>');
    $errors = TRUE;
}
if(empty($_POST['biography'])){
    $_POST['biography']=" ";
}
if($errors){
    print('Попробуйте ещё раз.');
    exit();
}

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
$db->query("INSERT INTO `form` (`name`, `email`, `birthday`, `sex`, `limbs`, `biography`) VALUES ('$name', '$email', '$birthday', '$sex', '$limbs', '$biography')");
$db->query("INSERT INTO `super` (`superpowers`) VALUES ('$superpowers')");
$db->close();
if ($db->connect_error){
    echo "Error Number: ".$db->connect_errno."<br>";
    echo "Error: ".$db->connect_error;
}

header('Location: ?save=1');
?>
