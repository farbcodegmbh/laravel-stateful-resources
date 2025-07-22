<?php

namespace Workbench\App\Enums;

use Farbcode\StatefulResources\Contracts\ResourceState;

enum CustomResourceStates: string implements ResourceState
{
    case Custom = 'custom';
}
