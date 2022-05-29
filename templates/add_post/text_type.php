<?php
/**
 * @var $pubtype_id
 * @var $error_info
 * @var $title
 * @var $tags
 * @var $invalid_block
 * @var $adding_post_buttons
 * @var $errors
 */
?>
<section class="adding-post__text tabs__content <?=($pubtype_id == 3) ? 'tabs__content--active' : ''?>">
    <h2 class="visually-hidden">Форма добавления текста</h2>
    <form class="adding-post__form form" action="../add.php?pubtype_id=3" method="post">
        <div class="form__text-inputs-wrapper">
            <div class="form__text-inputs">
                    <?=include_template('add_post/title.php', compact('errors'))?>
                    <?=include_template('add_post/textarea.php', compact('errors'))?>
                    <?=include_template('add_post/tags.php', compact('errors'))?>
            </div>
            <?=include_template('add_post/invalid_block.php', compact('errors'))?>
        </div>
        <?=include_template('add_post/buttons.php',[])?>
    </form>
</section>
