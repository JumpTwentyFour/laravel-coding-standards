<?php

namespace JumpTwentyFour\PhpCodingStandards\Laravel\PHPStan;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Type\ObjectType;

class RequestValidationRule implements Rule
{
    public function getNodeType(): string
    {
        return MethodCall::class;
    }

    /**
     * @return string[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (!$node->name instanceof Node\Identifier || $node->name->toString() !== 'validate') {
            return [];
        }
        if (
            !$this->isCalledOn($node->var, $scope, Request::class)
            && !$this->isCalledOn($node->var, $scope, Controller::class)
        ) {
            // Method was not called on a Request or Controller, so no errors.
            return [];
        }

        $message = 'All request validation should be done in the form of a form request ' .
            'https://laravel.com/docs/8.x/validation#form-request-validation and not performed inline in a ' .
            'controller to ensure a separation of concerns.';

        return [$message];
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
