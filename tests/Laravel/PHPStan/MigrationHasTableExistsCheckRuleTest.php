<?php

namespace Tests\Laravel\PHPStan;

use JumpTwentyFour\LaravelCodingStandards\Laravel\PHPStan\MigrationHasTableExistsCheckRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

class MigrationHasTableExistsCheckRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new MigrationHasTableExistsCheckRule();
    }

    public function testHasTableCheckMissingInTableCreation(): void
    {
        $this->analyse(
            [__DIR__ . '/Data/test-migration-up-hastable-missing.php'],
            [
                'Test captures missing hasTable check when creating table' => [
                    'Cannot create table in migration without hasTable check to check the table does not already
        exist on the environment. This can particularly be an issue when running migrations on a legacy database
        with no concept of migrations. Please add a Schema::hasTable() check to your migration file before the create
        method.',
                    13,
                ],
            ]
        );
    }

    public function testHasTableCheckExistsInTableCreation(): void
    {
        $this->analyse(
            [__DIR__ . '/Data/test-migration-up-hastable-exists.php'],
            []
        );
    }
}
