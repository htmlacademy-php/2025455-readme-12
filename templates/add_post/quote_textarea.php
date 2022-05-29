<?php
/**
 * @var $errors
 */
?>
<div class="adding-post__input-wrapper form__textarea-wrapper">
    <label class="adding-post__label form__label" for="cite-text">Текст цитаты <span class="form__input-required">*</span></label>
    <div class="form__input-section <?=(isset($errors['post-quote'])) ? 'form__input-section--error' : '' ?>">
        <textarea class="adding-post__textarea adding-post__textarea--quote form__textarea form__input" id="cite-text" name="post-quote" placeholder="Введите текст"><?=getPostVal('post-quote')?></textarea>
        <?php $error = get_error_info($errors, 'post-quote')?>
        <?=include_template('add_post/error_info.php', compact('error'))?>
    </div>
</div>
