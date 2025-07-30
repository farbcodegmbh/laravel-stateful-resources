<?php

namespace Farbcode\StatefulResources\Facades;

use Farbcode\StatefulResources\ActiveState as ActiveStateService;
use Farbcode\StatefulResources\Contracts\ResourceState;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void setShared(string|ResourceState $state)
 * @method static string getShared()
 * @method static void setForResource(string $resourceClass, string|ResourceState $state)
 * @method static string getForResource(string $resourceClass)
 * @method static bool matchesShared(string|ResourceState $state)
 * @method static bool matchesResource(string $resourceClass, string|ResourceState $state)
 * @method static string get(?string $resourceClass = null)
 * @method static void set(string|ResourceState $state, ?string $resourceClass = null)
 * @method static bool matches(string|ResourceState $state, ?string $resourceClass = null)
 */
class ActiveState extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return ActiveStateService::class;
    }
}
