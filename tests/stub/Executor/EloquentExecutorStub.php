<?php

namespace RulerZ\Stub\Executor;

use RulerZ\Executor\Eloquent\FilterTrait;

class EloquentExecutorStub
{
    public static $executeReturn;

    use FilterTrait;

    public function execute($target, array $operators, array $parameters)
    {
        return self::$executeReturn;
    }
}