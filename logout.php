<?php
session_destroy();
setcookie('PHPSESSID', '', 1000);
foreach ($_COOKIE as $key => $value) setcookie($key, '', 3600);
$_SERVER['PHP_AUTH_USER'] = '';
$_SERVER['PHP_AUTH_PW'] = '';
header('Location: index.php');
