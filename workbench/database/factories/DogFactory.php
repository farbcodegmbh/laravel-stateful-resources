<?php

namespace Workbench\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Workbench\App\Models\Dog;

/**
 * @template TModel of \Workbench\App\Models\Dog
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class DogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Dog::class;

    protected $names = [
        'Buddy',
        'Max',
        'Charlie',
        'Rocky',
        'Duke',
        'Bear',
        'Toby',
        'Jack',
        'Cooper',
        'Milo',
    ];

    protected $breeds = [
        'Labrador Retriever',
        'German Shepherd',
        'Golden Retriever',
        'Bulldog',
        'Beagle',
        'Poodle',
        'Rottweiler',
        'Yorkshire Terrier',
        'Dachshund',
        'Boxer',
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
        ];
    }
}
