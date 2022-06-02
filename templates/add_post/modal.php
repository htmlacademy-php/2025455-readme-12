<?php
/**
 * @var $new_post_id
 */
?>
<div class="modal modal--adding modal--active">
      <div class="modal__wrapper">
        <a href="../../add.php?pubtype_id=3">
          <button class="modal__close-button button" type="button">
          <svg class="modal__close-icon" width="18" height="18">
            <use xlink:href="#icon-close"></use>
          </svg>
          <span class="visually-hidden">Закрыть модальное окно</span></button>
        </a>
        <div class="modal__content">
          <h1 class="modal__title">Пост добавлен</h1>
          <p class="modal__desc">
            Пост опубликован. Теперь вы можете перейти на страницу публикации или вернуться на главную.
          </p>
          <div class="modal__buttons">
            <a class="modal__button button button--main" href="../../index.php">Главная</a>
            <a class="modal__button button button--gray" href="<?=get_link_for_new_post($new_post_id)?>">К посту</a>
          </div>
        </div>
      </div>
    </div>
