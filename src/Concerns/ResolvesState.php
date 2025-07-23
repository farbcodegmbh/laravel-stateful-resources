<?php

namespace Farbcode\StatefulResources\Concerns;

use Farbcode\StatefulResources\Contracts\ResourceState;
use Farbcode\StatefulResources\StateRegistry;

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
}
