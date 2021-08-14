<?php

namespace Validation;

use Validation\Rules\Rule;
use Validation\RuleMap;
use Validation\Errors\ErrorBag;

class Validator
{
    protected $data = [];

    protected $rules = [];

    protected $aliases = [];

    protected $errors;

    


    public function __construct(array $data)
    {
        $this->data = $data;
        $this->errors = new ErrorBag();

    }

    public function setRules(array $rules)
    {
        $this->rules = $rules;
    }

    public function setAliases(array $aliases)
    {
        $this->aliases = $aliases;
    }

    public function validate()
    {
        foreach ($this->rules as $field => $rules) {
            foreach ($this->resolveRules($rules) as $rule) {
                $this->validateRule($field, $rule);
            }
        }

        return $this->errors->hasErrors();
    }

    protected function resolveRules(array $rules)
    {
        return array_map(function ($rule) {

            if (is_string($rule)) {
                return $this->getRuleFromString($rule);
            }
            return $rule;
        }, $rules);
    }

    protected function getRuleFromString($rule) {
        return $this->newRuleFromMap(
            ($exploded = explode(':',  $rule))[0],
            explode(',', end($exploded))
        );
    }

    protected function newRuleFromMap($rule, $params)
    {
        return RuleMap::resolve($rule, $params);
    }

    protected function validateRule($field, Rule $rule)
    {
        if (!$rule->passes($field, $this->getFieldValue($field, $this->data)))
        {
            $this->errors->add($field, $rule->message($this->alias($field)));
        }
    }

    protected function alias($field)
    {
        return $this->aliases[$field] ?? $field;
    }

    protected function getFieldValue($field, $data)
    {
        return $data[$field] ?? null;
    }

    public function getErrors()
    {
        return $this->errors->getErrors();
    }


}