<?php
/**
 * @var array $posts_bd
 * @var array $types_bd
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
                        <a class="filters__button filters__button--ellipse filters__button--all filters__button--active" href="#">
                            <span>Все</span>
                        </a>
                    </li>
                    <?php foreach ($types_bd as $type): ?>
                    <?php if ($type['alias'] === 'photo') {$filters__button = 'filters__button--photo'; $url = '#icon-filter-photo';}
                    elseif ($type['alias'] === 'video') {$filters__button = 'filters__button--video'; $url = '#icon-filter-video';}
                    elseif ($type['alias'] === 'text') {$filters__button = 'filters__button--text'; $url = '#icon-filter-text';}
                    elseif ($type['alias'] === 'quote') {$filters__button = 'filters__button--quote'; $url = '#icon-filter-quote';}
                    elseif ($type['alias'] === 'link') {$filters__button = 'filters__button--link'; $url = '#icon-filter-link';}
                    ?>
                    <?php if ($type['alias'] === 'photo'): ?>
                    <li class="popular__filters-item filters__item">
                        <a class="filters__button <?=$filters__button?> button" href="#">
                            <span class="visually-hidden">Фото</span>
                            <svg class="filters__icon" width="22" height="18">
                                <use xlink:href="<?=$url?>"></use>
                            </svg>
                        </a>
                    </li>
                    <?php elseif ($type['alias'] === 'video'): ?>
                    <li class="popular__filters-item filters__item">
                        <a class="filters__button <?=$filters__button?> button" href="#">
                            <span class="visually-hidden">Видео</span>
                            <svg class="filters__icon" width="24" height="16">
                                <use xlink:href="<?=$url?>"></use>
                            </svg>
                        </a>
                    </li>
                    <?php elseif ($type['alias'] === 'text'): ?>
                    <li class="popular__filters-item filters__item">
                        <a class="filters__button <?=$filters__button?> button" href="#">
                            <span class="visually-hidden">Текст</span>
                              <svg class="filters__icon" width="20" height="21">
                                <use xlink:href="<?=$url?>"></use>
                            </svg>
                        </a>
                    </li>
                    <?php elseif ($type['alias'] === 'quote'): ?>
                    <li class="popular__filters-item filters__item">
                        <a class="filters__button <?=$filters__button?> button" href="#">
                            <span class="visually-hidden">Цитата</span>
                            <svg class="filters__icon" width="21" height="20">
                                <use xlink:href="<?=$url?>"></use>
                            </svg>
                        </a>
                    </li>
                    <?php elseif ($type['alias'] === 'link'): ?>
                    <li class="popular__filters-item filters__item">
                        <a class="filters__button <?=$filters__button?> button" href="#">
                            <span class="visually-hidden">Ссылка</span>
                            <svg class="filters__icon" width="21" height="18">
                                <use xlink:href="<?=$url?>"></use>
                            </svg>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="popular__posts">
            <?php foreach ($posts_bd as $index=>$post): ?>
            <?php if ($post['alias'] === 'photo') {$css_class = 'post-photo';}
                elseif ($post['alias'] === 'video') {$css_class = 'post-video';}
                elseif ($post['alias'] === 'text') {$css_class = 'post-text';}
                elseif ($post['alias'] === 'quote') {$css_class = 'post-quote';}
                elseif ($post['alias'] === 'link') {$css_class = 'post-link';}
                ?>
                <article class="popular__post post <?=$css_class?>">
                    <header class="post__header">
                        <h2><!--здесь заголовок--><?= htmlspecialchars($post['title']) ?></h2>
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
                                    [$formatted_date, $relative_date] = post_date($date); ?>
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
