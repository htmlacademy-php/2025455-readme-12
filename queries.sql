USE `2025455-readme-12`;

/*запросы для добавления информации в БД*/
/*список типов контента для поста*/
INSERT INTO content_types (type_title, class_icon, alias)
VALUES ('Фото','photo','photo'),('Видео','video','video'),('Текст','text','text'),('Цитата','quote','quote'),('Ссылка','link','link');

/*новые пользователи*/
INSERT INTO users (registration_date, email, login, password, avatar)
VALUES
('2021-08-16 15:42:34', 'deLaplacethebest@gmail.com', 'Scientist_deLaplace', 'Lagrange_for_kids1', 'userpic-mark.jpg'),
('2021-09-15 16:28:49', 'Lagrangethebest@gmail.com', 'Scientist_Lagrange', 'deLaplace_for_kids1', 'userpic.jpg');

/*список постов*/    /*до комментов, тк в комментах указывается id поста*/
INSERT INTO posts (creation_date, title, text, quote_author, img, video, link, view_count, user_id, content_types_id)
VALUES
('2022-02-21 06:38:49', 'Цитата', 'Мы в жизни любим только раз, а после ищем лишь похожих','Неизвестный автор',NULL,NULL,NULL,8,1,4),
('2022-02-15 09:21:05', 'Игра престолов', 'Не могу дождаться начала финального сезона своего любимого сериала!',NULL,NULL,NULL,NULL,19,2,3),
('2022-02-08 19:19:19', '_Новости F1_', 'Mercedes заявили, что хотели бы быстрее увидеть машину на тестах. Главной причиной является "проверка работоспособности двигателя".
Переход с топлива E5 на топливо E10 может стать одним из ключевых параметров успеха в 2022 году, а именно способность каждой команды компенсировать потери мощности своего мотора.
Кроме того, Mercedes подтвердили, что со значительными изменениями аэродинамики изменится и стиль вождения у гонщиков, им придется иначе проходить повороты.
Глава HPP Mercedes Хайвел Томас заявил, что "запросы к пилотам будут совсем другие, и нужно как можно быстрее проверить симуляции в реальных условиях". И еще один важный момент - производительность двигателя будет "заморожена" до 2025 года включительно, пока не появятся новые двигатели.
Все команды волнуются, потому что ошибки перед стартом сезона 2022 могут повлечь за собой цепь неудачных лет. Новое топливо, новая аэродинамика, "заморозка" силовых агрегатов и размещение мотора в структуре болида может стать для кого-то невыполнимым вызовом...',NULL,NULL,NULL,NULL,1550,1,3),
('2022-01-10 16:14:59', 'Наконец, обработал фотки!',NULL,NULL,'rock-medium.jpg',NULL,NULL,899,2,1),
('2021-12-18 21:00:13', 'Моя мечта',NULL,NULL, 'coast-medium.jpg',NULL,NULL,2012,1,1),
('2021-05-28 00:51:39', 'Лучшие курсы',NULL,NULL,NULL,NULL, 'www.htmlacademy.ru',3022,2,5);

/*комментарии к постам*/
INSERT INTO comments (comment_creation_date, content, user_id, post_id)
VALUES
('2022-02-20 09:05:41', 'Макс лучший!', 1, 3),
('2022-02-19 12:14:16', 'Льюис восьмикратный!', 2, 3),
('2022-01-30 19:20:47', 'Ладно.', 1, 4);

/*запросы для действий с БД*/
/*получить список постов с сортировкой по популярности, вместе с именами авторов и типом контента*/
SELECT u.login, t.type_title, creation_date, p.title, text, quote_author, img, video, link, view_count, user_id, content_types_id /*несмотря на вывод строк, id еще могут пригодиться*/
FROM posts p
INNER JOIN users u ON p.user_id = u.id
INNER JOIN content_types t ON p.content_types_id = t.id
ORDER BY view_count DESC;

/*получить список постов для конкретного пользователя*/
SELECT creation_date, p.title, text, quote_author, img, video, link, view_count, user_id, content_types_id
FROM posts p
INNER JOIN users u ON p.user_id = u.id
WHERE u.id = 1;

/*получить список комментариев для одного поста, в комментариях должен быть логин пользователя*/
SELECT u.login, c.comment_creation_date, content, c.user_id, post_id
FROM comments c
INNER JOIN users u ON c.user_id = u.id
INNER JOIN posts p ON c.post_id = p.id
WHERE p.id = 3;

/*добавить лайк к посту*/
INSERT INTO likes (user_id, post_id)
VALUES (2,3);

/*подписаться на пользователя*/
INSERT INTO subscriptions (author_user_id, subscribed_user_id)
VALUES (1,2);

/*тестовые хэштеги*/
INSERT INTO hashtags (hashtag_title)
VALUES ('интересно'),('втопе'),('формула1'),('фото'),('фотоприроды'),('полезныесайты'),('сериалы'),('цитата');

/*многие-ко-многим:посты и хэштеги*/
INSERT INTO posts_hashtags (post_id, hashtag_id)
VALUES (1,1),(1,8),(2,1),(2,2),(2,7),(3,1),(3,2),(3,3),(4,4),(4,5),(5,2),(5,4),(5,5),(6,1),(6,2),(6,6);
