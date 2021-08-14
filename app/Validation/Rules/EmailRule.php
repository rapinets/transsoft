<?php

namespace Validation\Rules;


class EmailRule extends Rule
{
    public function passes($field, $value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public function message($field)
    {
        return $field . ' must be a valid email address!';
    }
}