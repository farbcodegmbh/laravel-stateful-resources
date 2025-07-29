<?php

namespace Farbcode\StatefulResources;

/**
 * ActiveState manages which state is currently active for resources.
 */
class ActiveState
{
    private ?string $sharedState;

    private array $resourceStates = [];

    public function __construct()
    {
        $this->sharedState = null;
    }

    /**
     * Set the shared state for all resources.
     */
    public function setShared(string $state): void
    {
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
     * Set the state for a specific resource class.
     */
    public function setForResource(string $resourceClass, string $state): void
    {
        $this->resourceStates[$resourceClass] = $state;
    }

    /**
     * Get the state for a specific resource class.
     */
    public function getForResource(string $resourceClass): string
    {
        return $this->resourceStates[$resourceClass] ?? app(StateRegistry::class)->getDefaultState();
    }
}
