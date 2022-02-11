<?php
require_once 'helpers.php';
$is_auth = rand(0, 1);

$user_name = 'Семенов Никита'; // укажите здесь ваше имя

//массив с элементами, содержащими информацию для постов
$posts = [
    [
        'title' => 'Цитата',
        'type' => 'post-quote',
        'value' => 'Мы в жизни любим только раз, а после ищем лишь похожих',
        'author' => 'Лариса',
        'avatar' => 'userpic-larisa-small.jpg',
    ],
    [
        'title' => 'Игра престолов',
        'type' => 'post-text',
        'value' => 'Не могу дождаться начала финального сезона своего любимого сериала!',
        'author' => 'Владик',
        'avatar' => 'userpic.jpg',
    ],
    [
        'title' => '_Новости F1_',
        'type' => 'post-text',
        'value' => 'Mercedes заявили, что хотели бы быстрее увидеть машину на тестах. Главной причиной является "проверка работоспособности двигателя".
Переход с топлива E5 на топливо E10 может стать одним из ключевых параметров успеха в 2022 году,
а именно способность каждой команды компенсировать потери мощности своего мотора.
Кроме того, Mercedes подтвердили, что со значительными изменениями аэродинамики изменится и стиль вождения у гонщиков, им придется иначе проходить повороты.
Глава HPP Mercedes Хайвел Томас заявил, что "запросы к пилотам будут совсем другие,
и нужно как можно быстрее проверить симуляции в реальных условиях". И еще один важный момент - производительность двигателя будет "заморожена" до 2025 года включительно, пока не появятся новые двигатели.
Все команды волнуются, потому что ошибки перед стартом сезона 2022 могут повлечь за собой цепь неудачных лет.
Новое топливо, новая аэродинамика, "заморозка" силовых агрегатов и размещение мотора в структуре болида может стать для кого-то невыполнимым вызовом...',
        'author' => 'Владик test',
        'avatar' => 'userpic.jpg',
    ],
    [
        'title' => 'Наконец, обработал фотки!',
        'type' => 'post-photo',
        'value' => 'rock-medium.jpg',
        'author' => 'Виктор',
        'avatar' => 'userpic-mark.jpg',
    ],
    [
        'title' => 'Моя мечта',
        'type' => 'post-photo',
        'value' => 'coast-medium.jpg',
        'author' => 'Лариса',
        'avatar' => 'userpic-larisa-small.jpg',
    ],
    [
        'title' => 'Лучшие курсы',
        'type' => 'post-link',
        'value' => 'www.htmlacademy.ru',
        'author' => 'Владик',
        'avatar' => 'userpic.jpg',
    ]
];

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

//Шаблонизация

$page_content = include_template('main.php', ['posts' => $posts]);

$layout_content = include_template('layout.php', ['title' => 'readme: полезное', 'is_auth' => $is_auth, 'user_name' => $user_name, 'content' => $page_content]);

print($layout_content);
?>
