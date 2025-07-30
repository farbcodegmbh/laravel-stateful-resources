<?php

namespace Farbcode\StatefulResources;

use Farbcode\StatefulResources\Concerns\ResolvesState;
use Farbcode\StatefulResources\Contracts\ResourceState;

/**
 * Builder for creating resource instances with a specific state.
 *
 * @internal
 */
class Builder
{
    use ResolvesState;

    private string $resourceClass;

    private string $state;

    public function __construct(string $resourceClass, string|ResourceState $state)
    {
        $state = $this->resolveState($state);

        $registeredState = app(StateRegistry::class)->tryFrom($state);

        if ($registeredState === null) {
            throw new \InvalidArgumentException("State \"{$state}\" is not registered.");
        }

        $this->resourceClass = $resourceClass;
        $this->state = $registeredState;
    }

    /**
     * Create a single resource instance.
     */
    public function make(...$parameters)
    {
        $this->setActiveState($this->resourceClass, $this->state);

        return $this->resourceClass::make(...$parameters);
    }

    /**
     * Create a resource collection.
     */
    public function collection($resource)
    {
        $this->setActiveState($this->resourceClass, $this->state);

        return $this->resourceClass::collection($resource);
    }

    /**
     * Magic method to handle direct instantiation.
     */
    public function __invoke($resource)
    {
        return $this->make($resource);
    }
}
