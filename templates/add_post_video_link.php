<?php
/**
 * @var $errors
 */
?>
<div class="adding-post__input-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="video-url">Ссылка youtube <span class="form__input-required">*</span></label>
    <div class="form__input-section <?=get_form_field_status($errors['video-link'])?> <?=get_form_field_status($errors['video-format'])?> <?=get_form_field_status($errors['video-url'])?>">
        <input class="adding-post__input form__input" id="video-url" type="text" name="video-link" placeholder="Введите ссылку" value="<?=getPostVal('video-link')?>">
        <?php $error = get_error_info($errors, 'video-link')?>
        <?=include_template('add_error_info.php', compact('error'))?>
    </div>
</div>
