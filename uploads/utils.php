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
function post_date($date_str, $back) {

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
 * @param false|mysqli|null $con
 * @param $sql_query
 * @return array Ассоциативный массив с данными из БД
 */
function get_db($con, $sql_query) {
    //$result = $sql_query->get_result();
    $result = mysqli_query($con, $sql_query);
    $array = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return($array);
}

/**
 * Функция для показа постов
 * @param false|mysqli|null $con
 * @param string $sorting
 * @param string $sort_type
 * @param int $limit
 * @param int $filter_id
 * @return array Массив типов контента из базы данных
 */
function get_posts_from_db($con, $sorting, $sort_type, $limit, $filter_id) {
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
    $array = get_db($con, $query);

    return($array);
}

/**
 * Функция для показа типов контента
 * @param false|mysqli|null $con
 * @return array Массив типов контента из базы данных
 */
function get_types_from_db($con) {
    $query = "SELECT type_title, class_icon, alias FROM content_types";
    $array = get_db($con, $query);

    return($array);
}

/**
 * @param false|mysqli|null $con
 * @param int $filter_id
 * @return array Данные о посте
 */
function get_post_details_from_db($con, $filter_id) {
    $query = sprintf("SELECT posts.id, content_types.alias, posts.title, text, quote_author, img, video, link, view_count, user_id, content_types_id
FROM posts
INNER JOIN content_types ON posts.content_types_id = content_types.id
WHERE posts.id = %d",  $filter_id);
    $array = get_db($con, $query);

    return($array);
}

/**
 * @param $con
 * @param $filter_id
 * @return int
 */
function get_likes_quantity($con, $filter_id) {
    $query = sprintf("SELECT l.id, l.user_id, l.post_id
FROM likes l
INNER JOIN posts p ON l.post_id = p.id
WHERE p.id = %d", $filter_id);
    $array = get_db($con, $query);
    $likes_quantity = count($array);
    return($likes_quantity);
}

/**
 * @param $con
 * @param $filter_id
 * @return array
 */
function get_hashtags_for_post($con, $filter_id) {
    $query = sprintf("SELECT h.hashtag_title
FROM posts p
INNER JOIN posts_hashtags ph ON p.id = ph.post_id
INNER JOIN hashtags h ON ph.hashtag_id = h.id
WHERE p.id = %d", $filter_id);
    $array = get_db($con, $query);

    return($array);
}

/**
 * @param $con
 * @param $filter_id
 * @return array
 */
function get_comments_for_post_details($con, $filter_id) {
    $query = sprintf("SELECT p.id, u.login, u.avatar, c.comment_creation_date, content, c.user_id, post_id
FROM comments c
INNER JOIN users u ON c.user_id = u.id
INNER JOIN posts p ON c.post_id = p.id
WHERE p.id = %d", $filter_id);
    $array = get_db($con, $query);

    return($array);
}

/**
 * @param $con
 * @param $filter_id
 * @return array
 */
function get_user_for_post_details($con, $filter_id) {
    $query = sprintf("SELECT p.id, u.id, u.login, u.avatar, u.registration_date
FROM posts p
INNER JOIN users u ON p.user_id = u.id
WHERE p.id = %d", $filter_id);
    $array = get_db($con, $query);

    return($array);
}

/**
 * @param $con
 * @param $filter_id
 * @return int
 */
function get_subscribers_number($con, $filter_id) {
    $query = sprintf("SELECT s.id, s.author_user_id, s.subscribed_user_id
FROM subscriptions s
INNER JOIN users u ON s.subscribed_user_id = u.id
WHERE u.id = %d", $filter_id);
    $array = get_db($con, $query);
    $subscribers_number = count($array);
    return($subscribers_number);
}

/**
 * @param $con
 * @param $filter_id
 * @return int
 */
function get_publications_number($con, $filter_id) {
    $query = sprintf("SELECT p.id, p.user_id, u.id
FROM posts p
INNER JOIN users u ON p.user_id = u.id
WHERE u.id = %d", $filter_id);
    $array = get_db($con, $query);
    $posts_number = count($array);
    return($posts_number);
}

function get_posts_quantity($con) {
    $query = "SELECT id FROM posts";
    $array = get_db($con, $query);
    $posts_quantity = count($array);
    return($posts_quantity);
}

/**
 * Функция, определяющая класс по алиасу
 * @param string $alias
 * @return string Класс оформления для поста
 */
function get_post_css_class($alias) {

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
 * @return string[] CSS класс для кнопки
 */
function get_button_css_class($type_alias) {
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
    }

    return $filters__button;
}

/**
 * @param string $type_alias
 * @return string[] значение для xlink
 */
function get_button_icon_url($type_alias) {
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
    }

    return $icon_url;
}

/**
 * @param string $type_alias
 * @return int параметр id для этого типа контента
 */
function get_id_for_content_type($type_alias) {
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
    }

    return $id;
}

/**
 * @param int $url_id
 * @param int $type_id
 * @return string CSS класс для кнопки
 */
function is_button_active($url_id, $type_id) {
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
function get_link_for_type_button($type_id) {
    $link = sprintf('index.php?url_content_types_id=%d',$type_id);
    return $link;
}

/**
 * @param $post_id
 * @return string
 */
function get_link_for_post($post_id) {
    $link = sprintf('post.php?url_post_id=%d',$post_id);
    return $link;
}
?>

