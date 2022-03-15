<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = Str::random(40).'.png';

        return [
            'name' => $name,
            'path' => 'pet-shop/'.$name,
            'size' => $this->faker->numberBetween(2000),
            'type' => 'png',
        ];
    }
}
