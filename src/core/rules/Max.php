<?php

namespace core\rules;

use core\interfaces\RuleInterface;
use core\library\Request;
use core\library\Response;

class Max implements RuleInterface
{

    public function validate(string $field, Request $request, string $params = ""): ?Response
    {
        if(strlen($request->get($field)) > $params){
            return new Response("The {$field} must have a maximum of {$params} characters");
        }
        return null;
    }
}