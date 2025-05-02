<?php

namespace app\rules;

use core\interfaces\RuleInterface;
use core\library\Request;
use core\library\Response;

class Cpf implements RuleInterface
{

    public function validate(string $field, Request $request, string $params = ""): ?Response
    {
        if(!preg_match("/^[0-9]{11}$/", $request->get($field))){
            return new Response("The {$field} field must contain a valid 11 digit number");
        }
        return null;
    }
}