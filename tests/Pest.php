<?php

use Farbcode\StatefulResources\Tests\TestCase;
use Illuminate\Support\Facades\Facade;

uses(TestCase::class)->in(__DIR__);

/*
|--------------------------------------------------------------------------
| Utility Functions
|--------------------------------------------------------------------------
*/
function simulateNewOctaneRequest(): void
{
    app()->forgetScopedInstances();
    Facade::clearResolvedInstances();
}

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet
| certain conditions. Pest provides a fluent API for writing assertions
| starting with "expect()". You may add your own assertions to Pests
| expectation API via the extend method.
|
*/
