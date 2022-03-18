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
