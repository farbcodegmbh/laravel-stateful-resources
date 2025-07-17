<?php

namespace Farbcode\StatefulResources\Contracts;

interface ResourceState
{
    /**
     * Get the string value of the state.
     */
    public function value(): string;

    /**
     * Get the name of the state.
     */
    public function name(): string;

    /**
     * Create a state instance from a string value.
     */
    public static function from(string $value): static;

    /**
     * Try to create a state instance from a string value.
     */
    public static function tryFrom(string $value): ?static;

    /**
     * Get all available states.
     */
    public static function cases(): array;
}
