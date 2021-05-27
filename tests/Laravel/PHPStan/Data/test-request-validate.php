<?php

namespace Tests\Laravel\PHPStan\Data;

use Illuminate\Http\Request;

class TestControllerUsingRequestValidation
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'test-rule' => 'required',
        ]);
    }
}
