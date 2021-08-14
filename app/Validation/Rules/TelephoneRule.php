<?php

namespace Validation\Rules;


class TelephoneRule extends Rule
{
    public function passes($field, $value)
    {
        $regexp = '[+0-9]';
        $options = array('option' => $regexp);
        return filter_var($value, FILTER_VALIDATE_REGEXP, $options);
    }

    public function message($field)
    {
        return $field . ' must be +000000000000!';
    }
}