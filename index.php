<?php
require_once 'helpers.php';
require_once 'uploads/utils.php';
date_default_timezone_set('Europe/Moscow');
$is_auth = rand(0, 1);
$user_name = 'Семенов Никита';

//DB
$con = mysqli_connect("127.0.0.1", "root", "", "2025455-readme-12");
if (!$con) {
    print("Ошибка подключения: " . mysqli_connect_error());
}
mysqli_set_charset($con, "utf8");

//Параметры запроса
$url_content_types_id = $_GET['url_content_types_id'] ?? NULL;

//Posts DB
$posts = get_posts_from_db($con, 'view_count', 'DESC', 6, $url_content_types_id);

//Types DB
$types = get_types_from_db($con);

//Шаблонизация
$page_content = include_template('main.php', ['posts' => $posts, 'types' => $types, 'url_content_types_id' => $url_content_types_id]);

$layout_content = include_template('layout.php', ['title' => 'readme: полезное', 'is_auth' => $is_auth, 'user_name' => $user_name, 'content' => $page_content]);

print($layout_content);

?>
