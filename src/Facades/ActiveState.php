<?php

namespace Farbcode\StatefulResources\Facades;

use Farbcode\StatefulResources\ActiveState as ActiveStateService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void setShared(string $state)
 * @method static string getShared()
 * @method static void setForResource(string $resourceClass, string $state)
 * @method static string getForResource(string $resourceClass)
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
