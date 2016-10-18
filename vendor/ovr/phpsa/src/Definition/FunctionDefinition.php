<?php
/**
 * @author Patsura Dmitry https://github.com/ovr <talk@dmtry.me>
 */

namespace PHPSA\Definition;

use PHPSA\CompiledExpression;
use PHPSA\Context;
use PhpParser\Node;

/**
 * Class FunctionDefinition
 * @package PHPSA\Definition
 */
class FunctionDefinition extends ParentDefinition
{
    /**
     * @todo Use Finder
     *
     * @var string
     */
    protected $filepath;

    /**
     * @var Node\Stmt\Function_
     */
    protected $statement;

    /**
     * @var int
     */
    protected $returnTypes = CompiledExpression::MIXED;

    /**
     * @var array
     */
    protected $possibleReturnTypes = array();

    /**
     * @param $name
     */
    public function __construct($name, Node\Stmt\Function_ $statement)
    {
        $this->name = $name;
        $this->statement = $statement;
    }

    /**
     * Compile function to check it
     *
     * @param Context $context
     * @return bool
     */
    public function compile(Context $context)
    {
        if ($this->compiled) {
            return true;
        }

        $context->setFilepath($this->filepath);
        $this->compiled = true;

        $context->scopePointer = $this->getPointer();
        $context->setScope(null);

        if (count($this->statement->stmts) == 0) {
            return $context->notice(
                'not-implemented-function',
                sprintf('Function %s() is not implemented', $this->name),
                $this->statement
            );
        }

        if (count($this->statement->params) > 0) {
            /** @var  Node\Param $parameter */
            foreach ($this->statement->params as $parameter) {
                $context->addSymbol($parameter->name);
            }
        }

        foreach ($this->statement->stmts as $st) {
            \PHPSA\nodeVisitorFactory($st, $context);
        }

        return true;
    }

    /**
     * @return string
     */
    public function getFilepath()
    {
        return $this->filepath;
    }

    /**
     * @param string $filepath
     */
    public function setFilepath($filepath)
    {
        $this->filepath = $filepath;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }
}
