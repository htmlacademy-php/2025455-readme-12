<?php
/**
 * @var $errors
 */
?>
<div class="adding-post__input-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="photo-url">Ссылка из интернета</label>
    <div class="form__input-section <?=get_form_field_status($errors['photo-link'])?> <?=get_form_field_status($errors['photo-link-format'])?>">
        <input class="adding-post__input form__input" id="photo-url" type="text" name="photo-link" placeholder="Введите ссылку" value="<?=getPostVal('photo-link')?>">
        <?=include_template('add_error_info.php', compact('errors'))?>
    </div>
</div>
