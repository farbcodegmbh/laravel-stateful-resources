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
     * @var array<string, ResourceState>
     */
    private array $stateClasses = [];

    /**
     * Register a state enum class.
     */
    public function register(string $stateClass): void
    {
        if (! is_subclass_of($stateClass, ResourceState::class)) {
            throw new InvalidArgumentException("State class {$stateClass} must be a valid ResourceState enum.");
        }

        $this->stateClasses[] = $stateClass;
    }

    /**
     * Try to find a state by value across all registered state classes.
     */
    public function tryFrom(string $value): ?ResourceState
    {
        foreach ($this->stateClasses as $stateClass) {
            $state = $stateClass::tryFrom($value);
            if ($state !== null) {
                return $state;
            }
        }

        return null;
    }

    /**
     * Find a state by value across all registered state classes.
     */
    public function from(string $value): ResourceState
    {
        $state = $this->tryFrom($value);

        if ($state === null) {
            throw new InvalidArgumentException("Unknown state: {$value}");
        }

        return $state;
    }

    /**
     * Get all available states from all registered classes.
     */
    public function all(): array
    {
        $states = [];
        foreach ($this->stateClasses as $stateClass) {
            $states = array_merge($states, $stateClass::cases());
        }

        return $states;
    }

    /**
     * Clear all registered state classes.
     */
    public function clear(): void
    {
        $this->stateClasses = [];
    }
}
