<?php
date_default_timezone_set('Europe/Moscow');
$is_auth = rand(0, 1);
$user_name = 'Семенов Никита';

//DB
$con = mysqli_connect("127.0.0.1", "root", "", "2025455-readme-12");
if (!$con) {
    print("Ошибка подключения: " . mysqli_connect_error());
}
mysqli_set_charset($con, "utf8");
?>
