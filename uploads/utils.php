<?php

//Функция, обрезающая содержимое текстового контента по заданному кол-ву симловов
function text_cut( $text, $quantity = 300) {

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

//функция работы с относительной датой постов
function post_date($date_str) {

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
    $back = "назад";

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

?>

