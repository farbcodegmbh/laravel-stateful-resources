<?php

namespace Workbench\App\Http\Resources;

use Farbcode\StatefulResources\Enums\State;
use Farbcode\StatefulResources\StatefulJsonResource;
use Illuminate\Http\Request;

class DogResource extends StatefulJsonResource
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
            'breed' => $this->whenState(State::Full, $this->breed),
        ];
    }
}
