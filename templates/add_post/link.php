<?php
/**
 * @var $errors
 */
?>
<div class="adding-post__textarea-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="post-link">Ссылка <span class="form__input-required">*</span></label>
    <div class="form__input-section <?=(isset($errors['post-link'])) ? 'form__input-section--error' : '' ?>">
        <input class="adding-post__input form__input" id="post-link" type="text" name="post-link" placeholder="Введите ссылку" value="<?=getPostVal('post-link')?>">
        <?php $error = get_error_info($errors, 'post-link')?>
        <?=include_template('add_post/error_info.php', compact('error'))?>
    </div>
</div>
