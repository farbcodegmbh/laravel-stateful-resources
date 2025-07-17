<?php

namespace Farbcode\StatefulResources;

use Farbcode\StatefulResources\Contracts\ResourceState;
use Illuminate\Support\Facades\Context;

/**
 * Builder for creating resource instances with a specific state.
 *
 * @internal
 */
class Builder
{
    private string $resourceClass;

    private ResourceState $state;

    public function __construct(string $resourceClass, ResourceState $state)
    {
        $this->resourceClass = $resourceClass;
        $this->state = $state;
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
