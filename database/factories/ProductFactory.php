<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id'        => Str::random(10),
            'product_name'      => fake()->name(),
            'product_brand'     => "Raymond",
            'gender'            => "men",
            'price'             => 100000,
            'description'       => fake()->paragraph(),
            'primary_color'     => fake()->randomElement([]),

            'jenis_pakaian'     => fake()->randomElement(['T-Shirt', 'Shirt', 'Blouse', 'Jacket', 'Hoodie', 'Sweater',
                                        'Jeans', 'Trousers', 'Shorts', 'Skirt',
                                        'Dress', 'Tunic', 'Outerwear', 'Cardigan', 'Pajamas', 'Set Outfit']),
            'quantity'          => 10,
            'discount'          => 10 / 100,
            'is_active'         => 1,
            'foto'              => fake()->name(),
        ];
    }
}
