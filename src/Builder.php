<?php

namespace Farbcode\StatefulResources;

use Farbcode\StatefulResources\Concerns\ResolvesState;
use Farbcode\StatefulResources\Contracts\ResourceState;
use Illuminate\Support\Facades\Context;

/**
 * Builder for creating resource instances with a specific state.
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
    public function make($resource)
    {
        return Context::scope(function () use ($resource) {
            return $this->resourceClass::make($resource);
        }, ['resource-state-'.$this->resourceClass => $this->state]);
    }

    /**
     * Create a resource collection.
     */
    public function collection($resource)
    {
        return Context::scope(function () use ($resource) {
            return $this->resourceClass::collection($resource);
        }, ['resource-state-'.$this->resourceClass => $this->state]);
    }

    /**
     * Magic method to handle direct instantiation.
     */
    public function __invoke($resource)
    {
        return $this->make($resource);
    }
}
