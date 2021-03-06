<?php

/**
 * Функция, обрезающая содержимое текстового контента по заданному кол-ву симловов
 * @param string $text
 * @param int $quantity
 * @return mixed|string Урезанный текст и ссылка на продолжение
 */
function text_cut($text, $quantity = 300) {

    $start_length = iconv_strlen($text);
    $process_length = 0;
    $count = 0;

    if ($start_length <= $quantity) {
        $new_text = $text;
    }
    else {
        $words = explode(" ",  $text);

        while ($process_length <= $quantity) {
            $word_length = iconv_strlen($words[$count]);
            $process_length = $process_length + $word_length + 1;//+ 1 учитывает символ пробела после каждого слова
            $count = $count + 1;
        }

        $count = $count - 2 + 1;
        $new_words = array_slice($words, 0, $count, false);
        $new_text = implode(" ", $new_words);
        $new_text .= "...";
    }

    return $new_text;
}


/**
 * Функция работы с относительной датой постов
 * @param mixed $date_str
 * @return array Отформатированная дата, относительная дата
 */
function post_date($date_str, $back): array {

    $date = date_create($date_str); //datetime object
    $date_format_str = date_format($date, 'Y-m-d H:i'); //string
    $cur_date = date_create('now'); //datetime object

    $diff = date_diff($date, $cur_date);   //datetime object
    //string, could be used like int
    $diff_count_i = date_interval_format($diff, "%i");
    $diff_count_h = date_interval_format($diff, "%h");
    $diff_count_d = date_interval_format($diff, "%d");
    $diff_count_m = date_interval_format($diff, "%m");
    $rel_date = 0;

    if ($diff_count_i > 0 && $diff_count_i  < 60) {
        $rel_date = $diff_count_i . get_noun_plural_form($diff_count_i, ' минута ', ' минуты ', ' минут ') . $back;
    }
    if ($diff_count_h >= 1 && $diff_count_h  < 24) {
        $rel_date = $diff_count_h . get_noun_plural_form($diff_count_h, ' час ', ' часа ', ' часов ') . $back;
    }
    if ($diff_count_d >= 1 && $diff_count_d < 7) {
        $rel_date = $diff_count_d . get_noun_plural_form($diff_count_d, ' день ', ' дня ', ' дней ') . $back;
    }
    if ($diff_count_d >= 7 && $diff_count_d < 30) {
        $rel_date = floor($diff_count_d / 7) . get_noun_plural_form(floor($diff_count_d / 7), ' неделю ', ' недели ', ' недель ') . $back;
    }
    if ($diff_count_m == 1 && $diff_count_d < 5) {
        $rel_date = floor((intval($diff_count_d) + 30) / 7) . get_noun_plural_form(floor((intval($diff_count_d) + 30) / 7), ' неделю ', ' недели ', ' недель ') . $back;
    }
    if ($diff_count_m == 1 && $diff_count_d >= 5) {
        $rel_date = $diff_count_m . get_noun_plural_form($diff_count_m, ' месяц ', ' месяца ', ' месяцев ') . $back;
    }
    if ($diff_count_m > 1) {
        $rel_date = $diff_count_m . get_noun_plural_form($diff_count_m, ' месяц ', ' месяца ', ' месяцев ') . $back;
    }
    return [$date_format_str, $rel_date];
}

/**
 * Функция, получающая из бд массив c данными по строке запроса
 * @param $sql_query
 * @return array Ассоциативный массив с данными из БД
 */
function get_db($sql_query): array {
    //$result = $sql_query->get_result();
    $result = mysqli_query(require 'db.php', $sql_query);
    $array = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return($array);
}

/**
 * Функция для показа постов
 * @param string $sorting
 * @param string $sort_type
 * @param int $limit
 * @param int $filter_id
 * @return array Массив типов контента из базы данных
 */
