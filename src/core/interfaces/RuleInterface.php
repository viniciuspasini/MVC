<?php

namespace core\interfaces;

use core\library\Request;
use core\library\Response;

interface RuleInterface
{
    public function validate(string $field, Request $request, string $params = ""): ?Response;

}