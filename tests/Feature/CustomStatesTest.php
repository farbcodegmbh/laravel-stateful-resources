<?php

use Workbench\App\Enums\CustomResourceStates;
use Workbench\App\Http\Resources\CatResource;
use Workbench\App\Models\Cat;
use Workbench\Database\Factories\CatFactory;

beforeEach(function () {
    CatFactory::new()->createOne();
});

it('can use a custom user-defined state', function () {
    /** @var TestCase $this */
    $cat = Cat::firstOrFail();

    $resource = CatResource::state(CustomResourceStates::Custom)->make($cat)->toJson();

    expect($resource)->toBeJson();

    expect($resource)->json()->toEqual([
        'id' => $cat->id,
        'name' => $cat->name,
        'custom_field' => 'custom_value',
    ]);
});
