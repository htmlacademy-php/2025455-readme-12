<?php
/**
 * @var $errors
 */
?>
<div class="adding-post__textarea-wrapper form__textarea-wrapper">
    <label class="adding-post__label form__label" for="post-text">Текст поста <span class="form__input-required">*</span></label>
    <div class="form__input-section <?=get_form_field_status($errors['post-text'])?>">
        <textarea class="adding-post__textarea form__textarea form__input" id="post-text" name="post-text" placeholder="Введите текст"><?=getPostVal('post-text')?></textarea>
        <?php $error = get_error_info($errors, 'post-text')?>
        <?=include_template('add_error_info.php', compact('error'))?>
    </div>
</div>
