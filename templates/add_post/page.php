<?php

/**
 * @var $types
 * @var $pubtype_id
 * @var $content
 */
?>
    <main class="page__main page__main--adding-post">
      <div class="page__main-section">
        <div class="container">
          <h1 class="page__title page__title--adding-post">Добавить публикацию</h1>
        </div>
        <div class="adding-post container">
          <div class="adding-post__tabs-wrapper tabs">
            <div class="adding-post__tabs filters">
              <ul class="adding-post__tabs-list filters__list tabs__list">
                <?php foreach ($types as $type):
                $id = get_id_for_content_type($type['alias'])?>
                <li class="adding-post__tabs-item filters__item">
                  <a class="adding-post__tabs-link filters__button <?=get_button_css_class($type['alias'])?> <?=($pubtype_id == $id) ? 'filters__button--active' : ''?> tabs__item <?=($pubtype_id == $id) ? 'tabs__item--active' : ''?> button" href="<?=get_link_for_form_type_button($id)?>">
                    <svg class="filters__icon" width="22" height="18">
                      <use xlink:href="<?=get_button_icon_url($type['alias'])?>"></use>
                    </svg>
                    <span><?=$type['type_title']?></span>
                  </a>
                </li>
                  <?php endforeach; ?>
              </ul>
            </div>
            <div class="adding-post__tab-content">
            <?=$content?>
            </div>
          </div>
        </div>
      </div>
    </main>
