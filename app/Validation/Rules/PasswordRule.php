<?php

namespace Validation\Rules;


class PasswordRule extends Rule
{
    public function passes($field, $value)
    {
        $regexp = 'A(?=[-_a-zA-Z0-9]*?[A-Z])(?=[-_a-zA-Z0-9]*?[a-z])(?=[-_a-zA-Z0-9]*?[0-9])
          [-_a-zA-Z0-9]{6,}z';
        $options = array('option' => $regexp);
        return filter_var($value, FILTER_VALIDATE_REGEXP, $options);
    }

    public function message($field)
    {
        return $field . ' must contain at least one uppercase, one lowercase and one number!';
    }
}