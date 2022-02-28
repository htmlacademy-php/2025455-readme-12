<?php
require_once 'helpers.php';
require_once 'uploads/utils.php';
date_default_timezone_set('Europe/Moscow');
$is_auth = rand(0, 1);

$user_name = 'Семенов Никита'; // укажите здесь ваше имя

//массив с элементами, содержащими информацию для постов
/*$posts = [
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
];*/

//DB
$con = mysqli_connect("127.0.0.1", "root", "", "2025455-readme-12");
if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
}
else {
    print("Соединение установлено");
}

mysqli_set_charset($con, "utf8");

//запрос на получение списка популярных постов
$sql_posts = "SELECT users.login, users.avatar, content_types.type_title, content_types.alias, creation_date, posts.title, text, quote_author, img, video, link, view_count, user_id, content_types_id
FROM posts
INNER JOIN content_types ON posts.content_types_id = content_types.id
INNER JOIN users ON posts.user_id = users.id
ORDER BY view_count DESC";
$result_posts = mysqli_query($con, $sql_posts);
$posts_bd = mysqli_fetch_all($result_posts, MYSQLI_ASSOC);
if ($posts_bd == []) {
    print("Не работает(");
}
else {
    print(". Массив постовБД заполнен");
}

//запрос на получение списка типов контента
$sql_types = "SELECT type_title, class_icon, alias from content_types";
$result_types = mysqli_query($con, $sql_types);
$types_bd = mysqli_fetch_all($result_types, MYSQLI_ASSOC);
if ($types_bd == []) {
    print("Не работает(");
}
else {
    print(". Массив типовБД заполнен");
}

//Шаблонизация

$page_content = include_template('main.php', ['posts_bd' => $posts_bd, 'types_bd' => $types_bd]);

$layout_content = include_template('layout.php', ['title' => 'readme: полезное', 'is_auth' => $is_auth, 'user_name' => $user_name, 'content' => $page_content]);

print($layout_content);
?>
