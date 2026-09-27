<?php

declare(strict_types=1);

namespace JumpTwentyFour\LaravelCodingStandards\Laravel\PHPStan;

use Illuminate\Foundation\Testing\TestCase;
use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\ObjectType;

class WithoutExceptionHandlingRule implements Rule
{
    public function getNodeType(): string
    {
        return MethodCall::class;
    }

    /**
     * @return RuleError[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (!$node->name instanceof Node\Identifier || $node->name->toString() !== 'withoutExceptionHandling') {
            return [];
        }
        if (!$this->isCalledOn($node->var, $scope, TestCase::class)) {
            // Method was not called on a test case, so no errors.
            return [];
        }

        $message = 'withoutExceptionHandling() should not be left in test code, remove this debugging call ' .
            'before committing.';

        return [
            RuleErrorBuilder::message($message)
                ->file($scope->getFile())
                ->line($node->getStartLine())
                ->build(),
        ];
    }

    /**
     * Determine whether the Expr was called on a class instance.
     */
    protected function isCalledOn(Expr $expr, Scope $scope, string $className): bool
    {
        $calledOnType = $scope->getType($expr);

        return (new ObjectType($className))->isSuperTypeOf($calledOnType)->yes();
    }
}
