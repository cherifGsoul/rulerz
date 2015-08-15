<?php

namespace RulerZ\Compiler;

use RulerZ\Parser\Parser;

abstract class AbstractCompiler implements Compiler
{
    /**
     * @var Parser
     */
    private $parser;

    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    protected function compileToSource($rule, Target\CompilationTarget $compilationTarget, array $parameters)
    {
        $ast           = $this->parser->parse($rule);
        $executorModel = $compilationTarget->compile($ast);

        $flattenedTraits = implode(PHP_EOL, array_map(function($trait) {
            return "\t" . 'use ' . $trait . ';';
        }, $executorModel->getTraits()));

        return <<<EXECUTOR
namespace RulerZ\Compiled\Executor;

use RulerZ\Executor\Executor;

class {$parameters['className']} implements Executor
{
    $flattenedTraits

    protected function execute(\$target, array \$operators, array \$parameters)
    {
        return {$executorModel->getCompiledRule()};
    }
}
EXECUTOR;
    }

    protected function getRuleIdentifier(Target\CompilationTarget $compilationTarget, $rule)
    {
        return crc32(get_class($compilationTarget) . $rule);
    }
}
