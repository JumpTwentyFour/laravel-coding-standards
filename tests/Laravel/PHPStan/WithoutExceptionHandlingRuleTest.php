<?php

namespace Tests\Laravel\PHPStan;

use JumpTwentyFour\LaravelCodingStandards\Laravel\PHPStan\WithoutExceptionHandlingRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

class WithoutExceptionHandlingRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new WithoutExceptionHandlingRule();
    }

    public function testWithoutExceptionHandlingFails(): void
    {
        $this->analyse(
            [__DIR__ . '/Data/test-without-exception-handling.php'],
            [
                'Test withoutExceptionHandling() fails' => [
                    'withoutExceptionHandling() should not be left in test code, remove this debugging call ' .
                    'before committing.',
                    11,
                ],
            ]
        );
    }

    public function testSimilarlyNamedMethodPasses(): void
    {
        $this->analyse(
            [__DIR__ . '/Data/test-without-exception-handling-negative.php'],
            []
        );
    }
}
