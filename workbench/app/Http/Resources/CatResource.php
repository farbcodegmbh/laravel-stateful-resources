<?php

namespace Workbench\App\Http\Resources;

use Farbcode\StatefulResources\Enums\Variant;
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
            'breed' => $this->whenStateIn([Variant::Full, Variant::Table], $this->breed),
            'fluffyness' => $this->whenStateIn([Variant::Full], $this->fluffyness),
            'color' => $this->whenStateIn([Variant::Full], $this->color),
            'custom_field' => $this->whenState('custom', 'custom_value'),
        ];
    }
}
