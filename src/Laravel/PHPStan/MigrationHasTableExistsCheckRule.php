<?php

namespace JumpTwentyFour\LaravelCodingStandards\Laravel\PHPStan;

use Illuminate\Support\Facades\Schema;
use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\BooleanNot;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;

class MigrationHasTableExistsCheckRule implements Rule
{
    public function getNodeType(): string
    {
        return StaticCall::class;
    }

    /**
     * @return string[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (!$node->name instanceof Identifier || $node->name->toString() !== 'create') {
            return [];
        }

        if ($node->class->toString() !== Schema::class) {
            // Method was not called on a Schema, so no errors.
            return [];
        }

        $previousNode = $node->getAttribute('parent');

        while (!$previousNode instanceof ClassMethod && $previousNode !== null) {
            while ($previousNode->hasAttribute('previous')) {
                $previousNode = $previousNode->getAttribute('previous');
                if ($this->checkForHasTableMethod($previousNode)) {
                    return [];
                }
            }

            if ($this->checkForHasTableMethod($previousNode)) {
                return [];
            }

            $previousNode = $previousNode->getAttribute('parent');
        }

        $message = 'Cannot create table in migration without hasTable check to check the table does not already
        exist on the environment. This can particularly be an issue when running migrations on a legacy database
        with no concept of migrations. Please add a Schema::hasTable() check to your migration file before the create
        method.';

        return [$message];
    }

    private function checkForHasTableMethod($node): bool
    {
        if (!$node instanceof If_ && !$node instanceof Identical && !$node instanceof BooleanNot) {
            return false;
        }

        if ($node instanceof BooleanNot) {
            $class = $node->expr->class;
        }

        if ($node instanceof If_) {
            $class = $node->cond->class;
        }

        if ($node instanceof Identical) {
            $class = $node->left->class;
        }

        if ($class === null) {
            return false;
        }

        if ($class->toString() !== Schema::class) {
            return false;
        }

        if ($class->getAttribute('parent')->name->toString() !== 'hasTable') {
            return false;
        }

        return true;
    }
}
