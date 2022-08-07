<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'filename' => $this->faker->slug(3) . '.jpg',
            'imageable_type' => 'App\Models\News',
            'imageable_id' => function () {
                return create('App\Models\News');
            },
            'mime' => 'image/jpg',
            'order' => $this->faker->numberBetween(0, 100),
        ];
    }
}
