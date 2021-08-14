<?php

namespace Validation\Rules;


class IntRule extends Rule
{
    public function passes($field, $value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public function message($field)
    {
        return $field . ' there must be numbers!';
    }
}