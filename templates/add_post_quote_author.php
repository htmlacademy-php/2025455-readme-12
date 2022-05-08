<?php
/**
 * @var $errors
 */
?>
<div class="adding-post__textarea-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="quote-author">Автор <span class="form__input-required">*</span></label>
    <div class="form__input-section post-link <?=get_form_field_status($errors['quote-author'])?>">
        <input class="adding-post__input form__input" id="quote-author" type="text" name="quote-author" placeholder="Укажите автор" value="<?=getPostVal('quote-author')?>">
        <?php $error = get_error_info($errors, 'quote-author')?>
        <?=include_template('add_error_info.php', compact('error'))?>
    </div>
</div>
