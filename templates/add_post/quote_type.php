<?php
/**
 * @var $publication_type_id
 * @var $errors
 */
?>
<section class="adding-post__quote tabs__content <?=($publication_type_id == 4) ? 'tabs__content--active' : ''?>">
    <h2 class="visually-hidden">Форма добавления цитаты</h2>
    <form class="adding-post__form form" action="../add.php?publication_type_id=4" method="post">
        <div class="form__text-inputs-wrapper">
            <div class="form__text-inputs">
                <?=include_template('add_post/fields/title.php', compact('errors'))?>
                <?=include_template('add_post/fields/quote_textarea.php', compact('errors'))?>
                <?=include_template('add_post/fields/quote_author.php', compact('errors'))?>
                <?=include_template('add_post/fields/tags.php', compact('errors'))?>
            </div>
            <?=include_template('add_post/invalid_block.php', compact('errors'))?>
        </div>
        <?=include_template('add_post/buttons.php',[])?>
    </form>
</section>
