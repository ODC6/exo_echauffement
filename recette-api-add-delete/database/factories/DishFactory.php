<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Dish;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dish>
 */
class DishFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Dish::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->word;

        return [
            'dish_name' => $name,
            'slug' => Str::slug($name),
            'dish_ingredient' => $this->faker->text,
            'dish_recette' => $this->faker->text,
            'preparation' => $this->faker->time,
            'cuissons' => $this->faker->time,
            'temps_total' => $this->faker->time,
            'id_category' => function () {
                return Category::factory()->create()->id;
            },
        ];
    }
}
