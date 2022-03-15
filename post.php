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
$url_post_id = $_GET['url_post_id'] ?? NULL;
$posts_quantity = get_posts_quantity($con);
if ($url_post_id == NULL || $url_post_id > $posts_quantity) {
    $page_content = include_template('error.php',[]);
}
else {
    $post_details = get_post_details_from_db($con, $url_post_id);
    $likes_quantity = get_likes_quantity($con, $url_post_id);
    $comments = get_comments_for_post_details($con, $url_post_id);
    $hashtags = get_hashtags_for_post($con, $url_post_id);
    $user_details = get_user_for_post_details($con, $url_post_id);
    $subscribers_number = get_subscribers_number($con, $user_details[0]['id']);
    $publications_number = get_publications_number($con, $user_details[0]['id']);

//Шаблонизация

    $post_content = include_template('post-' . $post_details[0]['alias'] . '.php', ['post' => $post_details[0]]);

    $page_content = include_template('post_page.php', ['content' => $post_content, 'post' => $post_details[0], 'likes_quantity' => $likes_quantity, 'comments' => $comments, 'hashtags' => $hashtags, 'user' => $user_details[0], 'subscribers_number' => $subscribers_number, 'publications_number' => $publications_number, 'is_auth' => $is_auth, 'user_name' => $user_name]);
}
print($page_content);
?>
