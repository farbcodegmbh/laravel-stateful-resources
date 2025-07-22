<?php

namespace Farbcode\StatefulResources;

use Farbcode\StatefulResources\Concerns\StatefullyLoadsAttributes;
use Farbcode\StatefulResources\Contracts\ResourceState;
use Farbcode\StatefulResources\Enums\Variant;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Context;

/**
 * @method static \Farbcode\StatefulResources\Builder minimal()
 * @method static \Farbcode\StatefulResources\Builder table()
 * @method static \Farbcode\StatefulResources\Builder full()
 */
abstract class StatefulJsonResource extends JsonResource
{
    use StatefullyLoadsAttributes;

    private ResourceState $state;

    /**
     * Create a new stateful resource builder with a specific state.
     */
    public static function state(ResourceState $state): Builder
    {
        return new Builder(static::class, $state);
    }

    /**
     * Retrieve the state of the stateful resource.
     */
    protected function getState(): ResourceState
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
        $this->state = Context::get('resource-state-'.static::class, Variant::Full);
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
