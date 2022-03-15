<?php
/**
 * @var array $posts
 * @var array $types
 * @var int $url_content_types_id
 */
?>
<div class="container">
        <h1 class="page__title page__title--popular">Популярное</h1>
    </div>
    <div class="popular container">
        <div class="popular__filters-wrapper">
            <div class="popular__sorting sorting">
                <b class="popular__sorting-caption sorting__caption">Сортировка:</b>
                <ul class="popular__sorting-list sorting__list">
                    <li class="sorting__item sorting__item--popular">
                        <a class="sorting__link sorting__link--active" href="#">
                            <span>Популярность</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link" href="#">
                            <span>Лайки</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link" href="#">
                            <span>Дата</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="popular__filters filters">
                <b class="popular__filters-caption filters__caption">Тип контента:</b>
                <ul class="popular__filters-list filters__list">
                    <li class="popular__filters-item popular__filters-item--all filters__item filters__item--all">
                        <a class="filters__button filters__button--ellipse filters__button--all <?=($url_content_types_id == '') ? 'filters__button--active' : ''?>" href="http://2025455-readme-12/">
                            <span>Все</span>
                        </a>
                    </li>
                    <?php foreach ($types as $type): ?>
                    <?php $id = get_id_for_content_type($type['alias'])?>
                    <li class="popular__filters-item filters__item">
                        <a class="filters__button <?=get_button_css_class($type['alias'])?> button <?=is_button_active($url_content_types_id, $id)?>" href="http://2025455-readme-12/?url_content_types_id=<?=$id?>">
                            <span class="visually-hidden"><?=$type['type_title']?></span>
                            <svg class="filters__icon" width="22" height="18">
                                <use xlink:href="<?=get_button_icon_url($type['alias'])?>"></use>
                            </svg>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="popular__posts">
            <?php foreach ($posts as $index=>$post): ?>
                <?php $css_class = get_post_css_class($post['alias']); ?>
                <article class="popular__post post <?=$css_class?>">
                    <header class="post__header">
                        <h2><!--здесь заголовок--><a href="http://2025455-readme-12/post.php/?url_post_id=<?=$post['id']?>"><?=htmlspecialchars($post['title'])?></a></h2>
                    </header>
                    <div class="post__main">
                        <!--здесь содержимое карточки-->
                        <?php if ($post['type_title'] === 'Цитата'): ?>
                            <blockquote>
                                <p>
                                    <?= htmlspecialchars($post['text']) ?>
                                </p>
                                <cite><?= htmlspecialchars($post['quote_author']) ?></cite>
                            </blockquote>
                        <?php elseif ($post['type_title'] === 'Текст'): ?>
                            <?php $final_text = text_cut($post['text'], 200); ?>
                            <p><?= htmlspecialchars($final_text) ?></p>
                            <?php if ($final_text !== $post['text']):?>
                                <a class="post-text__more-link" href="#">Читать далее</a>
                            <?php endif; ?>
                        <?php elseif ($post['type_title'] === 'Картинка'): ?>
                            <div class="post-photo__image-wrapper">
                                <img src="img/<?= htmlspecialchars($post['img']) ?>" alt="Фото от пользователя" width="360" height="240">
                            </div>
                        <?php elseif ($post['type_title'] === 'Ссылка'): ?>
                            <div class="post-link__wrapper">
                                <a class="post-link__external" href="http://<?=htmlspecialchars($post['link'])?>" title="Перейти по ссылке">
                                    <div class="post-link__info-wrapper">
                                        <div class="post-link__icon-wrapper">
                                            <img src="https://www.google.com/s2/favicons?domain=vitadental.ru" alt="Иконка">
                                        </div>
                                        <div class="post-link__info">
                                            <h3><!--здесь заголовок--><?= htmlspecialchars($post['title']) ?></h3>
                                        </div>
                                    </div>
                                    <span><!--здесь ссылка--><?= htmlspecialchars($post['link']) ?></span>
                                </a>
                            </div>
                        <?php elseif ($post['type_title'] === 'Видео'): ?>
                            <div class="post-video__block">
                                <div class="post-video__preview">
                                    <?=embed_youtube_cover(/* вставьте ссылку на видео */htmlspecialchars($post['video'])); ?>
                                    <img src="/img/coast-medium.jpg" alt="Превью к видео" width="360" height="188">
                                </div>
                                <a href="/post-details.html" class="post-video__play-big button">
                                    <svg class="post-video__play-big-icon" width="14" height="14">
                                        <use xlink:href="#icon-video-play-big"></use>
                                    </svg>
                                    <span class="visually-hidden">Запустить проигрыватель</span>
                                </a>
                            </div>
                        <?php endif; ?>

                    </div>
                    <footer class="post__footer">
                        <div class="post__author">
                            <a class="post__author-link" href="#" title="Автор">
                                <div class="post__avatar-wrapper">
                                    <!--укажите путь к файлу аватара-->
                                    <img class="post__author-avatar" src="img/<?= $post['avatar'] ?>" alt="Аватар пользователя">
                                </div>
                                <div class="post__info">
                                    <b class="post__author-name"><!--здесь имя пользователя--><?= htmlspecialchars($post['login']) ?></b>
                                    <?php $date = $post['creation_date']; //может быть получена любым способом
                                    [$formatted_date, $relative_date] = post_date($date, 'назад'); ?>
                                    <time class="post__time" datetime="<?=$date?>" title="<?=$formatted_date?>"><?=$relative_date?></time>
                                </div>
                            </a>
                        </div>
                        <div class="post__indicators">
                            <div class="post__buttons">
                                <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                                    <svg class="post__indicator-icon" width="20" height="17">
                                        <use xlink:href="#icon-heart"></use>
                                    </svg>
                                    <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                                        <use xlink:href="#icon-heart-active"></use>
                                    </svg>
                                    <span>0</span>
                                    <span class="visually-hidden">количество лайков</span>
                                </a>
                                <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
                                    <svg class="post__indicator-icon" width="19" height="17">
                                        <use xlink:href="#icon-comment"></use>
                                    </svg>
                                    <span>0</span>
                                    <span class="visually-hidden">количество комментариев</span>
                                </a>
                            </div>
                        </div>
                    </footer>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
