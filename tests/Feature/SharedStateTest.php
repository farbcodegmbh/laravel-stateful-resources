<?php

use Farbcode\StatefulResources\ActiveState as ActiveStateService;
use Farbcode\StatefulResources\Enums\State;
use Farbcode\StatefulResources\Facades\ActiveState;
use Workbench\App\Http\Resources\CatResource;
use Workbench\App\Models\Cat;
use Workbench\App\Models\Dog;

it('can use shared state from previously called states in other resources', function () {
    $cat = Cat::factory()->new()->createOne();
    $dogs = Dog::factory()->count(3)->create();

    $cat->enemies()->attach($dogs->pluck('id'));

    $resource = CatResource::state('table')->make($cat)->toJson();

    expect(app(ActiveStateService::class)->getShared())->toBe('table');

    expect($resource)->toBeJson();

    expect($resource)->json()->toEqual([
        'id' => $cat->id,
        'name' => $cat->name,
        'breed' => $cat->breed,
        'enemies' => [
            [
                'id' => $dogs[0]->id,
                'name' => $dogs[0]->name,
            ],
            [
                'id' => $dogs[1]->id,
                'name' => $dogs[1]->name,
            ],
            [
                'id' => $dogs[2]->id,
                'name' => $dogs[2]->name,
            ],
        ],
    ]);
});

it('can set the shared state through the ActiveState facade', function () {
    $cat = Cat::factory()->new()->createOne();
    $dogs = Dog::factory()->count(3)->create();

    $cat->enemies()->attach($dogs->pluck('id'));

    ActiveState::setShared('table');

    $resource = CatResource::make($cat)->toJson();

    expect(app(ActiveStateService::class)->getShared())->toBe('table');

    expect($resource)->toBeJson();

    expect($resource)->json()->toEqual([
        'id' => $cat->id,
        'name' => $cat->name,
        'breed' => $cat->breed,
        'enemies' => [
            [
                'id' => $dogs[0]->id,
                'name' => $dogs[0]->name,
            ],
            [
                'id' => $dogs[1]->id,
                'name' => $dogs[1]->name,
            ],
            [
                'id' => $dogs[2]->id,
                'name' => $dogs[2]->name,
            ],
        ],
    ]);
});

it('can set the shared state through the resourceState helper function', function () {
    $cat = Cat::factory()->new()->createOne();
    $dogs = Dog::factory()->count(3)->create();

    $cat->enemies()->attach($dogs->pluck('id'));

    resourceState()->setShared(State::Table);

    $resource = CatResource::make($cat)->toJson();

    expect(resourceState()->matchesShared(State::Table))->toBeTrue();

    expect($resource)->toBeJson();

    expect($resource)->json()->toEqual([
        'id' => $cat->id,
        'name' => $cat->name,
        'breed' => $cat->breed,
        'enemies' => [
            [
                'id' => $dogs[0]->id,
                'name' => $dogs[0]->name,
            ],
            [
                'id' => $dogs[1]->id,
                'name' => $dogs[1]->name,
            ],
            [
                'id' => $dogs[2]->id,
                'name' => $dogs[2]->name,
            ],
        ],
    ]);
});

it('can set the shared state through the resourceState helper function and the genereal purpose methods', function () {
    $cat = Cat::factory()->new()->createOne();
    $dogs = Dog::factory()->count(3)->create();

    $cat->enemies()->attach($dogs->pluck('id'));

    resourceState()->set(State::Table);

    $resource = CatResource::make($cat)->toJson();

    expect(resourceState()->matches(State::Table))->toBeTrue();

    expect($resource)->toBeJson();

    expect($resource)->json()->toEqual([
        'id' => $cat->id,
        'name' => $cat->name,
        'breed' => $cat->breed,
        'enemies' => [
            [
                'id' => $dogs[0]->id,
                'name' => $dogs[0]->name,
            ],
            [
                'id' => $dogs[1]->id,
                'name' => $dogs[1]->name,
            ],
            [
                'id' => $dogs[2]->id,
                'name' => $dogs[2]->name,
            ],
        ],
    ]);
});

it('works correctly when shared state is disabled', function () {
    config()->set('stateful-resources.shared_state', false);

    $cat = Cat::factory()->new()->createOne();
    $dogs = Dog::factory()->count(3)->create();

    $cat->enemies()->attach($dogs->pluck('id'));

    $resource = CatResource::state('table')->make($cat)->toJson();

    expect(app(ActiveStateService::class)->getForResource(CatResource::class))->toBe('table');

    expect($resource)->toBeJson();

    expect($resource)->json()->toEqual([
        'id' => $cat->id,
        'name' => $cat->name,
        'breed' => $cat->breed,
        'enemies' => [
            [
                'id' => $dogs[0]->id,
                'name' => $dogs[0]->name,
                'breed' => $dogs[0]->breed,
            ],
            [
                'id' => $dogs[1]->id,
                'name' => $dogs[1]->name,
                'breed' => $dogs[1]->breed,
            ],
            [
                'id' => $dogs[2]->id,
                'name' => $dogs[2]->name,
                'breed' => $dogs[2]->breed,
            ],
        ],
    ]);
});
