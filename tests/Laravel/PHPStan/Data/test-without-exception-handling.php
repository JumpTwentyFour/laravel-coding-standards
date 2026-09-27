<?php

namespace Tests\Laravel\PHPStan\Data;

use Illuminate\Foundation\Testing\TestCase;

class TestWithoutExceptionHandling extends TestCase
{
    public function testSomething(): void
    {
        $this->withoutExceptionHandling();
    }
}
