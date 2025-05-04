<?php

namespace core\library;

use core\exceptions\ClassNotFoundException;
use core\interfaces\RuleInterface;

class Validate
{
    private array $errors;
    public readonly array $data;
    private RuleInterface $rule;

    public function validate(array $rules, Request $request): static
    {
        foreach ($rules as $field => $rule) {
            $ruleValidations = explode("|", $rule);

            foreach ($ruleValidations as $ruleValidation) {

                if(str_contains($ruleValidation, ":")) {
                    [$ruleValidation, $params] = explode(":", $ruleValidation);
                }

                $ruleValidation = str_contains($ruleValidation, '\\') ? $ruleValidation : 'core\\rules\\' . ucfirst($ruleValidation);

                if (!class_exists($ruleValidation)) {
                    throw new ClassNotFoundException("{$ruleValidation} does not exist");
                }

                $this->rule = new $ruleValidation();

                $response = $this->rule->validate($field, $request, $params ?? "");

                if($response instanceof Response){
                   $this->errors[$field] = $response->send(return: true);
                   break;
                }
            }
        }

        if(!$this->hasErrors()){
            $this->data = $request->getAll();
        }

        return $this;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}

