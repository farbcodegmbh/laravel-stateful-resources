<?php

namespace Farbcode\StatefulResources\Concerns;

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
}
