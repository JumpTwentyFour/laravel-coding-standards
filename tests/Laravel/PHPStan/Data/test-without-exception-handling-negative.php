<?php

namespace Tests\Laravel\PHPStan\Data;

use Illuminate\Foundation\Testing\TestCase;

class TestWithoutExceptionHandlingNegative extends TestCase
{
    public function testSomething(): void
    {
        $this->withoutMiddleware();
    }
}
