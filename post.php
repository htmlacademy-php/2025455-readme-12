<?php
require_once 'helpers.php';
require_once 'uploads/utils.php';
require_once 'source.php';

/**
 * @var $con
 * @var $is_auth
 * @var $user_name
 */

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

    $main_content = include_template('post_page.php', ['content' => $post_content, 'post' => $post_details[0], 'likes_quantity' => $likes_quantity, 'comments' => $comments, 'hashtags' => $hashtags, 'user' => $user_details[0], 'subscribers_number' => $subscribers_number, 'publications_number' => $publications_number]);

    $page_content = include_template('layout.php', ['title' => 'readme: публикация', 'content' => $main_content, 'is_auth' => $is_auth, 'user_name' => $user_name]);
}
print($page_content);
?>
