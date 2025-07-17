<?php

namespace Farbcode\StatefulResources\Enums;

enum ResourceState: string
{
    case Minimal = 'minimal';
    case Table = 'table';
    case Full = 'full';
}
