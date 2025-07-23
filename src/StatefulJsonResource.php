<?php

namespace Farbcode\StatefulResources;

use Farbcode\StatefulResources\Concerns\StatefullyLoadsAttributes;
use Farbcode\StatefulResources\Contracts\ResourceState;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Context;

abstract class StatefulJsonResource extends JsonResource
{
    use StatefullyLoadsAttributes;

    private string $state;

    /**
     * Create a new stateful resource builder with a specific state.
     */
    public static function state(string|ResourceState $state): Builder
    {
        return new Builder(static::class, $state);
    }

    /**
     * Retrieve the state of the stateful resource.
     */
    protected function getState(): string
    {
        return $this->state;
    }

    /**
     * Create a new stateful resource instance.
     *
     * @param  mixed  $resource
     */
    public function __construct($resource)
    {
        $defaultState = app(StateRegistry::class)->getDefaultState();

        $this->state = Context::get('resource-state-'.static::class, $defaultState);
        parent::__construct($resource);
    }

    /**
     * Handle dynamic method calls for resource states.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return \Farbcode\StatefulResources\Builder
     *
     * @throws \BadMethodCallException
     */
    public static function __callStatic($method, $parameters)
    {
        $state = app(StateRegistry::class)->tryFrom($method);

        if ($state === null) {
            return parent::__callStatic($method, $parameters);
        }

        return new Builder(static::class, $state);
    }
}
