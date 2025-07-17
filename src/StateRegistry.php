<?php

namespace Farbcode\StatefulResources;

use Farbcode\StatefulResources\Contracts\ResourceState;
use InvalidArgumentException;

/**
 * @internal
 */
class StateRegistry
{
    private static array $stateClasses = [];

    /**
     * Register a state enum class.
     */
    public static function register(string $stateClass): void
    {
        if (! is_subclass_of($stateClass, ResourceState::class)) {
            throw new InvalidArgumentException("State class {$stateClass} must implement the ResourceState interface.");
        }

        self::$stateClasses[] = $stateClass;
    }

    /**
     * Try to find a state by value across all registered state classes.
     */
    public static function tryFrom(string $value): ?ResourceState
    {
        foreach (self::$stateClasses as $stateClass) {
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
    public static function from(string $value): ResourceState
    {
        $state = self::tryFrom($value);

        if ($state === null) {
            throw new InvalidArgumentException("Unknown state: {$value}");
        }

        return $state;
    }

    /**
     * Get all available states from all registered classes.
     */
    public static function all(): array
    {
        $states = [];
        foreach (self::$stateClasses as $stateClass) {
            $states = array_merge($states, $stateClass::cases());
        }

        return $states;
    }

    /**
     * Clear all registered state classes.
     */
    public static function clear(): void
    {
        self::$stateClasses = [];
    }
}
