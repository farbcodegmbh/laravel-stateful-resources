<?php

use Farbcode\StatefulResources\Tests\TestCase;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    $this->testResourcePath = app_path('Http/Resources/TestResource.php');
});

afterEach(function () {
    if (File::exists($this->testResourcePath)) {
        File::delete($this->testResourcePath);
    }
});

it('can create a new stateful resource', function () {
    /** @var TestCase $this */
    $this->artisan('make:stateful-resource', [
        'name' => 'TestResource',
    ])
        ->assertExitCode(0)
        ->expectsOutputToContain('created successfully.');

    $this->assertFileExists(app_path('Http/Resources/TestResource.php'));
});