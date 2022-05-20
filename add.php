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
    'photo-link-validation' => function() {
        if (empty($_FILES['userpic-file-photo']['tmp_name'])) {
            return validate_photo_link($_POST['photo-link']);
        }
        return false;
    },
    'userpic-file-photo' => function() {
        return validate_file_type('userpic-file-photo');
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
if (!empty($_POST['photo-link'])) {
    $_POST['photo-link-validation'] = $_POST['photo-link'];
}
if (!empty($_FILES['userpic-file-photo']['tmp_name'])) {
    $_POST['userpic-file-photo'] = 1;
}
//for video
if (!empty($_POST['video-link'])) {
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
        $new_post_result = add_new_post($rules,'heading', 'post-text', 'post-quote', 'quote-author', 'photo-link', 'userpic-file-photo','video-link', 'post-link', 'post-tags', $pubtype_id);
        if ($new_post_result !== false) {
            //3 ways to go
            header(get_link_after_form_submit($pubtype_id, $new_post_result));
        }
    }
}

console_log($_FILES);
if (isset($_GET['success'])) {
    $new_post_id = $_GET['new_post_id'];
    $modal = include_template('add_modal.php', compact('new_post_id'));
}

//DB
$types = get_types_from_db();

//Шаблонизация
$js = '';

$button = include_template('header_readme/close_button.php',[]);

$form_content = include_template(get_filename_for_form_content($pubtype_id),['pubtype_id' => $pubtype_id, 'errors' => $errors]);

$main_content = include_template('adding_post.php',['types' => $types, 'pubtype_id' => $pubtype_id, 'content' => $form_content]);

$page_content = include_template('layout.php',['title' => 'readme: добавление публикации', 'is_auth' => $is_auth, 'user_name' => $user_name, 'content' => $main_content, 'button' => $button, 'modal_adding' => $modal, 'js' => $js]);

print($page_content);

