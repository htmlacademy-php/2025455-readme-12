<?php
/**
 * @var $publication_type_id
 * @var $errors
 */
?>
<section class="adding-post__photo tabs__content <?=($publication_type_id == 1) ? 'tabs__content--active' : ''?>">
    <h2 class="visually-hidden">Форма добавления фото</h2>
    <form class="adding-post__form form" action="../add.php?publication_type_id=1" method="post" enctype="multipart/form-data">
        <div class="form__text-inputs-wrapper">
            <div class="form__text-inputs">
                <?=include_template('add_post/fields/title.php', compact('errors'))?>
                <?=include_template('add_post/fields/photo_link.php', compact('errors'))?>
                <?=include_template('add_post/fields/tags.php', compact('errors'))?>
            </div>
            <?=include_template('add_post/invalid_block.php', compact('errors'))?>
        </div>
        <?=include_template('add_post/fields/photo.php', compact('errors'))?>
        <?=include_template('add_post/buttons.php',[])?>
    </form>
</section>
