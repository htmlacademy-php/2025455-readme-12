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
if (!$con) {
    print("Ошибка подключения: " . mysqli_connect_error());
}


mysqli_set_charset($con, "utf8");

//Posts DB
$posts_bd = get_posts_from_db($con, 'view_count', 'DESC', '6');
foreach ($posts_bd as $post_bd) {
    if ($post_bd['alias'] == NULL) {
        $posts_bd == [];
        break;
    }
}

//Types DB
$types_bd = get_types_from_db($con);
foreach ($types_bd as $type_bd) {
    if ($type_bd['alias'] == NULL) {
        $types_bd == [];
        break;
    }
}

//Шаблонизация
$page_content = include_template('main.php', ['posts_bd' => $posts_bd, 'types_bd' => $types_bd]);

$layout_content = include_template('layout.php', ['title' => 'readme: полезное', 'is_auth' => $is_auth, 'user_name' => $user_name, 'content' => $page_content]);

print($layout_content);

?>
