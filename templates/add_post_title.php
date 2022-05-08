<?php
/**
 * @var $errors
 */
?>
<div class="adding-post__input-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="photo-heading">Заголовок <span
            class="form__input-required">*</span></label>
    <div class="form__input-section <?=get_form_field_status($errors['heading'])?>">
        <input class="adding-post__input form__input" id="photo-heading" type="text" name="heading"
               placeholder="Введите заголовок" value="<?= getPostVal('heading') ?>">
        <button class="form__error-button button" type="button">!<span
                class="visually-hidden">Информация об ошибке</span></button>
        <?php $error = get_error_info($errors, 'heading')?>
        <?=include_template('add_error_info.php', compact('error'))?>
    </div>
</div>

