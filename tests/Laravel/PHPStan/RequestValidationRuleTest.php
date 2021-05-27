<?php

namespace Tests\Laravel\PHPStan;

use JumpTwentyFour\PhpCodingStandards\Laravel\PHPStan\RequestValidationRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

class RequestValidationRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new RequestValidationRule();
    }

    public function testRequestValidationFails(): void
    {
        $this->analyse(
            [__DIR__ . '/Data/test-request-validate.php'],
            [
                'Test Request::validate() fails' => [
                    'All request validation should be done in the form of a form request ' .
                    'https://laravel.com/docs/8.x/validation#form-request-validation and not performed inline in a ' .
                    'controller to ensure a separation of concerns.',
                    11,
                ],
            ]
        );
    }
}
