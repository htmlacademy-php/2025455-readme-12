<?php
require_once 'helpers.php';
require_once 'utils.php';
require_once 'source.php';

/**
 * @var $is_auth
 * @var $user_name
 */

$modal = '';

//Параметры запроса
$pubtype_id = $_GET['pubtype_id'] ?? NULL;

//Раздел валидации

$errors = [];
$rules = [
    //for all forms

    //heading
    'heading' => function() {
        return validate_filled('heading', '"Заголовок"');
    },

    //tags
    'post-tags' => function() {
        return validate_tags('post-tags');
    },
    //for different ones

    //photo
    'photo-link' => function() {
        return validate_filled_string_and_file('photo-link', 'userpic-file-photo', '"Ссылка из интернета"', '"Выбрать фото"');
    },
    'photo-link-format' => function() {
        //if photo file doesn't exist =>
        return validate_url_format($_POST['photo-link']);
    },

    //video
    'video-link' => function() {

        return validate_filled('video-link', '"Ссылка YouTube"');
    },
    'video-format' => function() {
        return validate_url_format($_POST['video-link']);
    },
    'video-url' => function() {
        $valid = check_youtube_url($_POST['video-link']);
        return ($valid === true) ? false : $valid;
    },

    //text
    'post-text' => function() {
        return validate_filled('post-text', '"Текст поста"');
    },

    //quote
    'post-quote' => function() {
        return validate_filled('post-quote', '"Текст цитаты"');
    },
    'quote-author' => function() {
        return validate_filled('quote-author', '"Автор"');
    },

    //link
    'post-link' => function() {
        return validate_url_format($_POST['post-link']);
    }
];

//add extra ones / redefine post variables
//for photo
if (isset($_POST['photo-link'])) {
    $_POST['photo-link-format'] = $_POST['photo-link'];
}
//for video
if (isset($_POST['video-link'])) {
    $_POST['video-format'] = $_POST['video-link'];
    $_POST['video-url'] = $_POST['video-link'];
}

foreach ($_POST as $key => $value) {
    if (isset($rules[$key])) {
        $rule = $rules[$key];
        $errors[$key] = $rule();
    }
}

$errors = array_filter($errors);

//Redirect/not
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($errors)) {
        $new_post_result = add_new_post($rules,'heading', 'post-text', 'post-quote', 'quote-author', 'photo-link', 'video-link', 'post-link', 'post-tags', $pubtype_id);
        //$new_post_tags_result = add_tags_to_new_post('post-tags', $new_post_result);
        if ($new_post_result !== false) {
            //3 ways to go
            header(get_link_after_form_submit($pubtype_id));
            $file = 'new_post_info.php';
            // here goes update
            $content = $new_post_result;
            //write file
            file_put_contents($file, $content,  LOCK_EX);
        }
    }
}
console_log($_FILES);
if (isset($_GET['success'])) {
    $file = 'new_post_info.php';
    $content = file_get_contents($file);
    $new_post_id = intval($content);
    $modal = include_template('add_modal.php', compact('new_post_id'));
}

//DB
$types = get_types_from_db();

//Шаблонизация

$button = include_template('header_readme/close_button.php',[]);

$form_content = include_template(get_filename_for_form_content($pubtype_id),['pubtype_id' => $pubtype_id, 'errors' => $errors]);

$main_content = include_template('adding_post.php',['types' => $types, 'pubtype_id' => $pubtype_id, 'content' => $form_content]);

$page_content = include_template('layout.php',['title' => 'readme: добавление публикации', 'is_auth' => $is_auth, 'user_name' => $user_name, 'content' => $main_content, 'button' => $button, 'modal_adding' => $modal, 'js' => '']);

print($page_content);

