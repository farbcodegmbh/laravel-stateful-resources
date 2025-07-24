<?php

use Workbench\App\Http\Resources\CatResource;
use Workbench\App\Models\Cat;
use Workbench\Database\Factories\CatFactory;

beforeEach(function () {
    CatFactory::new()->createOne();
});

it('can use a custom state', function () {
    /** @var TestCase $this */
    $cat = Cat::firstOrFail();

    $resource = CatResource::state('custom')->make($cat)->toJson();

    expect($resource)->toBeJson();

    expect($resource)->json()->toEqual([
        'id' => $cat->id,
        'name' => $cat->name,
        'custom_field' => 'custom_value',
    ]);
});

it('can use a custom state with a magic method', function () {
    $cat = Cat::firstOrFail();

    $resource = CatResource::custom()->make($cat)->toJson();

    expect($resource)->toBeJson();

    expect($resource)->json()->toEqual([
        'id' => $cat->id,
        'name' => $cat->name,
        'custom_field' => 'custom_value',
    ]);
});

it('can use a snake_cased state as camelCase when using the magic method', function () {
    $cat = Cat::firstOrFail();

    $resource = CatResource::snakeCustom()->make($cat)->toJson();

    expect($resource)->toBeJson();

    expect($resource)->json()->toEqual([
        'id' => $cat->id,
        'name' => $cat->name,
        'snake_custom_field' => 'snake_custom_value',
    ]);
});

it('can use a kebab-cased state as camelCase when using the magic method', function () {
    $cat = Cat::firstOrFail();

    $resource = CatResource::kebabCustom()->make($cat)->toJson();

    expect($resource)->toBeJson();

    expect($resource)->json()->toEqual([
        'id' => $cat->id,
        'name' => $cat->name,
        'kebab_custom_field' => 'kebab_custom_value',
    ]);
});

it('cannot use an unregistered state', function () {
    /** @var TestCase $this */
    $cat = Cat::firstOrFail();

    expect(fn () => CatResource::state('non_existent')->make($cat)->toJson())
        ->toThrow(InvalidArgumentException::class, 'State "non_existent" is not registered.');
});
