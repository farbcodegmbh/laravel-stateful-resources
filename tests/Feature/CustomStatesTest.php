<?php

use Workbench\App\Http\Resources\CatResource;
use Workbench\App\Models\Cat;
use Workbench\Database\Factories\CatFactory;

beforeEach(function () {
    CatFactory::new()->createOne();
});

it('can use a custom user-defined state', function () {
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

it('cannot use an unregistered state', function () {
    /** @var TestCase $this */
    $cat = Cat::firstOrFail();

    expect(fn () => CatResource::state('non_existent')->make($cat)->toJson())
        ->toThrow(InvalidArgumentException::class, 'State "non_existent" is not registered.');
});
