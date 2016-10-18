<?php
/**
 * @author Patsura Dmitry https://github.com/ovr <talk@dmtry.me>
 */

namespace PHPSA\Compiler\Statement;

use PHPSA\CompiledExpression;
use PHPSA\Context;

class TryCatchSt extends AbstractCompiler
{
    protected $name = '\PhpParser\Node\Stmt\TryCatch';

    /**
     * @param \PhpParser\Node\Stmt\TryCatch $statement
     * @param Context $context
     * @return CompiledExpression
     */
    public function compile($statement, Context $context)
    {
        if (count($statement->stmts) > 0) {
            foreach ($statement->stmts as $stmt) {
                \PHPSA\nodeVisitorFactory($stmt, $context);
            }
        } else {
            $context->notice('not-implemented-body', 'Missing body', $statement);
        }

        if (count($statement->catches) > 0) {
            foreach ($statement->catches as $stmt) {
                \PHPSA\nodeVisitorFactory($stmt, $context);
            }
        }

        if (count($statement->finallyStmts) > 0) {
            foreach ($statement->finallyStmts as $stmt) {
                \PHPSA\nodeVisitorFactory($stmt, $context);
            }
        }
    }
}
