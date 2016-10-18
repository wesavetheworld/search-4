<?php

namespace PHPSA\Compiler\Expression\Operators\Comparison;

use PHPSA\CompiledExpression;
use PHPSA\Context;
use PHPSA\Compiler\Expression;
use PHPSA\Compiler\Expression\AbstractExpressionCompiler;

abstract class AbstractOperator extends AbstractExpressionCompiler
{
    /**
     * Do compare
     *
     * @param $left
     * @param $right
     * @return boolean
     */
    abstract public function compare($left, $right);

    /**
     * {expr} $operator {expr}
     *
     * @param \PhpParser\Node\Expr\BinaryOp $expr
     * @param Context $context
     * @return CompiledExpression
     */
    protected function compile($expr, Context $context)
    {
        $left = $context->getExpressionCompiler()->compile($expr->left);
        $right = $context->getExpressionCompiler()->compile($expr->right);

        switch ($left->getType()) {
            case CompiledExpression::INTEGER:
            case CompiledExpression::DOUBLE:
                switch ($right->getType()) {
                    case CompiledExpression::INTEGER:
                    case CompiledExpression::DOUBLE:
                        return new CompiledExpression(
                            CompiledExpression::BOOLEAN,
                            $this->compare($left->getValue(), $right->getValue())
                        );
                }
                break;
        }

        return new CompiledExpression(CompiledExpression::BOOLEAN);
    }
}
