<?php

namespace JumpTwentyFour\LaravelCodingStandards\Laravel\PHPStan;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use PhpParser\Node;
use PhpParser\Node\Expr\StaticCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;

class MigrationsUpIfExistsRule implements Rule
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
        if (!$node->name instanceof Node\Identifier || $node->name->toString() !== 'create') {
            return [];
        }

        if ($node->class->toString() !== Schema::class) {
            // Method was not called on a Schema, so no errors.
            return [];
        }

        $previousNode = $node->getAttribute('parent');

        while (!$previousNode instanceof Node\Stmt\ClassMethod) {
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
        if (!$node instanceof Node\Stmt\If_) {
            return false;
        }

        if ($node->cond->class === null) {
            return false;
        }

        if ($node->cond->class->toString() !== Schema::class) {
            return false;
        }

        if ($node->cond->class->getAttribute('parent')->name->toString() !== 'hasTable') {
            return false;
        }

        return true;
    }
}
