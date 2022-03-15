<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $category = Category::all()->random();
        $brand = Brand::all()->random();
        $image = File::all()->random();

        return [
            'title' => implode(' ', $this->faker->words),
            'price' => $this->faker->randomFloat(2, 20, 3000),
            'description' => $this->faker->text,
            'metadata' => [
                'brand' => $brand->uuid,
                'image' => $image->uuid,
            ],
            'category_uuid' => $category->uuid,
        ];
    }
}
