<?php

namespace Farbcode\StatefulResources\Enums;

use Farbcode\StatefulResources\Concerns\AsResourceState;
use Farbcode\StatefulResources\Contracts\ResourceState;

enum Variant: string implements ResourceState
{
    use AsResourceState;

    case Minimal = 'minimal';
    case Table = 'table';
    case Full = 'full';
}
