<?php
/**
 * @var $pubtype_id
 * @var $errors
 * @var $title
 * @var $tags
 * @var $invalid_block
 * @var $adding_post_buttons
 */
?>
<section class="adding-post__photo tabs__content <?=($pubtype_id == 1) ? 'tabs__content--active' : ''?>">
    <h2 class="visually-hidden">Форма добавления фото</h2>
    <form class="adding-post__form form" action="../add.php?pubtype_id=1" method="post" enctype="multipart/form-data">
        <div class="form__text-inputs-wrapper">
            <div class="form__text-inputs">
                <?=include_template('add_post_title.php', compact('errors'))?>
                <?=include_template('add_post_photo_link.php', compact('errors'))?>
                <?=include_template('add_post_tags.php', compact('errors'))?>
            </div>
            <?=include_template('add_post_invalid_block.php', compact('errors'))?>
        </div>
        <?=include_template('add_post_photo.php', compact('errors'))?>
        <?=include_template('add_post_buttons.php',[])?>
    </form>
</section>
