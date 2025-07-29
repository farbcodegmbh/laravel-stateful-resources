<?php

namespace Workbench\App\Http\Resources;

use Farbcode\StatefulResources\Enums\State;
use Farbcode\StatefulResources\StatefulJsonResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\MissingValue;

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
            'fluffyness' => $this->whenStateFull($this->fluffyness),
            'color' => $this->whenState(State::Full, $this->color),
            'custom_field' => $this->whenState('custom', 'custom_value'),
            'snake_custom_field' => $this->whenStateSnakeCustom('snake_custom_value'),
            'kebab_custom_field' => $this->whenStateKebabCustom('kebab_custom_value'),
            'enemies' => $this->enemies->count() ? DogResource::collection($this->enemies) : new MissingValue,
        ];
    }
}
