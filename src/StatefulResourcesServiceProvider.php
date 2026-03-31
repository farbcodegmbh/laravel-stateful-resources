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
            ->hasCommands([
                Console\Commands\StatefulResourceMakeCommand::class,
            ])
            ->hasConfigFile();
    }

    public function bootingPackage(): void
    {
        $states = config()->collection('stateful-resources.states');

        $this->app->singleton(StateRegistry::class, function () use ($states) {
            $registry = new StateRegistry;

            $states->each(function (string|ResourceState $state) use ($registry) {
                if ($state instanceof ResourceState) {
                    $state = $state->value;
                }
                $registry->register($state);
            });

            return $registry;
        });

        $this->app->scoped(ActiveState::class, function () {
            return new ActiveState;
        });
    }
}
