<?php

namespace Farbcode\StatefulResources;

use Farbcode\StatefulResources\Contracts\ResourceState;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class StatefulResourcesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('stateful-resources')
            ->hasConfigFile();
    }

    public function bootingPackage(): void
    {
        $states = config()->array('stateful-resources.states');

        $this->app->singleton(StateRegistry::class, function () use ($states) {
            $registry = new StateRegistry;

            foreach ($states as $state) {
                if ($state instanceof ResourceState) {
                    $state = $state->value;
                }
                $registry->register($state);
            }

            return $registry;
        });
    }
}
