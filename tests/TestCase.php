<?php

namespace Farbcode\StatefulResources\Tests;

use Farbcode\StatefulResources\StatefulResourcesServiceProvider;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use WithWorkbench;

    protected $loadEnvironmentVariables = false;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            StatefulResourcesServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        //
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        //
    }
}
