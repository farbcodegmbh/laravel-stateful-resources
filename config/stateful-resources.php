<?php

use Farbcode\StatefulResources\Enums\Variant;

return [
    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    |
    | Below you may register the resource states that you want to use inside
    | your stateful resources. These can be instances of a ResourceState
    | or simple strings.
    |
    */
    'states' => [
        ...Variant::cases(),
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Default State
    |--------------------------------------------------------------------------
    |
    | This state will be used when no state is explicitly set on the resource.
    | If not set, the first state in the states array will be used.
    |
    */
    'default_state' => Variant::Full,
];
