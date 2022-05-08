<?php
/**
 * @var $errors
 */
?>
<div class="adding-post__input-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="tags">Теги</label>
    <div class="form__input-section">
        <input class="adding-post__input form__input" id="tags" type="text" name="post-tags" placeholder="Введите теги"
               value="<?= getPostVal('post-tags') ?>">
        <?=include_template('add_error_info.php', compact('errors'))?>
    </div>
</div>
