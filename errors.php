<?php

//validate functions

function validateFilled($name) {
    if (empty($_POST[$name])) {
        return "Это поле должно быть заполнено";
    }
}

//arrays

$errors = [];
$rules = [
    'heading' => function() {
        return validateFilled('heading');
    },
    'post-text' => function() {
        return validateFilled('post-text');
    }
];

foreach ($_POST as $key => $value) {
    if (isset($rules[$key])) {
        $rule = $rules[$key];
        $errors[$key] = $rule();
    }
}

return array_filter($errors);
