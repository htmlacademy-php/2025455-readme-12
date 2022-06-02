<?php
/**
 * @var $errors
 */
?>
<div class="adding-post__input-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="video-url">Ссылка youtube <span class="form__input-required">*</span></label>
    <div class="form__input-section <?=(isset($errors['video-link']) || isset($errors['video-format']) || isset($errors['video-url'])) ? 'form__input-section--error' : '' ?>">
        <input class="adding-post__input form__input" id="video-url" type="text" name="video-link" placeholder="Введите ссылку" value="<?=get_post_val('video-link')?>">
        <?php $error = get_error_info($errors, 'video-link')?>
        <?=include_template('add_post/error_info.php', compact('error'))?>
    </div>
</div>
