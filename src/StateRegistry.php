<?php

namespace Farbcode\StatefulResources;

use Farbcode\StatefulResources\Contracts\ResourceState;
use InvalidArgumentException;

/**
 * @internal
 */
class StateRegistry
{
    /**
     * @var string[] List of registered states.
     */
    private array $states = [];

    /**
     * Register a state.
     */
    public function register(string $state): void
    {
        $this->states[] = $state;
    }

    /**
     * Try to find a state by value across all registered states.
     */
    public function tryFrom(string $value): ?string
    {
        if (in_array($value, $this->states, true)) {
            return $value;
        }

        return null;
    }

    /**
     * Get all available states from all registered states.
     *
     * @return string[] List of states.
     */
    public function all(): array
    {
        return $this->states;
    }

    /**
     * Clear all registered states.
     */
    public function clear(): void
    {
        $this->states = [];
    }

    public function getDefaultState(): string
    {
        $explicitDefault = config('stateful-resources.default_state');

        if ($explicitDefault instanceof ResourceState) {
            $explicitDefault = $explicitDefault->value;
        }

        if ($explicitDefault !== null) {
            $state = $this->tryFrom($explicitDefault);
            if ($state !== null) {
                return $state;
            }
        }

        if (empty($this->states)) {
            throw new InvalidArgumentException('No states registered in the StateRegistry.');
        }

        return $this->states[0];
    }
}
