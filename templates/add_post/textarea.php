<?php
/**
 * @var $errors
 */
?>
<div class="adding-post__textarea-wrapper form__textarea-wrapper">
    <label class="adding-post__label form__label" for="post-text">Текст поста <span class="form__input-required">*</span></label>
    <div class="form__input-section <?=(isset($errors['post-text'])) ? 'form__input-section--error' : '' ?>">
        <textarea class="adding-post__textarea form__textarea form__input" id="post-text" name="post-text" placeholder="Введите текст"><?=getPostVal('post-text')?></textarea>
        <?php $error = get_error_info($errors, 'post-text')?>
        <?=include_template('add_post/error_info.php', compact('error'))?>
    </div>
</div>
