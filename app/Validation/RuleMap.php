<?php

namespace Validation;

use Validation\Rules\RequiredRule;
use Validation\Rules\EmailRule;
use Validation\Rules\MaxRule;
use Validation\Rules\BetweenRule;
use Validation\Rules\IntRule;
use Validation\Rules\MinRule;
use Validation\Rules\PasswordRule;
use Validation\Rules\TelephoneRule;

class RuleMap
{
    protected static $map = [
        'required' => RequiredRule::class,
        'email' => EmailRule::class,
        'max' => MaxRule::class,
        'between' => BetweenRule::class,
        'min' => MinRule::class,
        'password' => PasswordRule::class,
        'telephone' => TelephoneRule::class,
        'int' => IntRule::class,
    ];

    public static function resolve($rule, $params)
    {
        return new static::$map[$rule](...$params);
    }
}