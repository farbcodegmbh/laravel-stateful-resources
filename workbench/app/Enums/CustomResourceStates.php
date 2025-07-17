<?php

namespace Workbench\App\Enums;

use Farbcode\StatefulResources\Concerns\AsResourceState;
use Farbcode\StatefulResources\Contracts\ResourceState;

enum CustomResourceStates: string implements ResourceState
{
    use AsResourceState;

    case Custom = 'custom';
}
