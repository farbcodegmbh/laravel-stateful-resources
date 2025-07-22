<?php

namespace Farbcode\StatefulResources\Enums;

use Farbcode\StatefulResources\Contracts\ResourceState;

enum Variant: string implements ResourceState
{
    case Full = 'full';
    case Table = 'table';
    case Minimal = 'minimal';
}
