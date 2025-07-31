<?php

namespace Farbcode\StatefulResources\Concerns;

use Farbcode\StatefulResources\ActiveState;
use Farbcode\StatefulResources\Contracts\ResourceState;
use Farbcode\StatefulResources\StateRegistry;
use Illuminate\Support\Str;

trait ResolvesState
{
    /**
     * Resolve the value of a given state.
     *
     * @throws \InvalidArgumentException
     */
    private function resolveState(ResourceState|string $state): string
    {
        $stateString = $state instanceof ResourceState ? (string) $state->value : $state;

        if (app(StateRegistry::class)->tryFrom($stateString) === null) {
            throw new \InvalidArgumentException("State \"{$stateString}\" is not registered.");
        }

        return $stateString;
    }

    /**
     * Resolve a state from a method name using various case conversions.
     */
    protected static function resolveStateFromMethodName(string $state): ?string
    {
        $registry = app(StateRegistry::class);

        $attempts = [
            strtolower($state),
            Str::snake($state),
            Str::kebab($state),
        ];

        foreach ($attempts as $attempt) {
            $stateInstance = $registry->tryFrom($attempt);
            if ($stateInstance !== null) {
                return $stateInstance;
            }
        }

        return null;
    }

    /**
     * Get the active state for the resource.
     */
    protected function getActiveState($resourceClass): string
    {
        return config()->boolean('stateful-resources.shared_state', false)
            ? app(ActiveState::class)->getShared()
            : app(ActiveState::class)->getForResource($resourceClass);
    }

    /**
     * Set the active state for the resource.
     */
    protected function setActiveState(string $resourceClass, string $state): void
    {
        config()->boolean('stateful-resources.shared_state', false)
            ? app(ActiveState::class)->setShared($state)
            : app(ActiveState::class)->setForResource($resourceClass, $state);
    }
}
