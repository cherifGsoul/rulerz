<?php

namespace RulerZ\Target;

abstract class AbstractSqlTarget extends AbstractCompilationTarget
{
    protected $allowStarOperator = true;

    public function __construct(array $operators = [], array $inlineOperators = [], $allowStarOperator = true)
    {
        parent::__construct($operators, $inlineOperators);

        $this->allowStarOperator = $allowStarOperator;
    }
}