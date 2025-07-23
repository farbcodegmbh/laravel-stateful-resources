<?php

namespace Workbench\App\Http\Resources;

use Farbcode\StatefulResources\Enums\State;
use Farbcode\StatefulResources\StatefulJsonResource;
use Illuminate\Http\Request;

class CatResource extends StatefulJsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'breed' => $this->whenStateIn([State::Full, State::Table], $this->breed),
            'fluffyness' => $this->whenStateIn([State::Full], $this->fluffyness),
            'color' => $this->whenStateIn([State::Full], $this->color),
            'custom_field' => $this->whenState('custom', 'custom_value'),
        ];
    }
}
