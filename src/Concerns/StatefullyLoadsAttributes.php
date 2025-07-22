<?php

namespace Farbcode\StatefulResources\Concerns;

use Farbcode\StatefulResources\Contracts\ResourceState;
use Farbcode\StatefulResources\StateRegistry;
use Illuminate\Http\Resources\ConditionallyLoadsAttributes;
use Illuminate\Http\Resources\MergeValue;
use Illuminate\Http\Resources\MissingValue;

/**
 * @see \Illuminate\Http\Resources\ConditionallyLoadsAttributes
 *
 * @method MissingValue|mixed whenStateMinimal(mixed $value, mixed $default = null)
 * @method MissingValue|mixed unlessStateMinimal(mixed $value, mixed $default = null)
 * @method MissingValue|mixed whenStateFull(mixed $value, mixed $default = null)
 * @method MissingValue|mixed unlessStateFull(mixed $value, mixed $default = null)
 * @method MissingValue|mixed whenStateTable(mixed $value, mixed $default = null)
 * @method MissingValue|mixed unlessStateTable(mixed $value, mixed $default = null)
 * @method MergeValue|mixed mergeWhenStateMinimal(mixed $value, mixed $default = null)
 * @method MergeValue|mixed mergeUnlessStateMinimal(mixed $value, mixed $default = null)
 * @method MergeValue|mixed mergeWhenStateFull(mixed $value, mixed $default = null)
 * @method MergeValue|mixed mergeUnlessStateFull(mixed $value, mixed $default = null)
 * @method MissingValue|mixed whenStateTable(mixed $value, mixed $default = null)
 * @method MissingValue|mixed unlessStateTable(mixed $value, mixed $default = null)
 */
trait StatefullyLoadsAttributes
{
    use ConditionallyLoadsAttributes;

    /**
     * Retrieve a value if the current state matches the given state.
     *
     * @param  ResourceState  $state
     * @param  mixed  $value
     * @param  mixed  $default
     * @return \Illuminate\Http\Resources\MissingValue|mixed
     */
    protected function whenState($state, $value, $default = null)
    {
        if (func_num_args() === 3) {
            return $this->when($this->getState() === $state, $value, $default);
        }

        return $this->when($this->getState() === $state, $value);
    }

    /**
     * Retrieve a value unless the current state matches the given state.
     *
     * @param  ResourceState  $state
     * @param  mixed  $value
     * @param  mixed  $default
     * @return \Illuminate\Http\Resources\MissingValue|mixed
     */
    protected function unlessState($state, $value, $default = null)
    {
        if (func_num_args() === 3) {
            return $this->unless($this->getState() === $state, $value, $default);
        }

        return $this->unless($this->getState() === $state, $value);
    }

    /**
     * Retrieve a value if the current state is one of the given states.
     *
     * @param  array<ResourceState>  $states
     * @param  mixed  $value
     * @param  mixed  $default
     * @return \Illuminate\Http\Resources\MissingValue|mixed
     */
    protected function whenStateIn(array $states, $value, $default = null)
    {
        $condition = in_array($this->getState(), $states, true);

        if (func_num_args() === 3) {
            return $this->when($condition, $value, $default);
        }

        return $this->when($condition, $value);
    }

    /**
     * Retrieve a value unless the current state is one of the given states.
     *
     * @param  array<ResourceState>  $states
     * @param  mixed  $value
     * @param  mixed  $default
     * @return \Illuminate\Http\Resources\MissingValue|mixed
     */
    protected function unlessStateIn(array $states, $value, $default = null)
    {
        $condition = in_array($this->getState(), $states, true);

        if (func_num_args() === 3) {
            return $this->unless($condition, $value, $default);
        }

        return $this->unless($condition, $value);
    }

    /**
     * Merge a value if the current state matches the given state.
     *
     * @param  ResourceState  $state
     * @param  mixed  $value
     * @param  mixed  $default
     * @return \Illuminate\Http\Resources\MergeValue|mixed
     */
    protected function mergeWhenState($state, $value, $default = null)
    {
        if (func_num_args() === 3) {
            return $this->mergeWhen($this->getState() === $state, $value, $default);
        }

        return $this->mergeWhen($this->getState() === $state, $value);
    }

    /**
     * Merge a value unless the current state matches the given state.
     *
     * @param  ResourceState  $state
     * @param  mixed  $value
     * @param  mixed  $default
     * @return \Illuminate\Http\Resources\MergeValue|mixed
     */
    protected function mergeUnlessState($state, $value, $default = null)
    {
        if (func_num_args() === 3) {
            return $this->mergeUnless($this->getState() === $state, $value, $default);
        }

        return $this->mergeUnless($this->getState() === $state, $value);
    }

    /**
     * Get the current state of the resource.
     * This method should be implemented by the class using this trait.
     */
    abstract protected function getState(): ResourceState;

    public function __call($method, $parameters)
    {
        $singleStateMethods = [
            'whenState',
            'unlessState',
            'mergeWhenState',
            'mergeUnlessState',
        ];

        foreach ($singleStateMethods as $singleStateMethod) {
            if (str_starts_with($method, $singleStateMethod)) {
                $state = strtolower(substr($method, strlen($singleStateMethod)));
                if (empty($state)) {
                    continue;
                }

                $stateInstance = app(StateRegistry::class)->tryFrom($state);

                if ($stateInstance === null) {
                    continue;
                }

                return $this->{$singleStateMethod}($stateInstance, ...$parameters);
            }
        }

        return parent::__call($method, $parameters);
    }
}
