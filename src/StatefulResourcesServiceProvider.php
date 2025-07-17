<?php

namespace Farbcode\StatefulResources;

use Farbcode\StatefulResources\Enums\Variant;
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
        $customStates = config()->array('stateful-resources.custom_states');

        $this->app->singleton(StateRegistry::class, function () use ($customStates) {
            $registry = new StateRegistry;

            $registry->register(Variant::class);

            foreach ($customStates as $stateClass) {
                $registry->register($stateClass);
            }

            return $registry;
        });
    }
}
