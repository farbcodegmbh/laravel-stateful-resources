<?php

use Farbcode\StatefulResources\ActiveState;

if (! function_exists('activeResourceState')) {
    function activeResourceState(): ActiveState
    {
        return app(ActiveState::class);
    }
}
