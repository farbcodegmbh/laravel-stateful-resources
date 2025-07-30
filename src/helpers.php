<?php

use Farbcode\StatefulResources\ActiveState;

if (! function_exists('resourceState')) {
    function resourceState(): ActiveState
    {
        return app(ActiveState::class);
    }
}
