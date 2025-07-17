<?php

namespace Farbcode\StatefulResources\Concerns;

trait AsResourceState
{
    /**
     * Get the string value of the state.
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * Get the name of the state.
     */
    public function name(): string
    {
        return $this->name;
    }
}
