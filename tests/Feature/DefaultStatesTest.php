<?php

use Farbcode\StatefulResources\Enums\State;
use Farbcode\StatefulResources\Tests\TestCase;
use Workbench\App\Http\Resources\CatResource;
use Workbench\App\Models\Cat;
use Workbench\Database\Factories\CatFactory;

beforeEach(function () {
    CatFactory::new()->createOne();
});

it('can return a stateful resource with the default state', function () {
    /** @var TestCase $this */
    $cat = Cat::firstOrFail();

    $resource = CatResource::make($cat)->toJson();

    expect($resource)->toBeJson();

    expect($resource)->json()->toEqual([
        'id' => $cat->id,
        'name' => $cat->name,
        'breed' => $cat->breed,
        'fluffyness' => $cat->fluffyness,
        'color' => $cat->color,
    ]);

});

it('can return a stateful resource with the correct "full" state', function () {
    /** @var TestCase $this */
    $cat = Cat::firstOrFail();

    $resource = CatResource::state(State::Full)->make($cat)->toJson();

    expect($resource)->toBeJson();

    expect($resource)->json()->toEqual([
        'id' => $cat->id,
        'name' => $cat->name,
        'breed' => $cat->breed,
        'fluffyness' => $cat->fluffyness,
        'color' => $cat->color,
    ]);
});

it('can use a stateful resource with the "minimal" state', function () {
    /** @var TestCase $this */
    $cat = Cat::firstOrFail();

    $resource = CatResource::state(State::Minimal)->make($cat)->toJson();

    expect($resource)->toBeJson();

    expect($resource)->json()->toEqual([
        'id' => $cat->id,
        'name' => $cat->name,
    ]);
});

it('can use a stateful resource with the "table" state', function () {
    /** @var TestCase $this */
    $cat = Cat::firstOrFail();

    $resource = CatResource::state(State::Table)->make($cat)->toJson();

    expect($resource)->toBeJson();

    expect($resource)->json()->toEqual([
        'id' => $cat->id,
        'name' => $cat->name,
        'breed' => $cat->breed,
    ]);
});
