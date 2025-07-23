<?php

namespace Workbench\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Workbench\App\Models\Cat;

/**
 * @template TModel of \Workbench\App\Models\Cat
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class CatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Cat::class;

    protected $names = [
        'Whiskers',
        'Mittens',
        'Shadow',
        'Simba',
        'Luna',
        'Oliver',
        'Bella',
        'Charlie',
        'Lucy',
        'Max',
    ];

    protected $breeds = [
        'Siamese',
        'Persian',
        'Maine Coon',
        'Bengal',
        'British Shorthair',
        'Ragdoll',
        'Sphynx',
        'Norwegian Forest',
        'Scottish Fold',
        'Abyssinian',
    ];

    protected $fluffyness = [
        'superfluffy',
        'fluffy',
        'not-fluffy',
    ];

    protected $color = [
        'black',
        'white',
        'gray',
        'orange',
        'brown',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement($this->names),
            'breed' => $this->faker->randomElement($this->breeds),
            'fluffyness' => $this->faker->randomElement($this->fluffyness),
            'color' => $this->faker->randomElement($this->color),
        ];
    }
}
