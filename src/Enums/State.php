<?php

namespace Farbcode\StatefulResources\Enums;

use Farbcode\StatefulResources\Contracts\ResourceState;

enum State: string implements ResourceState
{
    case Full = 'full';
    case Table = 'table';
    case Minimal = 'minimal';
}
