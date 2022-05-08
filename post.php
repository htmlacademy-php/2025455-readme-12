<?php
require_once 'helpers.php';
require_once 'utils.php';
require_once 'source.php';

/**
 * @var $is_auth
 * @var $user_name
 */

//Параметры запроса
$id = $_GET['id'] ?? NULL;
$posts_quantity = get_posts_quantity();
if ($id == NULL || $id > $posts_quantity) {
    $page_content = include_template('error404.php',[]);
}
else {
    $post_details = get_post_details_from_db($id);
    $likes_quantity = get_likes_quantity($id);
    $comments = get_comments_for_post_details($id);
    $hashtags = get_hashtags_for_post($id);
    $user_details = get_user_for_post_details($id);
    $subscribers_number = get_subscribers_number($user_details[0]['id']);
    $publications_number = get_publications_number($user_details[0]['id']);

//Шаблонизация

    $button = include_template('header_readme/post_button.php',[]);

    $js = include_template('js_dropzone_settings.php',[]);

    $post_content = include_template(get_filename($post_details[0]['alias']), ['post' => $post_details[0]]);

    $main_content = include_template('post_page.php', ['content' => $post_content, 'post' => $post_details[0], 'likes_quantity' => $likes_quantity, 'comments' => $comments, 'hashtags' => $hashtags, 'user' => $user_details[0], 'subscribers_number' => $subscribers_number, 'publications_number' => $publications_number]);

    $page_content = include_template('layout.php', ['title' => 'readme: публикация', 'content' => $main_content, 'is_auth' => $is_auth, 'user_name' => $user_name, 'button' => $button, 'modal_adding' => '', 'js' => $js]);
}
print($page_content);
