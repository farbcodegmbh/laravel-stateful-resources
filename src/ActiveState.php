<?php

namespace Farbcode\StatefulResources;

use Farbcode\StatefulResources\Concerns\ResolvesState;
use Farbcode\StatefulResources\Contracts\ResourceState;

/**
 * ActiveState manages which state is currently active for resources.
 */
class ActiveState
{
    use ResolvesState;

    private ?string $sharedState;

    private array $resourceStates = [];

    public function __construct()
    {
        $this->sharedState = null;
    }

    /**
     * Set the shared state for all resources.
     */
    public function setShared(string|ResourceState $state): void
    {
        $state = $this->resolveState($state);
        $this->sharedState = $state;
    }

    /**
     * Get the shared state.
     */
    public function getShared(): string
    {
        return $this->sharedState ?? app(StateRegistry::class)->getDefaultState();
    }

    /**
     * Check if a specific resource class has a state set.
     */
    public function matchesShared(string|ResourceState $state): bool
    {
        $state = $this->resolveState($state);

        return $this->getShared() === $state;
    }

    /**
     * Set the state for a specific resource class.
     */
    public function setForResource(string $resourceClass, string|ResourceState $state): void
    {
        $state = $this->resolveState($state);
        $this->resourceStates[$resourceClass] = $state;
    }

    /**
     * Get the state for a specific resource class.
     */
    public function getForResource(string $resourceClass): string
    {
        return $this->resourceStates[$resourceClass] ?? app(StateRegistry::class)->getDefaultState();
    }

    /**
     * Check if the current state matches the resource's state.
     */
    public function matchesResource(string $resourceClass, string|ResourceState $state): bool
    {
        $state = $this->resolveState($state);

        return $this->getForResource($resourceClass) === $state;
    }

    /**
     * Get the current state for a resource.
     * If no resource class is provided, returns the shared state.
     */
    public function get(?string $resourceClass = null): string
    {
        if ($resourceClass === null) {
            return $this->getShared();
        }

        return $this->getForResource($resourceClass);
    }

    /**
     * Set the current state for a resource.
     * If no resource class is provided, sets the shared state.
     */
    public function set(string|ResourceState $state, ?string $resourceClass = null): void
    {
        $state = $this->resolveState($state);

        if ($resourceClass === null) {
            $this->setShared($state);
        } else {
            $this->setForResource($resourceClass, $state);
        }
    }

    /**
     * Check if the current state matches the given state for a resource.
     * If no resource class is provided, checks against the shared state.
     */
    public function matches(string|ResourceState $state, ?string $resourceClass = null): bool
    {
        $state = $this->resolveState($state);

        if ($resourceClass === null) {
            return $this->matchesShared($state);
        }

        return $this->matchesResource($resourceClass, $state);
    }
}