function get_posts_from_db($sorting, $sort_type, $limit, $filter_id): array {
    if ($filter_id != NULL) {
    $query = sprintf("SELECT posts.id, users.login, users.avatar, content_types.type_title, content_types.alias, creation_date, posts.title, text, quote_author, img, video, link, view_count, user_id, content_types_id
FROM posts
INNER JOIN content_types ON posts.content_types_id = content_types.id
INNER JOIN users ON posts.user_id = users.id
WHERE content_types.id = %d
ORDER BY %s %s LIMIT %d",  $filter_id, $sorting, $sort_type, $limit);
    }
    else {
    $query = sprintf("SELECT posts.id, users.login, users.avatar, content_types.type_title, content_types.alias, creation_date, posts.title, text, quote_author, img, video, link, view_count, user_id, content_types_id
FROM posts
INNER JOIN content_types ON posts.content_types_id = content_types.id
INNER JOIN users ON posts.user_id = users.id
ORDER BY %s %s LIMIT %d", $sorting, $sort_type, $limit);
    }
    $array = get_db($query);

    return($array);
}

/**
 * Функция для показа типов контента
 * @return array Массив типов контента из базы данных
 */
function get_types_from_db(): array {
    $query = "SELECT type_title, class_icon, alias FROM content_types";
    $array = get_db($query);

    return($array);
}

/**
 * @param int $filter_id
 * @return array Данные о посте
 */
function get_post_details_from_db($filter_id): array {
    $query = sprintf("SELECT posts.id, content_types.alias, posts.title, text, quote_author, img, video, link, view_count, user_id, content_types_id
FROM posts
INNER JOIN content_types ON posts.content_types_id = content_types.id
WHERE posts.id = %d",  $filter_id);
    $array = get_db($query);

    return($array);
}

/**
 * @param $filter_id
 * @return int
 */
function get_likes_quantity($filter_id): int {
    $query = sprintf("SELECT l.id, l.user_id, l.post_id
FROM likes l
INNER JOIN posts p ON l.post_id = p.id
WHERE p.id = %d", $filter_id);
    $array = get_db($query);
    $likes_quantity = count($array);
    return($likes_quantity);
}

/**
 * @param $filter_id
 * @return array
 */
function get_hashtags_for_post($filter_id): array {
    $query = sprintf("SELECT h.hashtag_title
FROM posts p
INNER JOIN posts_hashtags ph ON p.id = ph.post_id
INNER JOIN hashtags h ON ph.hashtag_id = h.id
WHERE p.id = %d", $filter_id);
    $array = get_db($query);

    return($array);
}

/**
 * @param $filter_id
 * @return array
 */
function get_comments_for_post_details($filter_id): array {
    $query = sprintf("SELECT p.id, u.login, u.avatar, c.comment_creation_date, content, c.user_id, post_id
FROM comments c
INNER JOIN users u ON c.user_id = u.id
INNER JOIN posts p ON c.post_id = p.id
WHERE p.id = %d", $filter_id);
    $array = get_db($query);

    return($array);
}

/**
 * @param $filter_id
 * @return array
 */
function get_user_for_post_details($filter_id): array {
    $query = sprintf("SELECT p.id, u.id, u.login, u.avatar, u.registration_date
FROM posts p
INNER JOIN users u ON p.user_id = u.id
WHERE p.id = %d", $filter_id);
    $array = get_db($query);

    return($array);
}

/**
 * @param $filter_id
 * @return int
 */
function get_subscribers_number($filter_id): int {
    $query = sprintf("SELECT s.id, s.author_user_id, s.subscribed_user_id
FROM subscriptions s
INNER JOIN users u ON s.subscribed_user_id = u.id
WHERE u.id = %d", $filter_id);
    $array = get_db($query);
    $subscribers_number = count($array);
    return($subscribers_number);
}

/**
 * @param $filter_id
 * @return int
 */
function get_publications_number($filter_id): int {
    $query = sprintf("SELECT p.id, p.user_id, u.id
FROM posts p
INNER JOIN users u ON p.user_id = u.id
WHERE u.id = %d", $filter_id);
    $array = get_db($query);
    $posts_number = count($array);
    return($posts_number);
}

/**
 * @return int
 */
function get_posts_quantity(): int {
    $query = "SELECT id FROM posts";
    $array = get_db($query);
    $posts_quantity = count($array);
    return($posts_quantity);
}

/**
 * Функция, определяющая класс по алиасу
 * @param string $alias
 * @return string Класс оформления для поста
 */
function get_post_css_class($alias): string {

    switch ($alias !== '') {
        case ($alias === 'photo'):
            return 'post-photo';
        case ($alias === 'video'):
            return 'post-video';
        case ($alias === 'text'):
            return 'post-text';
        case ($alias === 'quote'):
            return 'post-quote';
        case ($alias === 'link'):
            return 'post-link';
        default:
            return '';
    }
}

/**
 * @param string $type_alias
 * @return string CSS класс для кнопки
 */
function get_button_css_class($type_alias): string {
    switch ($type_alias !== '') {
        case ($type_alias === 'photo'):
            $filters__button = 'filters__button--photo';
            break;
        case ($type_alias === 'video'):
            $filters__button = 'filters__button--video';
            break;
        case ($type_alias === 'text'):
            $filters__button = 'filters__button--text';
            break;
        case ($type_alias === 'quote'):
            $filters__button = 'filters__button--quote';
            break;
        case ($type_alias === 'link'):
            $filters__button = 'filters__button--link';
            break;
        default:
            $filters__button = '';
    }

    return $filters__button;
}

/**
 * @param string $type_alias
 * @return string значение для xlink
 */
function get_button_icon_url($type_alias): string {
    switch ($type_alias !== '') {
        case ($type_alias === 'photo'):
            $icon_url = '#icon-filter-photo';
            break;
        case ($type_alias === 'video'):
            $icon_url = '#icon-filter-video';
            break;
        case ($type_alias === 'text'):
            $icon_url = '#icon-filter-text';
            break;
        case ($type_alias === 'quote'):
            $icon_url = '#icon-filter-quote';
            break;
        case ($type_alias === 'link'):
            $icon_url = '#icon-filter-link';
            break;
        default:
            $icon_url = '';
    }

    return $icon_url;
}

/**
 * @param string $type_alias
 * @return int параметр id для этого типа контента
 */
function get_id_for_content_type($type_alias): int {
    switch ($type_alias !== '') {
        case ($type_alias === 'photo'):
            $id = 1;
            break;
        case ($type_alias === 'video'):
            $id = 2;
            break;
        case ($type_alias === 'text'):
            $id = 3;
            break;
        case ($type_alias === 'quote'):
            $id = 4;
            break;
        case ($type_alias === 'link'):
            $id = 5;
            break;
        default:
            $id = 0;
    }

    return $id;
}

/**
 * @param int $url_id
 * @param int $type_id
 * @return string CSS класс для кнопки
 */
function is_button_active($url_id, $type_id): string {
    $button_active = '';
    if ($url_id == $type_id) {
        $button_active = 'filters__button--active';
    }
    return $button_active;
}

/**
 * @param $type_id
 * @return string ссылка для кнопок типа контента
 */
function get_link_for_type_button($type_id): string {
    return sprintf('index.php?content_type_id=%d',$type_id);
}

/**
 * @param $post_id
 * @return string
 */
function get_link_for_post($post_id): string {
    return sprintf('post.php?id=%d',$post_id);
}

/**
 * @param $alias
 * @return string
 */
function get_filename($alias): string {
    return sprintf('post/%s.php', $alias);
}

/**
 * @param $type_id
 * @return string ссылка для кнопок типа контента в форме публикации поста
 */
function get_link_for_form_type_button($type_id): string {
    return sprintf('add.php?publication_type_id=%d',$type_id);
}

/**
 * @param $id
 * @return string
 */
function get_filename_for_form_content($id): string {
    $alias = '';
    switch (true) {
        case ($id == 1):
            $alias = 'photo';
            break;
        case ($id == 2):
            $alias = 'video';
            break;
        case ($id == 3):
            $alias = 'text';
            break;
        case ($id == 4):
            $alias = 'quote';
            break;
        case ($id == 5):
            $alias = 'link';
            break;
    }

    return sprintf('add_post/%s_type.php', $alias);
}

/**
 * @param $publication_type_id
 * @param $new_post_id
 * @return string
 */
function get_link_after_form_submit($publication_type_id, $new_post_id): string {
    return sprintf("Location: ../add.php?publication_type_id=%d&success=true&new_post_id=%d", $publication_type_id, $new_post_id);
}

/**
 * @param $new_post_id
 * @return string ссылка для нового поста
 */
function get_link_for_new_post($new_post_id): string {
    return sprintf('../post.php?id=%d',$new_post_id);
}

/**
 * @param $name
 * @return mixed|string
 */
function get_post_val($name) {
    return $_POST[$name] ?? "";
}

/**
 * @param $name
 * @param $ru_name
 * @return string|bool
 */
function validate_filled($name, $ru_name) {
    if (empty($_POST[$name])) {
        return sprintf("Поле %s должно быть заполнено", $ru_name);
    }
    return false;
}

/**
 * @param $field_name
 * @param $file_field
 * @param $ru_name_first
 * @param $ru_name_second
 * @return false|string
 */
function validate_filled_string_and_file($field_name, $file_field,  $ru_name_first, $ru_name_second) {
    if (empty($_POST[$field_name]) && empty($_FILES[$file_field]['tmp_name'])) {
        return sprintf("Хотя бы одно из полей: %s, %s - должно быть заполнено", $ru_name_first, $ru_name_second);
    }
    return false;
}

/**
 * @param $url
 * @return false|string
 */
function validate_url_format($url) {
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return 'Некорректная ссылка';
    }
    return false;
}

/**
 * @param $file_field_name
 * @return false|string
 */
function validate_file_type($file_field_name) {
    if (isset($_FILES[$file_field_name])) {
        $file_info = finfo_open(FILEINFO_MIME_TYPE);
        $file_name = $_FILES[$file_field_name]['tmp_name'];

        $file_type = finfo_file($file_info, $file_name);

        if (($file_type !== 'image/png') && ($file_type !== 'image/jpeg') && ($file_type !== 'image/gif')) {
            return 'Загрузите картинку в формате gif/png/jpeg';
        }
    }
    return false;
}

/**
 * @param $url
 * @return false|string
 */
function validate_photo_link($url) {
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return 'Некорректная ссылка';
    }
    if (file_get_contents($url) === false) {
        return 'Не удалось загрузить файл. Проверьте текущую ссылку или используйте другую';
    }
    return false;
}

/**
 * @param $tags_field_name
 * @return false|string
 */
function validate_tags($tags_field_name) {
    if (empty($_POST[$tags_field_name]) || (substr($_POST[$tags_field_name], 0, 1) === ' ' && empty(trim($_POST[$tags_field_name])))) {
        return 'Поле "Теги" должно содержать одно или больше слов';
    }
    if (strpos($_POST[$tags_field_name], '  ') !== false ) {
        return 'Уберите лишние пробелы в поле "Теги". <br> Теги должны быть разделены одним пробелом';
    }
    //filter_input
    return false;
}

/**
 * @param $tmp_name
 * @param $name
 * @return mixed
 */
function upload_photo_file($tmp_name, $name) {
    $file_name = $name;
    $file_path = __DIR__ . '/uploads/';
    move_uploaded_file($tmp_name, $file_path . $file_name);

    return $file_name;
}

/**
 * @param $photo_link
 * @return false|string
 */
function upload_by_photo_link($photo_link) {
    $img = file_get_contents($photo_link);
    $file = sprintf('uploads/%s.jpg', substr($photo_link, -13, 8));
    file_put_contents($file, $img, LOCK_EX);

    return substr($file, 8);
}

/**
 * @param $tags
 * @param $con
 * @param $post_id
 * @return boolean
 */
function add_tags_to_new_post($tags, $con, $post_id): bool {
    foreach ($tags as $tag) {
        // count tags
        $quantity = count(get_db("SELECT hashtag_title FROM hashtags"));
        // add new tag
        $sql_add_hashtags = "INSERT INTO hashtags (hashtag_title) VALUES (?)";
        $stmt = mysqli_prepare($con, $sql_add_hashtags);
        mysqli_stmt_bind_param($stmt, 's', $tag);
        mysqli_stmt_execute($stmt);
        $hashtag_id = mysqli_insert_id($con);
        // count again
        $quantity_after_add = count(get_db("SELECT hashtag_title FROM hashtags"));
        // if tag wasn't new
        if ($quantity_after_add == $quantity) {
            $sql_get_tag_id = "SELECT id FROM hashtags WHERE hashtag_title = '$tag'";
            $array_get_tag_id = get_db($sql_get_tag_id);
            $hashtag_id = intval($array_get_tag_id[0]['id']);
        }
        // connecting to created post
        $sql_posts_hashtags = "INSERT INTO posts_hashtags (post_id, hashtag_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($con, $sql_posts_hashtags);
        mysqli_stmt_bind_param($stmt, 'ii', $post_id, $hashtag_id);
        mysqli_stmt_execute($stmt);
    }

    if (count(get_hashtags_for_post($post_id)) != 0) {
        return true;
    }
    return false;
}

/**
 * @param $rules
 * @param $content_type_id
 * @return false|int|string
 */
function add_new_post($rules, $content_type_id) {
    // date
    $date = date_create('now'); //datetime object
    $creation_date = date_format($date, 'Y-m-d H:i:s'); //string
    // text
    if (empty($_POST['post-text'])) {
        $_POST['post-text'] = $_POST['post-quote'];
    }
    // photo
    $file_name = '';
    if (empty($_POST['userpic-file-photo']) && isset($_POST['photo-link'])) {
        $file_name = upload_by_photo_link($_POST['photo-link']);
    }
    else {
        $file_name = upload_photo_file($_FILES['userpic-file-photo']['tmp_name'], $_FILES['userpic-file-photo']['name']);
    }
    // checking the existence of fields
    foreach ($rules as $key => $value) {
        if (empty($_POST[$key])) {
            unset($_POST[$key]);
        }
    }
    // add post
    $con = require_once 'db.php';
    //variables for stmt
    $heading = $_POST['heading'];
    $post_text = $_POST['post-text'];
    $quote_author = $_POST['quote-author'];
    $video_link = $_POST['video-link'];
    $post_link = $_POST['post-link'];
    $view_count = 15;
    $user_id = 1;

    $sql = "INSERT INTO posts (creation_date, title, text, quote_author, img, video, link, view_count, user_id, content_types_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'sssssssiii', $creation_date, $heading, $post_text, $quote_author, $file_name, $video_link, $post_link, $view_count, $user_id, $content_type_id);
    mysqli_stmt_execute($stmt);
    $stmt_result = mysqli_stmt_get_result($stmt);
    $post_id = mysqli_insert_id($con);
    // add tags to post
    $tags = explode(' ', $_POST['post-tags']);
    $check_hashtags = add_tags_to_new_post($tags, $con, $post_id);

    if (!($stmt_result) && ($check_hashtags === true)) {
        return $post_id;//new post id
    }
    return false;
}

/**
 * @param $file_name
 * @return string
 */
function get_photo_file_path($file_name): string {
    $check_file = file_exists('img/' . $file_name);
    if ($check_file === false) {
        return '../uploads/' . $file_name;
    }
    return '../img/' . $file_name;
}

/**
 * @param $errors
 * @param $key
 * @return false|mixed
 */
function get_error_info($errors, $key) {
    if (isset($errors[$key])) {
        return $errors[$key];
    }
    return false;
}

/**
 * @param $data
 * just useful one to print out to the browsers console instead of just var_dumping
 */
function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
}
