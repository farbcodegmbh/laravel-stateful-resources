<?php

namespace Farbcode\StatefulResources\Enums;

use Farbcode\StatefulResources\Contracts\ResourceState;

enum Variant: string implements ResourceState
{
    case Minimal = 'minimal';
    case Table = 'table';
    case Full = 'full';
}
