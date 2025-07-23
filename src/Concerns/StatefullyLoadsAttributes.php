<?php

namespace Farbcode\StatefulResources\Concerns;

use Farbcode\StatefulResources\Contracts\ResourceState;
use Farbcode\StatefulResources\StateRegistry;
use Illuminate\Http\Resources\ConditionallyLoadsAttributes;

/**
 * @see \Illuminate\Http\Resources\ConditionallyLoadsAttributes
 */
trait StatefullyLoadsAttributes
{
    use ConditionallyLoadsAttributes, ResolvesState;

    /**
     * Retrieve a value if the current state matches the given state.
     *
     * @param  string|ResourceState  $state
     * @param  mixed  $value
     * @param  mixed  $default
     * @return \Illuminate\Http\Resources\MissingValue|mixed
     */
    protected function whenState($state, $value, $default = null)
    {
        $state = $this->resolveState($state);

        if (func_num_args() === 3) {
            return $this->when($this->getState() === $state, $value, $default);
        }

        return $this->when($this->getState() === $state, $value);
    }

    /**
     * Retrieve a value unless the current state matches the given state.
     *
     * @param  string|ResourceState  $state
     * @param  mixed  $value
     * @param  mixed  $default
     * @return \Illuminate\Http\Resources\MissingValue|mixed
     */
    protected function unlessState($state, $value, $default = null)
    {
        $state = $this->resolveState($state);

        if (func_num_args() === 3) {
            return $this->unless($this->getState() === $state, $value, $default);
        }

        return $this->unless($this->getState() === $state, $value);
    }

    /**
     * Retrieve a value if the current state is one of the given states.
     *
     * @param  array<string|ResourceState>  $states
     * @param  mixed  $value
     * @param  mixed  $default
     * @return \Illuminate\Http\Resources\MissingValue|mixed
     */
    protected function whenStateIn(array $states, $value, $default = null)
    {
        $states = array_map(fn ($state) => $this->resolveState($state), $states);

        $condition = in_array($this->getState(), $states, true);

        if (func_num_args() === 3) {
            return $this->when($condition, $value, $default);
        }

        return $this->when($condition, $value);
    }

    /**
     * Retrieve a value unless the current state is one of the given states.
     *
     * @param  array<string|ResourceState>  $states
     * @param  mixed  $value
     * @param  mixed  $default
     * @return \Illuminate\Http\Resources\MissingValue|mixed
     */
    protected function unlessStateIn(array $states, $value, $default = null)
    {
        $states = array_map(fn ($state) => $this->resolveState($state), $states);

        $condition = in_array($this->getState(), $states, true);

        if (func_num_args() === 3) {
            return $this->unless($condition, $value, $default);
        }

        return $this->unless($condition, $value);
    }

    /**
     * Merge a value if the current state matches the given state.
     *
     * @param  string|ResourceState  $state
     * @param  mixed  $value
     * @param  mixed  $default
     * @return \Illuminate\Http\Resources\MergeValue|mixed
     */
    protected function mergeWhenState($state, $value, $default = null)
    {
        $state = $this->resolveState($state);

        if (func_num_args() === 3) {
            return $this->mergeWhen($this->getState() === $state, $value, $default);
        }

        return $this->mergeWhen($this->getState() === $state, $value);
    }

    /**
     * Merge a value unless the current state matches the given state.
     *
     * @param  string|ResourceState  $state
     * @param  mixed  $value
     * @param  mixed  $default
     * @return \Illuminate\Http\Resources\MergeValue|mixed
     */
    protected function mergeUnlessState($state, $value, $default = null)
    {
        $state = $this->resolveState($state);

        if (func_num_args() === 3) {
            return $this->mergeUnless($this->getState() === $state, $value, $default);
        }

        return $this->mergeUnless($this->getState() === $state, $value);
    }

    /**
     * Get the current state of the resource.
     * This method should be implemented by the class using this trait.
     */
    abstract protected function getState(): string;

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
