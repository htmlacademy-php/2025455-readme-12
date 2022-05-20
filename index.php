<?php
require_once 'helpers.php';
require_once 'utils.php';
require_once 'source.php';

/**
 * @var $is_auth
 * @var $user_name
 */

//Параметры запроса
$contype_id = $_GET['contype_id'] ?? NULL;

//Posts DB
$posts = get_posts_from_db( 'view_count', 'DESC', 10, $contype_id);

//Types DB
$types = get_types_from_db();

//Шаблонизация
$button = include_template('header_readme/post_button.php',[]);

$js = include_template('js_dropzone_settings.php',[]);

$page_content = include_template('main.php', ['posts' => $posts, 'types' => $types, 'contype_id' => $contype_id]);

$layout_content = include_template('layout.php', ['title' => 'readme: полезное', 'is_auth' => $is_auth, 'user_name' => $user_name, 'content' => $page_content, 'button' => $button, 'modal_adding' => '', 'js' => $js]);

print($layout_content);
